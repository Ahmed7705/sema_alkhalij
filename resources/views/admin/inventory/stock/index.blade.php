@extends('layouts.admin')

@section('title', 'دليل الأدوية والدفعات المخزونية')

@section('content')
<div class="space-y-6" dir="rtl">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h1 class="text-2xl font-bold font-alexandria text-slate-900">دليل الأدوية والدفعات المخزونية</h1>
        <div class="flex flex-wrap gap-2">
            <button onclick="document.getElementById('stockInModal').classList.remove('hidden')" class="bg-emerald-600 hover:bg-emerald-500 text-white font-medium px-4 py-2.5 rounded-xl transition shadow">
                + إضافة / توريد مخزون
            </button>
            <button onclick="document.getElementById('transferModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-500 text-white font-medium px-4 py-2.5 rounded-xl transition shadow">
                نقل بين المستودعات
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-800 p-4 rounded-xl border border-emerald-200 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stock Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead class="bg-slate-50 text-slate-600 font-medium">
                    <tr>
                        <th class="p-4">المنتج / الدواء</th>
                        <th class="p-4">رقم الدفعة (Batch)</th>
                        <th class="p-4">المستودع</th>
                        <th class="p-4">تاريخ الانتهاء</th>
                        <th class="p-4">الكمية الحالية</th>
                        <th class="p-4">الكمية المتاحة</th>
                        <th class="p-4">سعر الشراء / البيع</th>
                        <th class="p-4">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($batches as $batch)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4 font-bold text-slate-900">{{ $batch->product->name ?? '-' }}</td>
                            <td class="p-4 font-mono text-xs text-slate-600">{{ $batch->batch_number }}</td>
                            <td class="p-4 text-slate-600">{{ $batch->warehouse->name_ar ?? '-' }}</td>
                            <td class="p-4 font-mono text-xs">
                                <span class="px-2 py-0.5 rounded font-bold {{ $batch->is_expired ? 'bg-red-100 text-red-800' : ($batch->is_expiring_soon ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700') }}">
                                    {{ $batch->expiry_date->format('Y-m-d') }}
                                </span>
                            </td>
                            <td class="p-4 font-bold text-slate-800">{{ $batch->quantity }}</td>
                            <td class="p-4 font-bold text-emerald-600">{{ $batch->available_quantity }}</td>
                            <td class="p-4 text-xs font-mono">
                                {{ number_format($batch->buy_price, 2) }} / {{ number_format($batch->sell_price, 2) }} ر.س
                            </td>
                            <td class="p-4">
                                <button onclick="openAdjustModal({{ $batch->id }}, {{ $batch->quantity }})" class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-800 px-3 py-1.5 rounded-lg font-medium">
                                    تعديل
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400">لا توجد دفعات مخزونية مسجلة.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Stock In Modal -->
<div id="stockInModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl space-y-4 text-right" dir="rtl">
        <h3 class="text-lg font-bold text-slate-900">إضافة / توريد مخزون جديد</h3>
        <form action="{{ route('admin.inventory.stock.in') }}" method="POST" class="space-y-3">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">المستودع</label>
                    <select name="warehouse_id" required class="w-full border-slate-200 rounded-xl p-2 text-sm">
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->name_ar }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">المنتج / الدواء</label>
                    <select name="product_id" required class="w-full border-slate-200 rounded-xl p-2 text-sm">
                        @foreach($products as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">رقم الدفعة (Batch)</label>
                    <input type="text" name="batch_number" required placeholder="BAT-2026-001" class="w-full border-slate-200 rounded-xl p-2 text-sm uppercase">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">تاريخ الانتهاء</label>
                    <input type="date" name="expiry_date" required class="w-full border-slate-200 rounded-xl p-2 text-sm">
                </div>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">الكمية</label>
                    <input type="number" name="quantity" min="1" required class="w-full border-slate-200 rounded-xl p-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">سعر الشراء</label>
                    <input type="number" step="0.01" name="buy_price" required class="w-full border-slate-200 rounded-xl p-2 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">سعر البيع</label>
                    <input type="number" step="0.01" name="sell_price" required class="w-full border-slate-200 rounded-xl p-2 text-sm">
                </div>
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('stockInModal').classList.add('hidden')" class="px-4 py-2 text-sm text-slate-600">إلغاء</button>
                <button type="submit" class="bg-emerald-600 text-white font-medium px-4 py-2 rounded-xl text-sm">تأكيد التوريد</button>
            </div>
        </form>
    </div>
</div>

<!-- Stock Transfer Modal -->
<div id="transferModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl space-y-4 text-right" dir="rtl">
        <h3 class="text-lg font-bold text-slate-900">نقل مخزون بين المستودعات</h3>
        <form action="{{ route('admin.inventory.stock.transfer') }}" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">من المستودع</label>
                <select name="from_warehouse_id" required class="w-full border-slate-200 rounded-xl p-2 text-sm">
                    @foreach($warehouses as $wh)
                        <option value="{{ $wh->id }}">{{ $wh->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">إلى المستودع</label>
                <select name="to_warehouse_id" required class="w-full border-slate-200 rounded-xl p-2 text-sm">
                    @foreach($warehouses as $wh)
                        <option value="{{ $wh->id }}">{{ $wh->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">الدفعة المراد نقلها</label>
                <select name="batch_id" required class="w-full border-slate-200 rounded-xl p-2 text-sm">
                    @foreach($batches as $b)
                        <option value="{{ $b->id }}">{{ $b->product->name ?? 'منتج' }} ({{ $b->batch_number }}) - المتاح: {{ $b->available_quantity }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">الكمية المراد نقلها</label>
                <input type="number" name="quantity" min="1" required class="w-full border-slate-200 rounded-xl p-2 text-sm">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('transferModal').classList.add('hidden')" class="px-4 py-2 text-sm text-slate-600">إلغاء</button>
                <button type="submit" class="bg-blue-600 text-white font-medium px-4 py-2 rounded-xl text-sm">تنفيذ النقل</button>
            </div>
        </form>
    </div>
</div>

<!-- Adjust Stock Modal -->
<div id="adjustModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl space-y-4 text-right" dir="rtl">
        <h3 class="text-lg font-bold text-slate-900">تعديل الكمية المخزونية</h3>
        <form id="adjustForm" method="POST" class="space-y-3">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">الكمية الجديدة</label>
                <input type="number" id="adjust_new_qty" name="new_quantity" min="0" required class="w-full border-slate-200 rounded-xl p-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">سبب التعديل</label>
                <input type="text" name="reason" required placeholder="تسوية جرد سنوي / تالف" class="w-full border-slate-200 rounded-xl p-2 text-sm">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('adjustModal').classList.add('hidden')" class="px-4 py-2 text-sm text-slate-600">إلغاء</button>
                <button type="submit" class="bg-slate-900 text-white font-medium px-4 py-2 rounded-xl text-sm">حفظ التعديل</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAdjustModal(batchId, currentQty) {
    document.getElementById('adjustForm').action = '/admin/inventory/stock/' + batchId + '/adjust';
    document.getElementById('adjust_new_qty').value = currentQty;
    document.getElementById('adjustModal').classList.remove('hidden');
}
</script>
@endsection
