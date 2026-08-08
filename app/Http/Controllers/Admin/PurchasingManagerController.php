<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Services\PurchasingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchasingManagerController extends Controller
{
    protected $purchasingService;

    public function __construct(PurchasingService $purchasingService)
    {
        $this->purchasingService = $purchasingService;
    }

    public function index(Request $request)
    {
        $query = PurchaseOrder::with(['supplier', 'warehouse', 'user', 'items.product']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('po_number', 'LIKE', "%{$q}%")
                ->orWhereHas('supplier', function ($s) use ($q) {
                    $s->where('name', 'LIKE', "%{$q}%");
                });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(20)->withQueryString();
        $suppliers = Supplier::where('status', 'active')->orderBy('name')->get();
        $warehouses = Warehouse::where('is_active', true)->get();
        $products = Product::orderBy('name')->get();

        return view('admin.inventory.purchasing.index', compact('orders', 'suppliers', 'warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);

        $supplier = Supplier::findOrFail($validated['supplier_id']);
        $warehouse = Warehouse::findOrFail($validated['warehouse_id']);

        $po = $this->purchasingService->createPurchaseOrder(
            $supplier,
            $warehouse,
            $validated['items'],
            Auth::user(),
            $validated['notes'] ?? null
        );

        return redirect()->route('admin.inventory.purchasing.show', $po->id)->with('success', 'تم إنشاء أمر الشراء بنجاح.');
    }

    public function show($id)
    {
        $order = PurchaseOrder::with(['supplier', 'warehouse', 'user', 'items.product'])->findOrFail($id);
        return view('admin.inventory.purchasing.show', compact('order'));
    }

    public function receiveGoods(Request $request, $id)
    {
        $po = PurchaseOrder::with('items')->findOrFail($id);

        $validated = $request->validate([
            'received_items' => 'required|array|min:1',
            'received_items.*.product_id' => 'required|exists:products,id',
            'received_items.*.quantity_received' => 'required|integer|min:1',
            'received_items.*.batch_number' => 'required|string|max:100',
            'received_items.*.expiry_date' => 'required|date',
            'received_items.*.unit_price' => 'nullable|numeric|min:0',
            'received_items.*.sell_price' => 'nullable|numeric|min:0',
        ]);

        $this->purchasingService->receiveGoods($po, $validated['received_items'], Auth::user());

        return redirect()->back()->with('success', 'تم استلام الشحنة وإضافتها للمخزون بنجاح.');
    }

    public function cancel(Request $request, $id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $reason = $request->input('reason', 'إلغاء من الإدارة');

        $this->purchasingService->cancelPurchaseOrder($po, Auth::user(), $reason);

        return redirect()->back()->with('success', 'تم إلغاء أمر الشراء بنجاح.');
    }
}
