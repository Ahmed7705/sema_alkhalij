<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class PurchasingService
{
    /**
     * Create a Purchase Order.
     */
    public function createPurchaseOrder(
        Supplier $supplier,
        Warehouse $warehouse,
        array $items,
        User $user,
        ?string $notes = null
    ): PurchaseOrder {
        return DB::transaction(function () use ($supplier, $warehouse, $items, $user, $notes) {
            $poNumber = 'PO-' . date('Y') . '-' . str_pad((string) (PurchaseOrder::max('id') + 100001), 6, '0', STR_PAD_LEFT);
            $subtotal = 0.00;
            $vatRate = 15.00;

            foreach ($items as $item) {
                $qty = (int) $item['quantity'];
                $unitPrice = (float) $item['unit_price'];
                $subtotal += round($qty * $unitPrice, 2);
            }

            $vatAmount = round($subtotal * ($vatRate / 100), 2);
            $totalAmount = round($subtotal + $vatAmount, 2);

            $po = PurchaseOrder::create([
                'po_number' => $poNumber,
                'supplier_id' => $supplier->id,
                'warehouse_id' => $warehouse->id,
                'user_id' => $user->id,
                'status' => 'ordered',
                'subtotal' => $subtotal,
                'vat_rate' => $vatRate,
                'vat_amount' => $vatAmount,
                'total_amount' => $totalAmount,
                'ordered_at' => now(),
                'notes' => $notes ?? 'أمر شراء توريد أدوية ومستلزمات',
            ]);

            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $qty = (int) $item['quantity'];
                $unitPrice = (float) $item['unit_price'];
                $itemTotal = round($qty * $unitPrice, 2);

                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'product_id' => $product->id,
                    'quantity_ordered' => $qty,
                    'quantity_received' => 0,
                    'unit_price' => $unitPrice,
                    'total_amount' => $itemTotal,
                ]);
            }

            AuditLog::log('CREATE_PURCHASE_ORDER', $po, [], $po->toArray());

            return $po;
        });
    }

    /**
     * Receive Goods for a Purchase Order and automatically add to Inventory.
     */
    public function receiveGoods(
        PurchaseOrder $po,
        array $receivedItems,
        User $user
    ): PurchaseOrder {
        return DB::transaction(function () use ($po, $receivedItems, $user) {
            $inventoryService = new InventoryService();
            $allReceived = true;

            foreach ($receivedItems as $item) {
                $poItem = PurchaseOrderItem::where('purchase_order_id', $po->id)
                    ->where('product_id', $item['product_id'])
                    ->firstOrFail();

                $recvQty = (int) $item['quantity_received'];
                $batchNumber = $item['batch_number'] ?? ('BATCH-' . strtoupper(date('Ymd')) . '-' . rand(100, 999));
                $expiryDate = $item['expiry_date'] ?? date('Y-m-d', strtotime('+2 years'));
                $buyPrice = (float) ($item['unit_price'] ?? $poItem->unit_price);
                $sellPrice = (float) ($item['sell_price'] ?? round($buyPrice * 1.3, 2));

                $poItem->increment('quantity_received', $recvQty);

                if ($poItem->quantity_received < $poItem->quantity_ordered) {
                    $allReceived = false;
                }

                // Add to Stock
                $inventoryService->stockIn(
                    $po->warehouse,
                    $poItem->product,
                    $batchNumber,
                    $expiryDate,
                    $recvQty,
                    $buyPrice,
                    $sellPrice,
                    $user,
                    'purchase_orders',
                    $po->id,
                    "استلام توريد بموجب أمر شراء #{$po->po_number}"
                );
            }

            $po->update([
                'status' => $allReceived ? 'received' : 'partially_received',
                'received_at' => now(),
            ]);

            AuditLog::log('RECEIVE_PURCHASE', $po, [], ['status' => $po->status]);

            return $po;
        });
    }

    /**
     * Cancel a Purchase Order.
     */
    public function cancelPurchaseOrder(PurchaseOrder $po, User $user, string $reason): PurchaseOrder
    {
        if ($po->status === 'received') {
            throw new \InvalidArgumentException('لا يمكن إلغاء أمر شراء تم استلامه بالكامل.');
        }

        $po->update([
            'status' => 'cancelled',
            'notes' => $po->notes . " | تم الإلغاء: {$reason}",
        ]);

        AuditLog::log('CANCEL_PURCHASE', $po, [], ['reason' => $reason]);

        return $po;
    }
}
