@extends('layouts.admin')

@section('title', 'إدارة أوامر الشراء والمشتريات')

@section('content')
<div class="space-y-6" dir="rtl">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold font-alexandria text-slate-900">أوامر الشراء والتوريد</h1>
        <button onclick="document.getElementById('newPoModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-500 text-white font-medium px-4 py-2.5 rounded-xl transition shadow">
            + أمر شراء جديد
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-800 p-4 rounded-xl border border-emerald-200 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead class="bg-slate-50 text-slate-600 font-medium">
                    <tr>
                        <th class="p-4">رقم الأمر</th>
                        <th class="p-4">المورد</th>
                        <th class="p-4">المستودع المستلم</th>
                        <th class="p-4">إجمالي السعر</th>
                        <th class="p-4">الحالة</th>
                        <th class="p-4">التاريخ</th>
                        <th class="p-4">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($orders as $po)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4 font-mono font-bold text-slate-800">{{ $po->po_number }}</td>
                            <td class="p-4 font-bold text-slate-900">{{ $po->supplier->name ?? '-' }}</td>
                            <td class="p-4 text-slate-600">{{ $po->warehouse->name_ar ?? '-' }}</td>
                            <td class="p-4 font-bold text-emerald-600">{{ number_format($po->total_amount, 2) }} ر.س</td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 text-xs rounded-full font-bold
                                    @if($po->status === 'received') bg-emerald-100 text-emerald-800
                                    @elseif($po->status === 'ordered') bg-blue-100 text-blue-800
                                    @elseif($po->status === 'cancelled') bg-rose-100 text-rose-800
                                    @else bg-amber-100 text-amber-800 @endif">
                                    {{ $po->status }}
                                </span>
                            </td>
                            <td class="p-4 text-xs text-slate-400">{{ $po->created_at->format('Y-m-d') }}</td>
                            <td class="p-4">
                                <a href="{{ route('admin.inventory.purchasing.show', $po->id) }}" class="text-blue-600 hover:text-blue-800 font-medium text-xs">عرض واستلام التوريد ←</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">لا توجد أوامر شراء مسجلة.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- New PO Modal -->
<div id="newPoModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-lg shadow-2xl space-y-4 text-right" dir="rtl">
        <h3 class="text-lg font-bold text-slate-900">إنشاء أمر شراء توريد أدوية</h3>
        <form action="{{ route('admin.inventory.purchasing.store') }}" method="POST" class="space-y-3">
            @csrf
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">المورد</label>
                    <select name="supplier_id" required class="w-full border-slate-200 rounded-xl p-2 text-sm">
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">المستودع المستلم</label>
                    <select name="warehouse_id" required class="w-full border-slate-200 rounded-xl p-2 text-sm">
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->name_ar }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="border-t border-slate-100 pt-2 space-y-2">
                <p class="text-xs font-bold text-slate-800">بند المنتج / الدواء</p>
                <div class="grid grid-cols-3 gap-2">
                    <select name="items[0][product_id]" required class="border-slate-200 rounded-xl p-2 text-xs">
                        @foreach($products as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="items[0][quantity]" min="1" placeholder="الكمية" required class="border-slate-200 rounded-xl p-2 text-xs">
                    <input type="number" step="0.01" name="items[0][unit_price]" placeholder="سعر الوحدة" required class="border-slate-200 rounded-xl p-2 text-xs">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">ملاحظات التوريد</label>
                <input type="text" name="notes" class="w-full border-slate-200 rounded-xl p-2 text-sm">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('newPoModal').classList.add('hidden')" class="px-4 py-2 text-sm text-slate-600">إلغاء</button>
                <button type="submit" class="bg-blue-600 text-white font-medium px-4 py-2 rounded-xl text-sm">إصدار أمر الشراء</button>
            </div>
        </form>
    </div>
</div>
@endsection
