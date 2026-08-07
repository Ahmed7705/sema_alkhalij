<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class OrderManagerController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product', 'items.service'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        AuditLog::log('UPDATE_ORDER_STATUS', $order, ['status' => $oldStatus], ['status' => $order->status]);

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح.');
    }
}

