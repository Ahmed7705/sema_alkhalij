@php
    $isEn = app()->getLocale() == 'en';
@endphp

<x-admin-layout title="{{ $isEn ? 'Payment Transactions History' : 'سجل العمليات والمدفوعات المالية' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Payments & Gateway Transactions' : 'سجل المدفوعات وبوابات الدفع الإلكتروني' }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">

        {{-- Filter Bar --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <form method="GET" action="{{ route('admin.finance.payments.index') }}" class="flex flex-wrap items-center gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $isEn ? 'Search payment #, transaction ref...' : 'بحث برقم الدفع، الرقم المرجعي، اسم العميل...' }}" class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs font-bold w-64 focus:outline-none focus:border-primary">
                
                <select name="method" class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                    <option value="">{{ $isEn ? 'All Payment Methods' : 'جميع طرق الدفع' }}</option>
                    @foreach(\App\Services\PaymentGatewayService::SUPPORTED_METHODS as $code => $name)
                        <option value="{{ $code }}" {{ request('method') === $code ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>

                <select name="status" class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                    <option value="">{{ $isEn ? 'All Statuses' : 'جميع الحالات' }}</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>مكتملة (Completed)</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>معلقة (Pending)</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>فاشلة (Failed)</option>
                    <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>مسترجعة (Refunded)</option>
                </select>

                <button type="submit" class="px-5 py-2.5 bg-primary text-white font-black rounded-xl text-xs hover:bg-primary-dark transition-all">
                    {{ $isEn ? 'Filter' : 'بحث وتصفية' }}
                </button>
            </form>
        </div>

        {{-- Payments Table --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }}">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 font-extrabold border-b border-gray-100">
                            <th class="p-3.5">#</th>
                            <th class="p-3.5">{{ $isEn ? 'Payment Number' : 'رقم العملية' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Payer' : 'الدافع / العميل' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Method' : 'طريقة الدفع' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Txn Reference' : 'الرقم المرجعي' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Status' : 'الحالة' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Amount' : 'المبلغ' }}</th>
                            <th class="p-3.5 text-center">{{ $isEn ? 'Actions' : 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($payments as $pay)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-3.5 font-bold text-gray-400">{{ $pay->id }}</td>
                                <td class="p-3.5 font-black text-primary dir-ltr">{{ $pay->payment_number }}</td>
                                <td class="p-3.5 font-bold text-gray-800">{{ $pay->user->name ?? $pay->company->name ?? '-' }}</td>
                                <td class="p-3.5 font-bold text-gray-700">
                                    <span class="px-2.5 py-1 bg-gray-100 text-gray-800 rounded-full text-[11px]">
                                        {{ \App\Services\PaymentGatewayService::SUPPORTED_METHODS[$pay->payment_method] ?? $pay->payment_method }}
                                    </span>
                                </td>
                                <td class="p-3.5 font-mono text-gray-600 dir-ltr">{{ $pay->transaction_reference }}</td>
                                <td class="p-3.5">
                                    @if($pay->status === 'completed')
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 font-extrabold text-[11px] rounded-full">مكتملة</span>
                                    @elseif($pay->status === 'refunded')
                                        <span class="px-2.5 py-1 bg-rose-50 text-rose-700 font-extrabold text-[11px] rounded-full">مسترجعة</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-amber-50 text-amber-700 font-extrabold text-[11px] rounded-full">{{ $pay->status }}</span>
                                    @endif
                                </td>
                                <td class="p-3.5 font-black text-gray-900 dir-ltr">{{ number_format($pay->amount, 2) }} ر.س</td>
                                <td class="p-3.5 flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.finance.payments.show', $pay->id) }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-[11px]">
                                        {{ $isEn ? 'Details' : 'التفاصيل' }}
                                    </a>
                                    <a href="{{ route('receipts.download', $pay->id) }}" target="_blank" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-[11px]">
                                        {{ $isEn ? 'Receipt' : 'سند القبض' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No payment transactions recorded yet.' : 'لا توجد عمليات دفع مسجلة.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pt-4">
                {{ $payments->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>
