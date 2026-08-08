<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Batch;
use App\Models\Booking;
use App\Models\MedicationDispense;
use App\Models\MedicationDispenseItem;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryService
{
    /**
     * Stock In operation (Goods Received / Direct Addition).
     */
    public function stockIn(
        Warehouse $warehouse,
        Product $product,
        string $batchNumber,
        string $expiryDate,
        int $quantity,
        float $buyPrice,
        float $sellPrice,
        ?User $user = null,
        ?string $refType = null,
        ?int $refId = null,
        ?string $notes = null
    ): Batch {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('الكمية المضافة يجب أن تكون أكبر من صفر.');
        }

        return DB::transaction(function () use ($warehouse, $product, $batchNumber, $expiryDate, $quantity, $buyPrice, $sellPrice, $user, $refType, $refId, $notes) {
            $batch = Batch::firstOrCreate(
                [
                    'product_id' => $product->id,
                    'warehouse_id' => $warehouse->id,
                    'batch_number' => $batchNumber,
                ],
                [
                    'expiry_date' => $expiryDate,
                    'quantity' => 0,
                    'reserved_quantity' => 0,
                    'buy_price' => $buyPrice,
                    'sell_price' => $sellPrice,
                ]
            );

            $batch->increment('quantity', $quantity);

            $movementNumber = 'MOV-IN-' . strtoupper(Str::random(10));
            $movement = StockMovement::create([
                'movement_number' => $movementNumber,
                'product_id' => $product->id,
                'batch_id' => $batch->id,
                'to_warehouse_id' => $warehouse->id,
                'type' => 'stock_in',
                'quantity' => $quantity,
                'user_id' => $user ? $user->id : auth()->id(),
                'reference_type' => $refType,
                'reference_id' => $refId,
                'notes' => $notes ?? 'إضافة مخزون جديد / استلام شحنة',
            ]);

            AuditLog::log('STOCK_IN', $batch, [], [
                'warehouse_id' => $warehouse->id,
                'quantity' => $quantity,
                'batch_number' => $batchNumber,
            ]);

            return $batch;
        });
    }

    /**
     * Stock Transfer between warehouses.
     */
    public function transferStock(
        Warehouse $fromWarehouse,
        Warehouse $toWarehouse,
        Batch $sourceBatch,
        int $quantity,
        User $user,
        ?string $notes = null
    ): Batch {
        if ($quantity <= 0 || $sourceBatch->available_quantity < $quantity) {
            throw new \InvalidArgumentException('الكمية المراد نقلها غير متوفرة في المستودع المصدر.');
        }

        return DB::transaction(function () use ($fromWarehouse, $toWarehouse, $sourceBatch, $quantity, $user, $notes) {
            $sourceBatch->decrement('quantity', $quantity);

            $destBatch = Batch::firstOrCreate(
                [
                    'product_id' => $sourceBatch->product_id,
                    'warehouse_id' => $toWarehouse->id,
                    'batch_number' => $sourceBatch->batch_number,
                ],
                [
                    'expiry_date' => $sourceBatch->expiry_date,
                    'quantity' => 0,
                    'reserved_quantity' => 0,
                    'buy_price' => $sourceBatch->buy_price,
                    'sell_price' => $sourceBatch->sell_price,
                ]
            );

            $destBatch->increment('quantity', $quantity);

            $movementNumber = 'MOV-TR-' . strtoupper(Str::random(10));
            StockMovement::create([
                'movement_number' => $movementNumber,
                'product_id' => $sourceBatch->product_id,
                'batch_id' => $sourceBatch->id,
                'from_warehouse_id' => $fromWarehouse->id,
                'to_warehouse_id' => $toWarehouse->id,
                'type' => 'transfer',
                'quantity' => $quantity,
                'user_id' => $user->id,
                'notes' => $notes ?? "نقل مخزون من {$fromWarehouse->name_ar} إلى {$toWarehouse->name_ar}",
            ]);

            AuditLog::log('STOCK_TRANSFER', $destBatch, [], [
                'from_warehouse' => $fromWarehouse->id,
                'to_warehouse' => $toWarehouse->id,
                'quantity' => $quantity,
            ]);

            return $destBatch;
        });
    }

    /**
     * Manual Stock Adjustment.
     */
    public function manualAdjustment(Batch $batch, int $newQuantity, User $user, string $reason): Batch
    {
        if ($newQuantity < 0) {
            throw new \InvalidArgumentException('كمية التعديل لا يمكن أن تكون بالسالب.');
        }

        return DB::transaction(function () use ($batch, $newQuantity, $user, $reason) {
            $diff = $newQuantity - $batch->quantity;
            $batch->update(['quantity' => $newQuantity]);

            $movementNumber = 'MOV-ADJ-' . strtoupper(Str::random(10));
            StockMovement::create([
                'movement_number' => $movementNumber,
                'product_id' => $batch->product_id,
                'batch_id' => $batch->id,
                'from_warehouse_id' => $diff < 0 ? $batch->warehouse_id : null,
                'to_warehouse_id' => $diff > 0 ? $batch->warehouse_id : null,
                'type' => 'adjustment',
                'quantity' => abs($diff),
                'user_id' => $user->id,
                'notes' => "تعديل مخزوني يدوياً: {$reason}",
            ]);

            AuditLog::log('STOCK_ADJUSTMENT', $batch, ['old_quantity' => $batch->quantity], ['new_quantity' => $newQuantity, 'reason' => $reason]);

            return $batch;
        });
    }

    /**
     * Dispense Medications via FEFO (First Expired, First Out) Strategy.
     */
    public function dispenseMedication(
        Warehouse $warehouse,
        User $patient,
        ?User $doctor,
        ?Booking $booking,
        array $items,
        User $dispenser,
        ?string $notes = null
    ): MedicationDispense {
        return DB::transaction(function () use ($warehouse, $patient, $doctor, $booking, $items, $dispenser, $notes) {
            $dispenseNumber = 'DISP-' . date('Y') . '-' . str_pad((string) (MedicationDispense::max('id') + 100001), 6, '0', STR_PAD_LEFT);
            $totalPrice = 0.00;

            // Validate stock availability before processing
            foreach ($items as $item) {
                $productId = $item['product_id'];
                $requestedQty = (int) $item['quantity'];

                $availableStock = Batch::where('product_id', $productId)
                    ->where('warehouse_id', $warehouse->id)
                    ->where('expiry_date', '>', now())
                    ->get()
                    ->sum('available_quantity');

                if ($availableStock < $requestedQty) {
                    $product = Product::find($productId);
                    $name = $product ? $product->name : "المنتج #{$productId}";
                    throw new \InvalidArgumentException("الكمية المطلوبة للدواء ({$name}) غير متوفرة بالمخزون المتاح ({$availableStock}).");
                }
            }

            $dispense = MedicationDispense::create([
                'dispense_number' => $dispenseNumber,
                'booking_id' => $booking ? $booking->id : null,
                'patient_id' => $patient->id,
                'doctor_id' => $doctor ? $doctor->id : null,
                'dispensed_by' => $dispenser->id,
                'warehouse_id' => $warehouse->id,
                'total_price' => 0.00,
                'notes' => $notes ?? 'صرف علاج طبي زيارة منزلية',
            ]);

            foreach ($items as $item) {
                $productId = $item['product_id'];
                $remainingQty = (int) $item['quantity'];
                $product = Product::findOrFail($productId);
                $unitPrice = (float) ($item['unit_price'] ?? $product->price ?? 0.00);

                // FEFO: Fetch batches ordered by earliest expiry date
                $batches = Batch::where('product_id', $productId)
                    ->where('warehouse_id', $warehouse->id)
                    ->where('expiry_date', '>', now())
                    ->whereRaw('quantity - reserved_quantity > 0')
                    ->orderBy('expiry_date', 'asc')
                    ->get();

                foreach ($batches as $batch) {
                    if ($remainingQty <= 0) {
                        break;
                    }

                    $deductQty = min($batch->available_quantity, $remainingQty);
                    $batch->decrement('quantity', $deductQty);
                    $remainingQty -= $deductQty;

                    $itemPrice = round($deductQty * $unitPrice, 2);
                    $totalPrice += $itemPrice;

                    MedicationDispenseItem::create([
                        'dispense_id' => $dispense->id,
                        'product_id' => $productId,
                        'batch_id' => $batch->id,
                        'quantity' => $deductQty,
                        'unit_price' => $unitPrice,
                        'total_price' => $itemPrice,
                    ]);

                    StockMovement::create([
                        'movement_number' => 'MOV-DISP-' . strtoupper(Str::random(10)),
                        'product_id' => $productId,
                        'batch_id' => $batch->id,
                        'from_warehouse_id' => $warehouse->id,
                        'type' => 'dispense',
                        'quantity' => $deductQty,
                        'user_id' => $dispenser->id,
                        'reference_type' => 'medication_dispenses',
                        'reference_id' => $dispense->id,
                        'notes' => "صرف وصفة برقم {$dispenseNumber}",
                    ]);
                }
            }

            $dispense->update(['total_price' => $totalPrice]);

            AuditLog::log('DISPENSE_MEDICATION', $dispense, [], $dispense->toArray());

            return $dispense;
        });
    }

    public function getLowStockAlerts(int $threshold = 10)
    {
        return Batch::with(['product', 'warehouse'])
            ->where('quantity', '<=', $threshold)
            ->get();
    }

    public function getExpiringSoonAlerts(int $days = 60)
    {
        return Batch::with(['product', 'warehouse'])
            ->where('expiry_date', '>', now())
            ->where('expiry_date', '<=', now()->addDays($days))
            ->get();
    }

    public function getExpiredAlerts()
    {
        return Batch::with(['product', 'warehouse'])
            ->where('expiry_date', '<=', now())
            ->get();
    }
}
