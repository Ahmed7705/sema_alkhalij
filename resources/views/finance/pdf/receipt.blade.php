@php
    $isEn = app()->getLocale() == 'en';
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isEn ? 'ltr' : 'rtl' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $isEn ? 'Payment Receipt - ' : 'سند قبض رسمي - ' }}{{ $payment->payment_number }}</title>
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

    <div class="max-w-3xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="javascript:history.back()" class="px-4 py-2 bg-gray-200 text-gray-700 font-bold rounded-xl text-xs">
            ← {{ $isEn ? 'Back' : 'رجوع' }}
        </a>
        <button onclick="window.print()" class="px-6 py-2.5 bg-[#006C35] text-white font-extrabold rounded-xl text-xs shadow-md">
            {{ $isEn ? 'Print Receipt' : 'طباعة سند القبض' }}
        </button>
    </div>

    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl border border-gray-200 p-8 sm:p-12 space-y-8">
        
        {{-- Receipt Header --}}
        <div class="flex items-center justify-between border-b border-gray-200 pb-6">
            <div>
                <h1 class="text-lg font-black text-[#006C35]">{{ $isEn ? 'Sema Al-Khalij Medical Services' : 'شركة سما الخليج للخدمات الطبية' }}</h1>
                <p class="text-xs text-gray-500 font-bold">{{ $isEn ? 'Official Payment Receipt' : 'سند قبض مالي رسمي' }}</p>
            </div>
            <div class="{{ $isEn ? 'text-right' : 'text-left' }}">
                <h2 class="text-xl font-black text-gray-900 dir-ltr">{{ $payment->payment_number }}</h2>
                <p class="text-xs text-gray-500 font-bold dir-ltr">{{ $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i') : $payment->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>

        {{-- Amount Badge --}}
        <div class="bg-emerald-50 p-6 rounded-2xl border border-emerald-200 flex items-center justify-between">
            <span class="font-extrabold text-sm text-emerald-900">{{ $isEn ? 'Received Amount:' : 'المبلغ المستلم:' }}</span>
            <span class="text-3xl font-black text-emerald-900 dir-ltr">{{ number_format($payment->amount, 2) }} ر.س</span>
        </div>

        {{-- Receipt Details --}}
        <div class="space-y-4 text-xs">
            <div class="flex justify-between py-2 border-b border-gray-100">
                <span class="font-bold text-gray-500">{{ $isEn ? 'Payer Name:' : 'استلمنا من السيد/السادة:' }}</span>
                <span class="font-black text-gray-900">{{ $payment->user->name ?? $payment->company->name ?? 'عميل نقد' }}</span>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-100">
                <span class="font-bold text-gray-500">{{ $isEn ? 'Payment Method:' : 'طريقة الدفع:' }}</span>
                <span class="font-black text-gray-900">{{ \App\Services\PaymentGatewayService::SUPPORTED_METHODS[$payment->payment_method] ?? $payment->payment_method }}</span>
            </div>
            <div class="flex justify-between py-2 border-b border-gray-100">
                <span class="font-bold text-gray-500">{{ $isEn ? 'Transaction Reference:' : 'الرقم المرجعي للعملية:' }}</span>
                <span class="font-black text-gray-900 dir-ltr">{{ $payment->transaction_reference }}</span>
            </div>
            @if($payment->invoice)
                <div class="flex justify-between py-2 border-b border-gray-100">
                    <span class="font-bold text-gray-500">{{ $isEn ? 'Related Invoice:' : 'مقابل الفاتورة رقم:' }}</span>
                    <span class="font-black text-gray-900 dir-ltr">{{ $payment->invoice->invoice_number }}</span>
                </div>
            @endif
        </div>

        {{-- Signature --}}
        <div class="pt-8 flex justify-between items-end border-t border-gray-100 text-xs">
            <div class="text-center">
                <span class="font-bold text-gray-400 block mb-8">{{ $isEn ? 'Payer Signature' : 'توقيع المستلم / الدفع' }}</span>
                <div class="w-32 border-b border-gray-300"></div>
            </div>
            <div class="text-center">
                <span class="font-bold text-gray-400 block mb-8">{{ $isEn ? 'Finance Stamp & Signature' : 'ختم الإدارة المالية' }}</span>
                <div class="w-32 border-b border-gray-300"></div>
            </div>
        </div>

    </div>
</body>
</html>
