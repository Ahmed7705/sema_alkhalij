@extends('layouts.admin')

@section('title', 'سجل صرف الأدوية والوصفات الطبية')

@section('content')
<div class="space-y-6" dir="rtl">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold font-alexandria text-slate-900">سجل صرف الوصفات والأدوية الطبية</h1>
        <a href="{{ route('admin.inventory.pharmacy.dispense') }}" class="bg-emerald-600 hover:bg-emerald-500 text-white font-medium px-4 py-2.5 rounded-xl transition shadow">
            + صرف وصفة / علاج جديد
        </a>
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
                        <th class="p-4">رقم العملية</th>
                        <th class="p-4">المريض</th>
                        <th class="p-4">الطبيب الموصي</th>
                        <th class="p-4">الصيدلي الموزع</th>
                        <th class="p-4">المستودع</th>
                        <th class="p-4">عدد الأدوية المصروفة</th>
                        <th class="p-4">الإجمالي</th>
                        <th class="p-4">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($dispenses as $disp)
                        <tr class="hover:bg-slate-50">
                            <td class="p-4 font-mono font-bold text-slate-800">{{ $disp->dispense_number }}</td>
                            <td class="p-4 font-bold text-slate-900">{{ $disp->patient->name ?? '-' }}</td>
                            <td class="p-4 text-slate-600">{{ $disp->doctor->name ?? 'غير محدد' }}</td>
                            <td class="p-4 text-slate-600">{{ $disp->dispenser->name ?? '-' }}</td>
                            <td class="p-4 text-slate-600">{{ $disp->warehouse->name_ar ?? '-' }}</td>
                            <td class="p-4 font-bold text-purple-700">{{ $disp->items->sum('quantity') }} علبة/وحدة</td>
                            <td class="p-4 font-bold text-emerald-600">{{ number_format($disp->total_price, 2) }} ر.س</td>
                            <td class="p-4 text-xs text-slate-400">{{ $disp->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-slate-400">لا توجد عمليات صرف مسجلة.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
