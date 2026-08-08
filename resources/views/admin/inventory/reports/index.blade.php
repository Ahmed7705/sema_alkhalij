@extends('layouts.admin')

@section('title', 'تقارير المخزون والصيدلية والمشتريات')

@section('content')
<div class="space-y-6" dir="rtl">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold font-alexandria text-slate-900">تقارير المخزون وحركة الصيدلية والمشتريات</h1>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex border-b border-slate-200 gap-2 bg-white p-2 rounded-xl shadow-sm">
        <a href="{{ route('admin.inventory.reports.index', ['type' => 'valuation']) }}" class="px-4 py-2 text-sm font-bold rounded-lg {{ $reportType === 'valuation' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50' }}">تقييم المخزون</a>
        <a href="{{ route('admin.inventory.reports.index', ['type' => 'movement']) }}" class="px-4 py-2 text-sm font-bold rounded-lg {{ $reportType === 'movement' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50' }}">حرّكات المخزون</a>
        <a href="{{ route('admin.inventory.reports.index', ['type' => 'expiry']) }}" class="px-4 py-2 text-sm font-bold rounded-lg {{ $reportType === 'expiry' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50' }}">تقرير التواريخ والانتهاء</a>
        <a href="{{ route('admin.inventory.reports.index', ['type' => 'dispensing']) }}" class="px-4 py-2 text-sm font-bold rounded-lg {{ $reportType === 'dispensing' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50' }}">تقرير صرف الصيدلية</a>
        <a href="{{ route('admin.inventory.reports.index', ['type' => 'purchasing']) }}" class="px-4 py-2 text-sm font-bold rounded-lg {{ $reportType === 'purchasing' ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50' }}">تقرير مشتريات الموردين</a>
    </div>

    <!-- Valuation Report Table -->
    @if($reportType === 'valuation')
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-100 font-bold text-slate-800">تقرير قيمة وتقييم الدفعات المخزونية حالياً</div>
            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm">
                    <thead class="bg-slate-50 text-slate-600 font-medium">
                        <tr>
                            <th class="p-4">المنتج / الدواء</th>
                            <th class="p-4">الدفعة</th>
                            <th class="p-4">المستودع</th>
                            <th class="p-4">الكمية الحالية</th>
                            <th class="p-4">سعر الشراء</th>
                            <th class="p-4">إجمالي قيمة الشراء</th>
                            <th class="p-4">إجمالي قيمة البيع التقديرية</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($valuationReport as $b)
                            <tr class="hover:bg-slate-50">
                                <td class="p-4 font-bold text-slate-900">{{ $b->product->name ?? '-' }}</td>
                                <td class="p-4 font-mono text-xs">{{ $b->batch_number }}</td>
                                <td class="p-4 text-slate-600">{{ $b->warehouse->name_ar ?? '-' }}</td>
                                <td class="p-4 font-bold text-slate-800">{{ $b->quantity }}</td>
                                <td class="p-4 font-mono text-xs">{{ number_format($b->buy_price, 2) }} ر.س</td>
                                <td class="p-4 font-bold text-emerald-600">{{ number_format($b->total_buy_valuation, 2) }} ر.س</td>
                                <td class="p-4 font-bold text-purple-600">{{ number_format($b->total_sell_valuation, 2) }} ر.س</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="p-8 text-center text-slate-400">لا توجد بيانات تقييم.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Movement Report Table -->
    @if($reportType === 'movement')
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-100 font-bold text-slate-800">سجل حرّكات المخزون بالتفصيل</div>
            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm">
                    <thead class="bg-slate-50 text-slate-600 font-medium">
                        <tr>
                            <th class="p-4">رقم الحركة</th>
                            <th class="p-4">المنتج</th>
                            <th class="p-4">النوع</th>
                            <th class="p-4">الكمية</th>
                            <th class="p-4">من / إلى المستودع</th>
                            <th class="p-4">المستخدم</th>
                            <th class="p-4">التاريخ</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($movementReport as $mov)
                            <tr class="hover:bg-slate-50">
                                <td class="p-4 font-mono text-xs font-bold">{{ $mov->movement_number }}</td>
                                <td class="p-4 font-bold">{{ $mov->product->name ?? '-' }}</td>
                                <td class="p-4 font-bold text-purple-700">{{ $mov->type }}</td>
                                <td class="p-4 font-bold text-slate-900">{{ $mov->quantity }}</td>
                                <td class="p-4 text-xs text-slate-600">{{ $mov->toWarehouse->name_ar ?? $mov->fromWarehouse->name_ar ?? '-' }}</td>
                                <td class="p-4 text-slate-600">{{ $mov->user->name ?? '-' }}</td>
                                <td class="p-4 text-xs text-slate-400">{{ $mov->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="p-8 text-center text-slate-400">لا توجد حرّكات مخزونية.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Expiry Report Table -->
    @if($reportType === 'expiry')
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-100 font-bold text-slate-800">تقرير متابعة التواريخ والمنتجات القريبة من الانتهاء</div>
            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm">
                    <thead class="bg-slate-50 text-slate-600 font-medium">
                        <tr>
                            <th class="p-4">المنتج / الدواء</th>
                            <th class="p-4">الدفعة</th>
                            <th class="p-4">المستودع</th>
                            <th class="p-4">الكمية</th>
                            <th class="p-4">تاريخ الانتهاء</th>
                            <th class="p-4">الحالة</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($expiryReport as $b)
                            <tr class="hover:bg-slate-50">
                                <td class="p-4 font-bold text-slate-900">{{ $b->product->name ?? '-' }}</td>
                                <td class="p-4 font-mono text-xs">{{ $b->batch_number }}</td>
                                <td class="p-4 text-slate-600">{{ $b->warehouse->name_ar ?? '-' }}</td>
                                <td class="p-4 font-bold">{{ $b->quantity }}</td>
                                <td class="p-4 font-mono text-xs font-bold">{{ $b->expiry_date->format('Y-m-d') }}</td>
                                <td class="p-4">
                                    <span class="px-2.5 py-1 text-xs rounded-full font-bold {{ $b->is_expired ? 'bg-red-600 text-white' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $b->is_expired ? 'منتهي' : 'ينتهي قريباً' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="p-8 text-center text-slate-400">لا توجد دفعات منتهية أو قريبة الانتهاء.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
