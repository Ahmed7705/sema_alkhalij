@extends('layouts.admin')

@section('title', 'تفاصيل أمر الشراء ' . $order->po_number)

@section('content')
<div class="space-y-6" dir="rtl">
    <div class="flex items-center justify-between">
        <div>
            <span class="text-xs font-mono bg-slate-100 text-slate-600 px-2 py-0.5 rounded">{{ $order->po_number }}</span>
            <h1 class="text-2xl font-bold font-alexandria text-slate-900 mt-1">أمر شراء مالي للمورد {{ $order->supplier->name ?? '-' }}</h1>
        </div>
        <div class="flex items-center gap-2">
            @if($order->status !== 'received' && $order->status !== 'cancelled')
                <button onclick="document.getElementById('receiveGoodsModal').classList.remove('hidden')" class="bg-emerald-600 hover:bg-emerald-500 text-white font-medium px-4 py-2 rounded-xl text-sm transition">
                    + استلام التوريد وإدخال المخزون
                </button>
            @endif
            <a href="{{ route('admin.inventory.purchasing.index') }}" class="text-slate-600 hover:text-slate-900 text-sm font-medium">← العودة القائمة</a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-800 p-4 rounded-xl border border-emerald-200 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
        <div>
            <p class="text-xs text-slate-500">المورد</p>
            <p class="font-bold text-slate-800">{{ $order->supplier->name ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs text-slate-500">المستودع المستلم</p>
            <p class="font-bold text-slate-800">{{ $order->warehouse->name_ar ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs text-slate-500">الإجمالي الشامل للضريبة (15%)</p>
            <p class="font-bold text-emerald-600 text-base">{{ number_format($order->total_amount, 2) }} ر.س</p>
        </div>
        <div>
            <p class="text-xs text-slate-500">الحالة الحالية</p>
            <span class="inline-block mt-1 px-3 py-1 text-xs rounded-full font-bold bg-blue-100 text-blue-800">{{ $order->status }}</span>
        </div>
    </div>

    <!-- Items Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 font-bold text-slate-800">بنود الأدوية والمنتجات المعتمدة بالأمر</div>
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead class="bg-slate-50 text-slate-600 font-medium">
                    <tr>
                        <th class="p-4">المنتج</th>
                        <th class="p-4">الكمية المطلوبة</th>
                        <th class="p-4">الكمية المستلمة</th>
                        <th class="p-4">سعر الوحدة</th>
                        <th class="p-4">الإجمالي</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($order->items as $item)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4 font-bold text-slate-900">{{ $item->product->name ?? '-' }}</td>
                            <td class="p-4 font-bold text-slate-800">{{ $item->quantity_ordered }}</td>
                            <td class="p-4 font-bold text-emerald-600">{{ $item->quantity_received }}</td>
                            <td class="p-4 font-mono text-xs">{{ number_format($item->unit_price, 2) }} ر.س</td>
                            <td class="p-4 font-bold text-slate-900">{{ number_format($item->total_amount, 2) }} ر.س</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Goods Receiving Modal -->
@if($order->status !== 'received' && $order->status !== 'cancelled')
<div id="receiveGoodsModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl space-y-4 text-right" dir="rtl">
        <h3 class="text-lg font-bold text-slate-900">إدخال واستلام الشحنة للمخزون</h3>
        <form action="{{ route('admin.inventory.purchasing.receive', $order->id) }}" method="POST" class="space-y-4">
            @csrf
            @foreach($order->items as $idx => $item)
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 space-y-2">
                    <p class="text-xs font-bold text-slate-800">{{ $item->product->name ?? 'منتج' }}</p>
                    <input type="hidden" name="received_items[{{ $idx }}][product_id]" value="{{ $item->product_id }}">
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600">الكمية المستلمة</label>
                            <input type="number" name="received_items[{{ $idx }}][quantity_received]" value="{{ max(1, $item->quantity_ordered - $item->quantity_received) }}" min="1" required class="w-full border-slate-200 rounded-lg p-1.5 text-xs">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600">رقم الدفعة (Batch)</label>
                            <input type="text" name="received_items[{{ $idx }}][batch_number]" required value="BATCH-{{ date('Ymd') }}-{{ rand(100, 999) }}" class="w-full border-slate-200 rounded-lg p-1.5 text-xs uppercase">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-600">تاريخ الانتهاء</label>
                        <input type="date" name="received_items[{{ $idx }}][expiry_date]" required value="{{ date('Y-m-d', strtotime('+2 years')) }}" class="w-full border-slate-200 rounded-lg p-1.5 text-xs">
                    </div>
                </div>
            @endforeach
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('receiveGoodsModal').classList.add('hidden')" class="px-4 py-2 text-sm text-slate-600">إلغاء</button>
                <button type="submit" class="bg-emerald-600 text-white font-medium px-4 py-2 rounded-xl text-sm">تأكيد الاستلام والتحديث</button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection
