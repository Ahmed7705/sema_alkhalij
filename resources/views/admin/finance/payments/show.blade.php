@php
    $isEn = app()->getLocale() == 'en';
@endphp

<x-admin-layout title="{{ $isEn ? 'Payment Transaction Detail' : 'تفاصيل عملية الدفع' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Payment Transaction & Gateway Response' : 'تفاصيل عملية الدفع واستجابة بوابة الدفع' }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">

        <div class="flex items-center justify-between">
            <a href="{{ route('admin.finance.payments.index') }}" class="text-xs font-bold text-gray-500 hover:text-gray-800">
                ← {{ $isEn ? 'Back to Payments Register' : 'الرجوع لسجل المدفوعات' }}
            </a>
            <a href="{{ route('receipts.download', $payment->id) }}" target="_blank" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs rounded-xl shadow-md">
                {{ $isEn ? 'Print Payment Receipt' : 'طباعة سند القبض الرسمي' }}
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <div>
                    <span class="text-xs font-bold text-gray-400 block">{{ $isEn ? 'Payment Reference' : 'رقم الدفع المالي:' }}</span>
                    <h2 class="text-2xl font-black text-gray-900 dir-ltr">{{ $payment->payment_number }}</h2>
                </div>
                <div class="text-2xl font-black text-[#006C35] dir-ltr">
                    {{ number_format($payment->amount, 2) }} ر.س
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs bg-gray-50 p-5 rounded-2xl border border-gray-100">
                <div>
                    <span class="font-extrabold text-gray-400 block mb-1">طريقة الدفع:</span>
                    <span class="font-black text-sm text-gray-800">{{ \App\Services\PaymentGatewayService::SUPPORTED_METHODS[$payment->payment_method] ?? $payment->payment_method }}</span>
                </div>
                <div>
                    <span class="font-extrabold text-gray-400 block mb-1">الرقم المرجعي للعملية (Txn Reference):</span>
                    <span class="font-mono font-bold text-sm text-gray-800 dir-ltr block">{{ $payment->transaction_reference }}</span>
                </div>
                <div>
                    <span class="font-extrabold text-gray-400 block mb-1">تاريخ ووقت العملية:</span>
                    <span class="font-bold text-sm text-gray-800 dir-ltr block">{{ $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i:s') : $payment->created_at->format('Y-m-d H:i:s') }}</span>
                </div>
            </div>

            {{-- Gateway Response JSON Inspector --}}
            <div class="space-y-2">
                <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Gateway Response Payload' : 'استجابة بوابة الدفع (Gateway Response)' }}</h3>
                <pre class="bg-gray-900 text-emerald-400 p-4 rounded-2xl text-xs font-mono overflow-x-auto dir-ltr text-left">{{ json_encode($payment->gateway_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </div>

    </div>
</x-admin-layout>
