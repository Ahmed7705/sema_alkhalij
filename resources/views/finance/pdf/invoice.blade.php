@php
    $isEn = app()->getLocale() == 'en';
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isEn ? 'ltr' : 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $isEn ? 'Tax Invoice - ' : 'فاتورة ضريبية - ' }}{{ $invoice->invoice_number }}</title>
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
    
    {{-- Print Controls --}}
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="javascript:history.back()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-xl text-xs transition-all">
            ← {{ $isEn ? 'Back' : 'رجوع' }}
        </a>
        <button onclick="window.print()" class="px-6 py-2.5 bg-[#006C35] hover:bg-[#00572B] text-white font-extrabold rounded-xl text-xs shadow-md transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>{{ $isEn ? 'Print / Download PDF' : 'طباعة / حفظ كـ PDF' }}</span>
        </button>
    </div>

    {{-- Invoice Paper Card --}}
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-200 p-8 sm:p-12 space-y-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row items-start justify-between gap-6 border-b border-gray-200 pb-8">
            <div class="space-y-2">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-[#006C35] text-white flex items-center justify-center font-black text-xl">S</div>
                    <div>
                        <h1 class="text-xl font-black text-[#006C35]">{{ $isEn ? 'Sema Al-Khalij Medical Services' : 'شركة سما الخليج للخدمات الطبية' }}</h1>
                        <p class="text-xs text-gray-500 font-bold">{{ $isEn ? 'Tax Registration #' : 'الرقم الضريبي:' }} <span class="dir-ltr inline-block">300000000000003</span></p>
                    </div>
                </div>
                <p class="text-xs text-gray-500">{{ $isEn ? 'CR: 1010000000 | Licensed by Saudi Ministry of Health' : 'س.ت: 1010000000 | مرخص من وزارة الصحة السعودية' }}</p>
            </div>

            <div class="{{ $isEn ? 'text-right' : 'text-left' }} space-y-1">
                <span class="inline-block px-3.5 py-1 bg-emerald-50 text-emerald-800 font-black text-xs rounded-full border border-emerald-200">
                    {{ $isEn ? 'ZATCA TAX INVOICE' : 'فاتورة ضريبية معتمدة' }}
                </span>
                <h2 class="text-2xl font-black text-gray-900 dir-ltr">{{ $invoice->invoice_number }}</h2>
                <p class="text-xs text-gray-500 font-medium">{{ $isEn ? 'Issue Date:' : 'تاريخ الإصدار:' }} <span class="font-bold text-gray-800 dir-ltr">{{ $invoice->issue_date->format('Y-m-d') }}</span></p>
                @if($invoice->due_date)
                    <p class="text-xs text-gray-500 font-medium">{{ $isEn ? 'Due Date:' : 'تاريخ الاستحقاق:' }} <span class="font-bold text-gray-800 dir-ltr">{{ $invoice->due_date->format('Y-m-d') }}</span></p>
                @endif
            </div>
        </div>

        {{-- Buyer Info --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/80 p-6 rounded-2xl border border-gray-100 text-xs">
            <div class="space-y-1">
                <span class="font-black text-gray-400 uppercase tracking-wider block text-[10px]">{{ $isEn ? 'BILL TO (CUSTOMER / BENEFICIARY):' : 'العميل / المستفيد:' }}</span>
                <h3 class="font-black text-base text-gray-900">{{ $invoice->user->name ?? $invoice->company->name ?? 'عميل نقد' }}</h3>
                @if($invoice->user && $invoice->user->phone)
                    <p class="text-gray-600 font-bold dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $invoice->user->phone }}</p>
                @endif
                @if($invoice->user && $invoice->user->identification_number)
                    <p class="text-gray-500 font-medium">{{ $isEn ? 'ID / Iqama:' : 'رقم الهوية / الإقامة:' }} <span class="font-bold text-gray-800 dir-ltr">{{ $invoice->user->identification_number }}</span></p>
                @endif
            </div>

            @if($invoice->company)
                <div class="space-y-1 border-t md:border-t-0 md:border-r border-gray-200 pt-3 md:pt-0 {{ $isEn ? 'md:pl-6' : 'md:pr-6' }}">
                    <span class="font-black text-gray-400 uppercase tracking-wider block text-[10px]">{{ $isEn ? 'CORPORATE CLIENT:' : 'الشركة المتعاقدة:' }}</span>
                    <h3 class="font-black text-base text-gray-900">{{ $invoice->company->name }}</h3>
                    <p class="text-gray-600 font-bold">{{ $isEn ? 'Company Code:' : 'كود الشركة:' }} <span class="dir-ltr">{{ $invoice->company->company_code }}</span></p>
                    <p class="text-gray-500 font-medium">{{ $isEn ? 'CR Number:' : 'السجل التجاري:' }} <span class="font-bold text-gray-800 dir-ltr">{{ $invoice->company->cr_number }}</span></p>
                </div>
            @endif
        </div>

        {{-- Items Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                <thead>
                    <tr class="bg-[#006C35] text-white font-black border-b border-gray-200">
                        <th class="p-3.5 rounded-[#006C35]">#</th>
                        <th class="p-3.5">{{ $isEn ? 'Description' : 'البيان / الخدمة' }}</th>
                        <th class="p-3.5 text-center">{{ $isEn ? 'Qty' : 'الكمية' }}</th>
                        <th class="p-3.5 text-center">{{ $isEn ? 'Unit Price' : 'سعر الوحدة' }}</th>
                        <th class="p-3.5 text-center">{{ $isEn ? 'VAT (15%)' : 'الضريبة (15%)' }}</th>
                        <th class="p-3.5 rounded-[#006C35] {{ $isEn ? 'text-right' : 'text-left' }}">{{ $isEn ? 'Total (SAR)' : 'المجموع الشامل (ر.س)' }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($invoice->items as $idx => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3.5 font-bold text-gray-400">{{ $idx + 1 }}</td>
                            <td class="p-3.5 font-black text-gray-800">{{ $item->description }}</td>
                            <td class="p-3.5 text-center font-bold text-gray-700 dir-ltr">{{ $item->quantity }}</td>
                            <td class="p-3.5 text-center font-bold text-gray-700 dir-ltr">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="p-3.5 text-center font-bold text-gray-500 dir-ltr">{{ number_format($item->vat_amount, 2) }}</td>
                            <td class="p-3.5 font-black text-gray-900 dir-ltr {{ $isEn ? 'text-right' : 'text-left' }}">{{ number_format($item->total_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-400 font-bold">{{ $isEn ? 'No invoice items.' : 'لا توجد بنود.' }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Summary & ZATCA QR Code --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 items-end border-t border-gray-200 pt-6">
            
            {{-- ZATCA QR Code & Security Stamp --}}
            <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-200">
                <div class="p-2 bg-white rounded-xl border border-gray-300 shadow-sm shrink-0">
                    {{-- Base64 TLV QR Code Representation --}}
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode($invoice->qr_code_tlv) }}" alt="ZATCA QR Code" class="w-24 h-24">
                </div>
                <div class="space-y-1 text-[11px]">
                    <span class="font-black text-emerald-800 block">{{ $isEn ? 'ZATCA E-Invoice Phase 2 Compliant' : 'رمز الاستجابة السريعة (ZATCA)' }}</span>
                    <p class="text-gray-500 font-mono text-[9px] break-all leading-tight">UUID: {{ $invoice->uuid }}</p>
                    <p class="text-gray-500 font-mono text-[9px] break-all leading-tight">Hash: {{ substr($invoice->invoice_hash, 0, 24) }}...</p>
                </div>
            </div>

            {{-- Financial Totals Table --}}
            <div class="space-y-2 text-xs">
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <span class="font-bold text-gray-600">{{ $isEn ? 'Subtotal (Excl. VAT):' : 'المجموع الخاضع للضريبة:' }}</span>
                    <span class="font-black text-gray-900 dir-ltr">{{ number_format($invoice->subtotal, 2) }} ر.س</span>
                </div>
                <div class="flex justify-between py-1 border-b border-gray-100">
                    <span class="font-bold text-gray-600">{{ $isEn ? 'Value Added Tax (15%):' : 'ضريبة القيمة المضافة (15%):' }}</span>
                    <span class="font-black text-gray-900 dir-ltr">{{ number_format($invoice->vat_amount, 2) }} ر.س</span>
                </div>
                <div class="flex justify-between py-2 bg-emerald-50 p-3 rounded-xl border border-emerald-200">
                    <span class="font-black text-emerald-900 text-sm">{{ $isEn ? 'Total Amount Payable:' : 'إجمالي المطلب / الصافي:' }}</span>
                    <span class="font-black text-emerald-900 text-base dir-ltr">{{ number_format($invoice->total_amount, 2) }} ر.س</span>
                </div>
            </div>
        </div>

        {{-- Footer Disclaimer --}}
        <div class="border-t border-gray-100 pt-6 text-center text-gray-400 text-[11px] font-medium">
            <p>{{ $isEn ? 'Thank you for choosing Sema Al-Khalij Medical Services.' : 'شكراً لثقتكم بـ شركة سما الخليج للخدمات الطبية.' }}</p>
            <p class="dir-ltr mt-1">support@sema-alkhalij.com | +966 9200 00000 | www.sema-alkhalij.com</p>
        </div>
    </div>

</body>
</html>
