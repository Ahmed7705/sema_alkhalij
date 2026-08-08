@php
    $isEn = app()->getLocale() == 'en';
@endphp

<x-admin-layout title="{{ $isEn ? 'ZATCA VAT 15% Report' : 'تقرير ضريبة القيمة المضافة ZATCA (15%)' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'ZATCA Tax Compliance & VAT 15% Summary' : 'تقرير الإقرار والامتثال الضريبي - ضريبة القيمة المضافة 15%' }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">

        <div class="flex items-center justify-between">
            <a href="{{ route('admin.finance.dashboard') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800">
                ← {{ $isEn ? 'Back to Finance Dashboard' : 'الرجوع للوحة المالية' }}
            </a>
            <button onclick="window.print()" class="px-5 py-2 bg-[#006C35] hover:bg-[#00572B] text-white rounded-xl font-extrabold text-xs shadow-md">
                {{ $isEn ? 'Print VAT Report' : 'طباعة الإقرار الضريبي' }}
            </button>
        </div>

        {{-- VAT Overview Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                <span class="text-xs font-bold text-gray-500">إجمالي المبيعات والخدمات (غير شامل الضريبة)</span>
                <div class="text-2xl font-black text-gray-900 dir-ltr">{{ number_format($totalSubtotal, 2) }} ر.س</div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                <span class="text-xs font-bold text-emerald-600">حصيلة ضريبة القيمة المضافة المستحقة (15%)</span>
                <div class="text-2xl font-black text-emerald-600 dir-ltr">{{ number_format($totalVat, 2) }} ر.س</div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                <span class="text-xs font-bold text-teal-600">المجموع الشامل شامل الضريبة</span>
                <div class="text-2xl font-black text-teal-600 dir-ltr">{{ number_format($totalInclusive, 2) }} ر.س</div>
            </div>
        </div>

        {{-- Detailed Invoices Table --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-4">
            <h3 class="font-black text-base text-primary border-b border-gray-100 pb-3">تفاصيل الفواتير الخاضعة للضريبة</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }}">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 font-extrabold border-b border-gray-100">
                            <th class="p-3">#</th>
                            <th class="p-3">رقم الفاتورة</th>
                            <th class="p-3">تاريخ الإصدار</th>
                            <th class="p-3">العميل / الشركة</th>
                            <th class="p-3">المبلغ الصافي</th>
                            <th class="p-3">الضريبة 15%</th>
                            <th class="p-3">المجموع الشامل</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($invoices as $idx => $inv)
                            <tr>
                                <td class="p-3 font-bold text-gray-400">{{ $idx + 1 }}</td>
                                <td class="p-3 font-black text-primary dir-ltr">{{ $inv->invoice_number }}</td>
                                <td class="p-3 font-medium text-gray-600 dir-ltr">{{ $inv->issue_date->format('Y-m-d') }}</td>
                                <td class="p-3 font-bold text-gray-800">{{ $inv->user->name ?? $inv->company->name ?? '-' }}</td>
                                <td class="p-3 font-bold text-gray-700 dir-ltr">{{ number_format($inv->subtotal, 2) }}</td>
                                <td class="p-3 font-bold text-emerald-700 dir-ltr">{{ number_format($inv->vat_amount, 2) }}</td>
                                <td class="p-3 font-black text-gray-900 dir-ltr">{{ number_format($inv->total_amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-6 text-center text-gray-400 font-bold">لا توجد فواتير مسددة مسجلة في هذا التقرير.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-admin-layout>
