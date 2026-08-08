<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Batch;
use App\Models\Booking;
use App\Models\MedicationDispense;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Warehouse;
use App\Services\InventoryService;
use App\Services\PurchasingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase9InventoryPharmacyPurchasingTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $patient;
    protected $doctor;
    protected $mainWarehouse;
    protected $secondaryWarehouse;
    protected $supplier;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->patient = User::factory()->create(['role' => 'patient']);
        $this->doctor = User::factory()->create(['role' => 'doctor']);

        $this->mainWarehouse = Warehouse::create([
            'name_ar' => 'المستودع الرئيسي - الرياض',
            'code' => 'WH-MAIN',
            'city' => 'الرياض',
            'is_main' => true,
            'is_active' => true,
        ]);

        $this->secondaryWarehouse = Warehouse::create([
            'name_ar' => 'صيدلية الأسطول المنزلي',
            'code' => 'WH-FLEET',
            'city' => 'الرياض',
            'is_main' => false,
            'is_active' => true,
        ]);

        $this->supplier = Supplier::create([
            'name' => 'شركة أدوية الخليج الطبية',
            'code' => 'SUP-001',
            'contact_name' => 'محمد العمري',
            'phone' => '0590000001',
            'email' => 'sales@gulfmed.com',
            'cr_number' => '1010101010',
            'vat_number' => '300000000000001',
            'status' => 'active',
        ]);

        $this->product = Product::create([
            'name' => 'باندول إكسترا 500 مجم',
            'title' => 'باندول إكسترا 500 مجم',
            'title_ar' => 'باندول إكسترا 500 مجم',
            'slug' => 'panadol-extra',
            'price' => 25.00,
            'sku' => 'MED-PAN-001',
            'stock' => 0,
            'is_active' => true,
        ]);
    }


    public function test_admin_can_manage_suppliers_and_warehouses()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.inventory.warehouses.index'));
        $response->assertStatus(200);
        $response->assertSee('المستودع الرئيسي - الرياض');



        $responseSup = $this->actingAs($this->admin)->get(route('admin.inventory.suppliers.index'));
        $responseSup->assertStatus(200);
        $responseSup->assertSee('شركة أدوية الخليج الطبية');
    }

    public function test_inventory_service_handles_stock_in_and_batch_creation()
    {
        $service = new InventoryService();
        $batch = $service->stockIn(
            $this->mainWarehouse,
            $this->product,
            'BAT-2026-001',
            '2028-12-31',
            100,
            15.00,
            25.00,
            $this->admin
        );

        $this->assertDatabaseHas('batches', [
            'id' => $batch->id,
            'batch_number' => 'BAT-2026-001',
            'quantity' => 100,
        ]);

        $this->assertDatabaseHas('stock_movements', [
            'product_id' => $this->product->id,
            'type' => 'stock_in',
            'quantity' => 100,
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'STOCK_IN',
        ]);
    }

    public function test_inventory_service_transfers_stock_between_warehouses()
    {
        $service = new InventoryService();
        $sourceBatch = $service->stockIn(
            $this->mainWarehouse,
            $this->product,
            'BAT-2026-002',
            '2028-12-31',
            50,
            15.00,
            25.00,
            $this->admin
        );

        $destBatch = $service->transferStock(
            $this->mainWarehouse,
            $this->secondaryWarehouse,
            $sourceBatch,
            20,
            $this->admin
        );

        $this->assertEquals(30, $sourceBatch->fresh()->quantity);
        $this->assertEquals(20, $destBatch->fresh()->quantity);

        $this->assertDatabaseHas('stock_movements', [
            'type' => 'transfer',
            'quantity' => 20,
            'from_warehouse_id' => $this->mainWarehouse->id,
            'to_warehouse_id' => $this->secondaryWarehouse->id,
        ]);
    }

    public function test_purchasing_service_creates_purchase_order_and_receives_goods()
    {
        $purchasingService = new PurchasingService();
        $po = $purchasingService->createPurchaseOrder(
            $this->supplier,
            $this->mainWarehouse,
            [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 200,
                    'unit_price' => 10.00,
                ]
            ],
            $this->admin
        );

        $this->assertDatabaseHas('purchase_orders', [
            'id' => $po->id,
            'status' => 'ordered',
        ]);

        // Receive goods
        $purchasingService->receiveGoods(
            $po,
            [
                [
                    'product_id' => $this->product->id,
                    'quantity_received' => 200,
                    'batch_number' => 'BAT-PO-001',
                    'expiry_date' => '2028-06-30',
                    'unit_price' => 10.00,
                    'sell_price' => 18.00,
                ]
            ],
            $this->admin
        );

        $this->assertEquals('received', $po->fresh()->status);
        $this->assertDatabaseHas('batches', [
            'batch_number' => 'BAT-PO-001',
            'quantity' => 200,
        ]);
    }

    public function test_pharmacy_dispensing_deducts_batch_stock_automatically_using_fefo()
    {
        $inventoryService = new InventoryService();
        // Create 2 batches: Earlier expiry vs Later expiry
        $laterBatch = $inventoryService->stockIn(
            $this->mainWarehouse,
            $this->product,
            'BAT-LATER',
            '2029-12-31',
            50,
            15.00,
            25.00,
            $this->admin
        );

        $earlierBatch = $inventoryService->stockIn(
            $this->mainWarehouse,
            $this->product,
            'BAT-EARLIER',
            '2027-05-30',
            30,
            15.00,
            25.00,
            $this->admin
        );

        // Dispense 10 units (Should be deducted from BAT-EARLIER due to FEFO)
        $dispense = $inventoryService->dispenseMedication(
            $this->mainWarehouse,
            $this->patient,
            $this->doctor,
            null,
            [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 10,
                    'unit_price' => 25.00,
                ]
            ],
            $this->admin
        );

        $this->assertEquals(20, $earlierBatch->fresh()->quantity);
        $this->assertEquals(50, $laterBatch->fresh()->quantity);

        $this->assertDatabaseHas('medication_dispenses', [
            'id' => $dispense->id,
            'patient_id' => $this->patient->id,
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'DISPENSE_MEDICATION',
        ]);
    }

    public function test_pharmacy_dispensing_prevents_dispensing_more_than_available_stock()
    {
        $inventoryService = new InventoryService();
        $inventoryService->stockIn(
            $this->mainWarehouse,
            $this->product,
            'BAT-LIMITED',
            '2028-12-31',
            5,
            15.00,
            25.00,
            $this->admin
        );

        $this->expectException(\InvalidArgumentException::class);

        $inventoryService->dispenseMedication(
            $this->mainWarehouse,
            $this->patient,
            $this->doctor,
            null,
            [
                [
                    'product_id' => $this->product->id,
                    'quantity' => 10, // Requesting 10 when only 5 exist
                ]
            ],
            $this->admin
        );
    }

    public function test_stock_alerts_detect_low_stock_and_expiring_batches()
    {
        $service = new InventoryService();
        // Low stock batch
        $service->stockIn($this->mainWarehouse, $this->product, 'BAT-LOW', '2028-12-31', 3, 10.00, 20.00, $this->admin);

        // Expiring soon batch (within 60 days)
        $service->stockIn($this->mainWarehouse, $this->product, 'BAT-SOON', now()->addDays(20)->format('Y-m-d'), 50, 10.00, 20.00, $this->admin);

        $lowStock = $service->getLowStockAlerts(10);
        $expiring = $service->getExpiringSoonAlerts(60);

        $this->assertTrue($lowStock->contains('batch_number', 'BAT-LOW'));
        $this->assertTrue($expiring->contains('batch_number', 'BAT-SOON'));
    }

    public function test_unauthorized_user_cannot_access_inventory_management()
    {
        $response = $this->actingAs($this->patient)->get(route('admin.inventory.dashboard'));
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }
}


