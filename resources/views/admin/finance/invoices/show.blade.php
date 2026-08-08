@php
    $isEn = app()->getLocale() == 'en';
@endphp

<x-admin-layout title="{{ $isEn ? 'Invoice Details' : 'تفاصيل الفاتورة الضريبية' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Tax Invoice Details & ZATCA Metadata' : 'تفاصيل الفاتورة الضريبية ZATCA والمدفوعات' }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">

        {{-- Header Navigation --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.finance.invoices.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800">
                ← {{ $isEn ? 'Back to Invoices Register' : 'الرجوع لسجل الفواتير' }}
            </a>
            <div class="flex items-center gap-2">
                <a href="{{ route('invoices.download', $invoice->id) }}" target="_blank" class="px-5 py-2 bg-[#006C35] hover:bg-[#00572B] text-white rounded-xl font-extrabold text-xs shadow-md transition-all inline-flex items-center gap-1.5">
                    <span>{{ $isEn ? 'Print / Download PDF' : 'طباعة / حفظ الفاتورة PDF' }}</span>
                </a>
            </div>
        </div>

        {{-- Invoice Overview Card --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row items-start justify-between gap-4 border-b border-gray-100 pb-6">
                <div>
                    <span class="px-3 py-1 bg-teal-50 text-teal-800 rounded-full font-extrabold text-[11px] border border-teal-200">
                        ZATCA {{ strtoupper($invoice->zatca_status) }}
                    </span>
                    <h2 class="text-2xl font-black text-gray-900 mt-2 dir-ltr">{{ $invoice->invoice_number }}</h2>
                    <p class="text-xs text-gray-500 mt-1 font-mono">UUID: {{ $invoice->uuid }}</p>
                </div>

                <div class="{{ $isEn ? 'text-right' : 'text-left' }} space-y-1">
                    <span class="text-xs text-gray-500 font-bold block">{{ $isEn ? 'Payment Status' : 'حالة الدفع:' }}</span>
                    @if($invoice->payment_status === 'paid')
                        <span class="inline-block px-4 py-1.5 bg-emerald-50 text-emerald-700 font-black text-xs rounded-full">مسددة بالكامل (Paid)</span>
                    @elseif($invoice->payment_status === 'refunded')
                        <span class="inline-block px-4 py-1.5 bg-rose-50 text-rose-700 font-black text-xs rounded-full">مسترجعة (Refunded)</span>
                    @else
                        <span class="inline-block px-4 py-1.5 bg-amber-50 text-amber-700 font-black text-xs rounded-full">غير مسددة (Unpaid)</span>
                    @endif
                </div>
            </div>

            {{-- Customer & Dates Info --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs bg-gray-50 p-5 rounded-2xl border border-gray-100">
                <div class="space-y-1">
                    <span class="font-extrabold text-gray-400 block text-[10px]">{{ $isEn ? 'CUSTOMER / BENEFICIARY' : 'العميل / المستفيد' }}</span>
                    <h4 class="font-black text-sm text-gray-900">{{ $invoice->user->name ?? $invoice->company->name ?? '-' }}</h4>
                    <p class="text-gray-500 font-bold dir-ltr">{{ $invoice->user->phone ?? '' }}</p>
                </div>

                <div class="space-y-1">
                    <span class="font-extrabold text-gray-400 block text-[10px]">{{ $isEn ? 'CORPORATE CLIENT' : 'الشركة المتعاقدة' }}</span>
                    <h4 class="font-black text-sm text-gray-900">{{ $invoice->company->name ?? '-' }}</h4>
                    <p class="text-gray-500 font-bold dir-ltr">{{ $invoice->company->company_code ?? 'حساب أفراد' }}</p>
                </div>

                <div class="space-y-1">
                    <span class="font-extrabold text-gray-400 block text-[10px]">{{ $isEn ? 'DATES' : 'التواريخ' }}</span>
                    <p class="text-gray-800 font-bold">{{ $isEn ? 'Issue Date:' : 'تاريخ الإصدار:' }} <span class="dir-ltr">{{ $invoice->issue_date->format('Y-m-d') }}</span></p>
                    <p class="text-gray-800 font-bold">{{ $isEn ? 'Due Date:' : 'تاريخ الاستحقاق:' }} <span class="dir-ltr">{{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : '-' }}</span></p>
                </div>
            </div>

            {{-- Line Items --}}
            <div class="space-y-3">
                <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Invoice Items' : 'بنود الفاتورة الضريبية' }}</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }}">
                        <thead>
                            <tr class="bg-gray-100 font-black text-gray-600">
                                <th class="p-3">#</th>
                                <th class="p-3">{{ $isEn ? 'Description' : 'البيان' }}</th>
                                <th class="p-3 text-center">{{ $isEn ? 'Qty' : 'الكمية' }}</th>
                                <th class="p-3 text-center">{{ $isEn ? 'Unit Price' : 'السعر غير شامل الضريبة' }}</th>
                                <th class="p-3 text-center">{{ $isEn ? 'VAT 15%' : 'الضريبة (15%)' }}</th>
                                <th class="p-3 {{ $isEn ? 'text-right' : 'text-left' }}">{{ $isEn ? 'Total' : 'المجموع' }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($invoice->items as $idx => $item)
                                <tr>
                                    <td class="p-3 font-bold text-gray-400">{{ $idx + 1 }}</td>
                                    <td class="p-3 font-black text-gray-800">{{ $item->description }}</td>
                                    <td class="p-3 text-center font-bold text-gray-700 dir-ltr">{{ $item->quantity }}</td>
                                    <td class="p-3 text-center font-bold text-gray-700 dir-ltr">{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="p-3 text-center font-bold text-gray-500 dir-ltr">{{ number_format($item->vat_amount, 2) }}</td>
                                    <td class="p-3 font-black text-gray-900 dir-ltr {{ $isEn ? 'text-right' : 'text-left' }}">{{ number_format($item->total_amount, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Summary Totals --}}
            <div class="border-t border-gray-100 pt-4 flex flex-col items-end gap-2 text-xs">
                <div class="w-72 space-y-1">
                    <div class="flex justify-between py-1 border-b border-gray-100">
                        <span class="font-bold text-gray-500">المجموع الخاضع للضريبة:</span>
                        <span class="font-black text-gray-900 dir-ltr">{{ number_format($invoice->subtotal, 2) }} ر.س</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-gray-100">
                        <span class="font-bold text-gray-500">ضريبة القيمة المضافة (15%):</span>
                        <span class="font-black text-gray-900 dir-ltr">{{ number_format($invoice->vat_amount, 2) }} ر.س</span>
                    </div>
                    <div class="flex justify-between py-2 bg-emerald-50 p-3 rounded-xl border border-emerald-200">
                        <span class="font-black text-emerald-900 text-sm">المجموع الشامل للضريبة:</span>
                        <span class="font-black text-emerald-900 text-base dir-ltr">{{ number_format($invoice->total_amount, 2) }} ر.س</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Payments Section --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-4">
            <h3 class="font-black text-base text-primary border-b border-gray-100 pb-3">{{ $isEn ? 'Payment Transactions History' : 'سجل العمليات المالية المرتبطة' }}</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }}">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 font-extrabold border-b border-gray-100">
                            <th class="p-3">#</th>
                            <th class="p-3">{{ $isEn ? 'Payment Number' : 'رقم عملية الدفع' }}</th>
                            <th class="p-3">{{ $isEn ? 'Method' : 'طريقة الدفع' }}</th>
                            <th class="p-3">{{ $isEn ? 'Reference' : 'الرقم المرجعي' }}</th>
                            <th class="p-3">{{ $isEn ? 'Status' : 'الحالة' }}</th>
                            <th class="p-3">{{ $isEn ? 'Amount' : 'المبلغ' }}</th>
                            <th class="p-3 text-center">{{ $isEn ? 'Receipt' : 'سند القبض' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($invoice->payments as $pay)
                            <tr>
                                <td class="p-3 font-bold text-gray-400">{{ $pay->id }}</td>
                                <td class="p-3 font-black text-primary dir-ltr">{{ $pay->payment_number }}</td>
                                <td class="p-3 font-bold text-gray-800">{{ \App\Services\PaymentGatewayService::SUPPORTED_METHODS[$pay->payment_method] ?? $pay->payment_method }}</td>
                                <td class="p-3 font-mono text-gray-600 dir-ltr">{{ $pay->transaction_reference }}</td>
                                <td class="p-3 font-bold">
                                    @if($pay->status === 'completed')
                                        <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-full text-[10px]">مكتملة</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-rose-100 text-rose-800 rounded-full text-[10px]">{{ $pay->status }}</span>
                                    @endif
                                </td>
                                <td class="p-3 font-black text-gray-900 dir-ltr">{{ number_format($pay->amount, 2) }} ر.س</td>
                                <td class="p-3 text-center">
                                    <a href="{{ route('receipts.download', $pay->id) }}" target="_blank" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-[10px]">
                                        سند القبض
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-6 text-center text-gray-400 font-bold">{{ $isEn ? 'No payment transactions recorded yet.' : 'لم يتم تسجيل عمليات دفع لهذه الفاتورة بعد.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-admin-layout>
