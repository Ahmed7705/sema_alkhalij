<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\AuditLog;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::withCount('purchaseOrders');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'LIKE', "%{$q}%")
                    ->orWhere('code', 'LIKE', "%{$q}%")
                    ->orWhere('contact_name', 'LIKE', "%{$q}%")
                    ->orWhere('phone', 'LIKE', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $suppliers = $query->latest()->paginate(20)->withQueryString();

        return view('admin.inventory.suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:suppliers,code',
            'contact_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'cr_number' => 'nullable|string|max:100',
            'vat_number' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
        ]);

        $supplier = Supplier::create(array_merge($validated, ['status' => 'active']));

        AuditLog::log('CREATE_SUPPLIER', $supplier, [], $supplier->toArray());

        return redirect()->back()->with('success', 'تم إضافة المورد بنجاح.');
    }

    public function show($id)
    {
        $supplier = Supplier::with(['purchaseOrders.warehouse', 'purchaseOrders.items.product'])->findOrFail($id);
        return view('admin.inventory.suppliers.show', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'cr_number' => 'nullable|string|max:100',
            'vat_number' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        $supplier->update($validated);

        AuditLog::log('UPDATE_SUPPLIER', $supplier, [], $supplier->toArray());

        return redirect()->back()->with('success', 'تم تحديث بيانات المورد بنجاح.');
    }
}
