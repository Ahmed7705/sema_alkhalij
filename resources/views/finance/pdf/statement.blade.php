@php
    $isEn = app()->getLocale() == 'en';
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isEn ? 'ltr' : 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $isEn ? 'Account Statement - ' : 'كشف حساب شركة - ' }}{{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Alexandria:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: {{ $isEn ? "'Outfit', sans-serif" : "'Alexandria', sans-serif" }}; }
        @media print {
            .no-print { display: none !important; }
            body { background: white; padding: 0; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-4 sm:p-8">

    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="javascript:history.back()" class="px-4 py-2 bg-gray-200 text-gray-700 font-bold rounded-xl text-xs">
            ← {{ $isEn ? 'Back' : 'رجوع' }}
        </a>
        <button onclick="window.print()" class="px-6 py-2.5 bg-[#006C35] text-white font-extrabold rounded-xl text-xs shadow-md">
            {{ $isEn ? 'Print Statement' : 'طباعة كشف الحساب' }}
        </button>
    </div>

    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-200 p-8 sm:p-12 space-y-8">
        
        {{-- Statement Header --}}
        <div class="flex items-center justify-between border-b border-gray-200 pb-6">
            <div>
                <h1 class="text-xl font-black text-[#006C35]">{{ $isEn ? 'Sema Al-Khalij Medical Services' : 'شركة سما الخليج للخدمات الطبية' }}</h1>
                <p class="text-xs text-gray-500 font-bold">{{ $isEn ? 'Corporate Statement of Account' : 'كشف حساب مالي للشركات المتعاقدة' }}</p>
            </div>
            <div class="{{ $isEn ? 'text-right' : 'text-left' }}">
                <h2 class="text-lg font-black text-gray-900">{{ $company->name }}</h2>
                <p class="text-xs text-gray-500 font-bold dir-ltr">{{ $isEn ? 'Code:' : 'كود:' }} {{ $company->company_code }} | CR: {{ $company->cr_number }}</p>
                <p class="text-xs text-gray-500 font-medium dir-ltr">{{ date('Y-m-d H:i') }}</p>
            </div>
        </div>

        {{-- Financial Summary Cards --}}
        <div class="grid grid-cols-3 gap-4 text-xs">
            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-200 space-y-1">
                <span class="font-bold text-gray-500">{{ $isEn ? 'Total Invoiced:' : 'إجمالي المطالبات والفتورة:' }}</span>
                <div class="text-xl font-black text-gray-900 dir-ltr">{{ number_format($totalInvoiced, 2) }} ر.س</div>
            </div>
            <div class="bg-emerald-50 p-4 rounded-2xl border border-emerald-200 space-y-1">
                <span class="font-bold text-emerald-800">{{ $isEn ? 'Total Paid:' : 'إجمالي السدادات:' }}</span>
                <div class="text-xl font-black text-emerald-900 dir-ltr">{{ number_format($totalPaid, 2) }} ر.س</div>
            </div>
            <div class="bg-amber-50 p-4 rounded-2xl border border-amber-200 space-y-1">
                <span class="font-bold text-amber-800">{{ $isEn ? 'Balance Due:' : 'الرصيد المتبقي المستحق:' }}</span>
                <div class="text-xl font-black text-amber-900 dir-ltr">{{ number_format($balanceDue, 2) }} ر.س</div>
            </div>
        </div>

        {{-- Invoices Table --}}
        <div class="space-y-3">
            <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Invoices Breakdown' : 'سجل الفواتير والمطالبات' }}</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                    <thead>
                        <tr class="bg-gray-100 font-black text-gray-600">
                            <th class="p-3">#</th>
                            <th class="p-3">{{ $isEn ? 'Invoice #' : 'رقم الفاتورة' }}</th>
                            <th class="p-3">{{ $isEn ? 'Issue Date' : 'تاريخ الإصدار' }}</th>
                            <th class="p-3">{{ $isEn ? 'Due Date' : 'تاريخ الاستحقاق' }}</th>
                            <th class="p-3">{{ $isEn ? 'Status' : 'حالة السداد' }}</th>
                            <th class="p-3 text-left">{{ $isEn ? 'Amount (SAR)' : 'المبلغ الشامل (ر.س)' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($invoices as $idx => $inv)
                            <tr>
                                <td class="p-3 text-gray-400 font-bold">{{ $idx + 1 }}</td>
                                <td class="p-3 font-black text-primary dir-ltr">{{ $inv->invoice_number }}</td>
                                <td class="p-3 font-medium text-gray-600 dir-ltr">{{ $inv->issue_date->format('Y-m-d') }}</td>
                                <td class="p-3 font-medium text-gray-600 dir-ltr">{{ $inv->due_date ? $inv->due_date->format('Y-m-d') : '-' }}</td>
                                <td class="p-3 font-bold">
                                    @if($inv->payment_status === 'paid')
                                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-full text-[10px]">مكتملة</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-amber-100 text-amber-800 rounded-full text-[10px]">غير مسددة</span>
                                    @endif
                                </td>
                                <td class="p-3 font-black text-gray-900 dir-ltr text-left">{{ number_format($inv->total_amount, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center text-gray-400 font-bold">{{ $isEn ? 'No invoices found.' : 'لا توجد فواتير مسجلة.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
