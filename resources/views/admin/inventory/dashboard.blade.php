@extends('layouts.admin')

@section('title', 'إدارة المخزون والصيدلية والمشتريات')

@section('content')
<div class="space-y-6" dir="rtl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-900 text-white p-6 rounded-2xl shadow-lg border border-slate-800">
        <div>
            <h1 class="text-2xl font-bold font-alexandria flex items-center gap-3">
                <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                لوحة عمليات المخزون والصيدلية والمشتريات
            </h1>
            <p class="text-slate-400 text-sm mt-1">متابعة المستودعات، الدفعات، الأدوية المنتهية، صرف الوصفات وأوامر الشراء</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.inventory.pharmacy.dispense') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-medium px-4 py-2.5 rounded-xl transition shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                صرف دواء/وصفة جديدة
            </a>
            <a href="{{ route('admin.inventory.purchasing.index') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-medium px-4 py-2.5 rounded-xl transition shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                أمر شراء جديد
            </a>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">المستودعات النشطة</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalWarehouses) }}</h3>
            </div>
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">إجمالي الدفعات المخزونية</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalBatches) }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">إجمالي كمية المخزون</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalQuantity) }}</h3>
            </div>
            <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10M7 12h10m-7 5h7"/></svg>
            </div>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">القيمة التقديرية للشراء</p>
                <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($totalValuation, 2) }} <span class="text-xs font-normal">ر.س</span></h3>
            </div>
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <!-- Alert Widgets -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Low Stock Alert -->
        <div class="bg-white rounded-2xl border border-amber-200 p-5 shadow-sm">
            <h3 class="font-bold text-amber-800 text-base flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                تنبيهات انخفاض المخزون (أقل من 10)
            </h3>
            <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                @forelse($lowStockAlerts as $alert)
                    <div class="flex items-center justify-between text-xs bg-amber-50 p-2.5 rounded-lg border border-amber-100">
                        <span class="font-semibold text-slate-800">{{ $alert->product->name ?? 'منتج' }}</span>
                        <span class="bg-amber-200 text-amber-900 font-bold px-2 py-0.5 rounded">{{ $alert->quantity }} متبقي</span>
                    </div>
                @empty
                    <p class="text-xs text-slate-400">لا يوجد انخفاض في المخزون حالياً.</p>
                @endforelse
            </div>
        </div>

        <!-- Expiring Soon Alert -->
        <div class="bg-white rounded-2xl border border-rose-200 p-5 shadow-sm">
            <h3 class="font-bold text-rose-800 text-base flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                تنبيهات قرب الانتهاء (خلال 60 يوم)
            </h3>
            <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                @forelse($expiringSoonAlerts as $alert)
                    <div class="flex items-center justify-between text-xs bg-rose-50 p-2.5 rounded-lg border border-rose-100">
                        <div>
                            <p class="font-semibold text-slate-800">{{ $alert->product->name ?? 'دواء' }}</p>
                            <p class="text-[10px] text-slate-500">دفعة: {{ $alert->batch_number }}</p>
                        </div>
                        <span class="bg-rose-200 text-rose-900 font-bold px-2 py-0.5 rounded">{{ $alert->expiry_date->format('Y-m-d') }}</span>
                    </div>
                @empty
                    <p class="text-xs text-slate-400">لا توجد أدوية تنتهي قريباً.</p>
                @endforelse
            </div>
        </div>

        <!-- Expired Alert -->
        <div class="bg-white rounded-2xl border border-red-300 p-5 shadow-sm">
            <h3 class="font-bold text-red-900 text-base flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                أدوية ومنتجات منتهية الصلاحية
            </h3>
            <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                @forelse($expiredAlerts as $alert)
                    <div class="flex items-center justify-between text-xs bg-red-50 p-2.5 rounded-lg border border-red-200">
                        <div>
                            <p class="font-semibold text-red-900">{{ $alert->product->name ?? 'منتج' }}</p>
                            <p class="text-[10px] text-red-700">دفعة: {{ $alert->batch_number }}</p>
                        </div>
                        <span class="bg-red-600 text-white font-bold px-2 py-0.5 rounded">منتهي</span>
                    </div>
                @empty
                    <p class="text-xs text-slate-400">لا توجد منتجات منتهية الصلاحية.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Movements Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-lg">آخر حرّكات وحوالات المخزون</h3>
            <a href="{{ route('admin.inventory.stock.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">عرض جميع الحرّكات ←</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead class="bg-slate-50 text-slate-600 font-medium">
                    <tr>
                        <th class="p-4">رقم الحركة</th>
                        <th class="p-4">المنتج / الدواء</th>
                        <th class="p-4">الدفعة</th>
                        <th class="p-4">نوع الحركة</th>
                        <th class="p-4">الكمية</th>
                        <th class="p-4">المستودع</th>
                        <th class="p-4">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentMovements as $mov)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4 font-mono font-bold text-slate-700">{{ $mov->movement_number }}</td>
                            <td class="p-4 font-medium text-slate-900">{{ $mov->product->name ?? '-' }}</td>
                            <td class="p-4 text-xs font-mono text-slate-500">{{ $mov->batch->batch_number ?? '-' }}</td>
                            <td class="p-4">
                                <span class="inline-block px-2.5 py-1 text-xs rounded-lg font-bold 
                                    @if($mov->type==='stock_in') bg-emerald-100 text-emerald-800
                                    @elseif($mov->type==='dispense') bg-purple-100 text-purple-800
                                    @elseif($mov->type==='transfer') bg-blue-100 text-blue-800
                                    @else bg-slate-100 text-slate-800 @endif">
                                    {{ $mov->type }}
                                </span>
                            </td>
                            <td class="p-4 font-bold text-slate-800">{{ $mov->quantity }}</td>
                            <td class="p-4 text-slate-600">{{ $mov->toWarehouse->name_ar ?? $mov->fromWarehouse->name_ar ?? '-' }}</td>
                            <td class="p-4 text-xs text-slate-400">{{ $mov->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400">لا توجد حرّكات مخزونية مسجلة بعد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
