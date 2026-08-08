<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\AuditLog;
use App\Models\Batch;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\Warehouse;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryManagerController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function dashboard()
    {
        $totalWarehouses = Warehouse::where('is_active', true)->count();
        $totalBatches = Batch::count();
        $totalQuantity = Batch::sum('quantity');
        $totalValuation = Batch::selectRaw('SUM(quantity * buy_price) as valuation')->value('valuation') ?? 0.00;

        $lowStockAlerts = $this->inventoryService->getLowStockAlerts(10);
        $expiringSoonAlerts = $this->inventoryService->getExpiringSoonAlerts(60);
        $expiredAlerts = $this->inventoryService->getExpiredAlerts();

        $recentMovements = StockMovement::with(['product', 'batch', 'fromWarehouse', 'toWarehouse', 'user'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.inventory.dashboard', compact(
            'totalWarehouses',
            'totalBatches',
            'totalQuantity',
            'totalValuation',
            'lowStockAlerts',
            'expiringSoonAlerts',
            'expiredAlerts',
            'recentMovements'
        ));
    }

    public function warehouses()
    {
        $warehouses = Warehouse::withCount('batches')->orderBy('is_main', 'desc')->get();
        return view('admin.inventory.warehouses.index', compact('warehouses'));
    }

    public function storeWarehouse(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'code' => 'required|string|max:50|unique:warehouses,code',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string|max:500',
            'is_main' => 'nullable|boolean',
        ]);

        if (!empty($validated['is_main'])) {
            Warehouse::query()->update(['is_main' => false]);
        }

        $warehouse = Warehouse::create([
            'name_ar' => $validated['name_ar'],
            'name_en' => $validated['name_en'] ?? null,
            'code' => strtoupper($validated['code']),
            'city' => $validated['city'],
            'address' => $validated['address'] ?? null,
            'is_main' => $request->has('is_main'),
            'is_active' => true,
        ]);

        AuditLog::log('CREATE_WAREHOUSE', $warehouse, [], $warehouse->toArray());

        return redirect()->back()->with('success', 'تم إضافة المستودع بنجاح.');
    }

    public function stock(Request $request)
    {
        $query = Batch::with(['product.category', 'warehouse']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('batch_number', 'LIKE', "%{$q}%")
                    ->orWhereHas('product', function ($p) use ($q) {
                        $p->where('name', 'LIKE', "%{$q}%")
                          ->orWhere('sku', 'LIKE', "%{$q}%");
                    });
            });
        }

        if ($request->filled('warehouse_id')) {
            $query->where('warehouse_id', $request->warehouse_id);
        }

        $batches = $query->latest()->paginate(20)->withQueryString();
        $warehouses = Warehouse::where('is_active', true)->get();
        $products = Product::orderBy('name')->get();

        return view('admin.inventory.stock.index', compact('batches', 'warehouses', 'products'));
    }

    public function storeStockIn(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'batch_number' => 'required|string|max:100',
            'expiry_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'buy_price' => 'required|numeric|min:0',
            'sell_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $warehouse = Warehouse::findOrFail($validated['warehouse_id']);
        $product = Product::findOrFail($validated['product_id']);

        $this->inventoryService->stockIn(
            $warehouse,
            $product,
            $validated['batch_number'],
            $validated['expiry_date'],
            (int) $validated['quantity'],
            (float) $validated['buy_price'],
            (float) $validated['sell_price'],
            Auth::user(),
            'manual',
            null,
            $validated['notes'] ?? null
        );

        return redirect()->back()->with('success', 'تم توريد المخزون بنجاح.');
    }

    public function adjustStock(Request $request, $batchId)
    {
        $validated = $request->validate([
            'new_quantity' => 'required|integer|min:0',
            'reason' => 'required|string|max:255',
        ]);

        $batch = Batch::findOrFail($batchId);
        $this->inventoryService->manualAdjustment($batch, (int) $validated['new_quantity'], Auth::user(), $validated['reason']);

        return redirect()->back()->with('success', 'تم تعديل كمية الدفعة المخزونية بنجاح.');
    }

    public function transferStock(Request $request)
    {
        $validated = $request->validate([
            'from_warehouse_id' => 'required|exists:warehouses,id',
            'to_warehouse_id' => 'required|exists:warehouses,id|different:from_warehouse_id',
            'batch_id' => 'required|exists:batches,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        $from = Warehouse::findOrFail($validated['from_warehouse_id']);
        $to = Warehouse::findOrFail($validated['to_warehouse_id']);
        $batch = Batch::findOrFail($validated['batch_id']);

        $this->inventoryService->transferStock($from, $to, $batch, (int) $validated['quantity'], Auth::user(), $validated['notes'] ?? null);

        return redirect()->back()->with('success', 'تم نقل المخزون بين المستودعات بنجاح.');
    }
}
