@php
    $isEn = app()->getLocale() == 'en';
@endphp

<x-admin-layout title="{{ $isEn ? 'Financial Operations & Analytics' : 'الإدارة والعمليات المالية والتحليلات' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Financial Operations & ZATCA Dashboard' : 'لوحة القيادة المالية والفلترة وتكامل ZATCA' }}</x-slot>

    <div class="space-y-8 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">

        {{-- Header Bar --}}
        <div style="background: linear-gradient(135deg, #004823 0%, #006C35 50%, #00381B 100%) !important;" class="p-8 rounded-3xl text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 border border-white/10">
            <div>
                <h2 class="text-2xl font-black mb-1 text-white">{{ $isEn ? 'Financial Operations & ZATCA E-Invoicing' : 'العمليات المالية والفواتير الإلكترونية ZATCA' }}</h2>
                <p class="text-xs text-medical-200">{{ $isEn ? 'Real-time revenue metrics, payments, invoices, ZATCA e-invoicing compliance, and refunds' : 'تحليلات الإيرادات الفورية، الفواتير المعتمدة من ZATCA، المدفوعات، وطلبات الاسترجاع' }}</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.finance.invoices.index') }}" class="px-5 py-2.5 bg-white text-[#006C35] hover:bg-emerald-50 rounded-2xl text-xs font-black shadow-md transition-all">
                    {{ $isEn ? 'Manage Invoices' : 'إدارة الفواتير' }}
                </a>
                <a href="{{ route('admin.finance.vat-report') }}" class="px-5 py-2.5 bg-accent text-white hover:bg-emerald-600 rounded-2xl text-xs font-black shadow-md transition-all">
                    {{ $isEn ? 'ZATCA VAT Report' : 'تقرير ضريبة القيمة المضافة' }}
                </a>
            </div>
        </div>

        {{-- KPI Metric Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                <span class="text-xs font-bold text-gray-500">{{ $isEn ? 'Total Collected Revenue' : 'إجمالي الإيرادات المحصلة' }}</span>
                <div class="text-3xl font-black text-[#006C35] dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($totalRevenue, 2) }} <span class="text-xs font-bold">ر.س</span></div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                <span class="text-xs font-bold text-emerald-600">{{ $isEn ? 'Paid Invoices Volume' : 'قيمة الفواتير المسددة' }}</span>
                <div class="text-3xl font-black text-emerald-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($paidInvoicesTotal, 2) }} <span class="text-xs font-bold">ر.س</span></div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                <span class="text-xs font-bold text-amber-600">{{ $isEn ? 'Pending Unpaid Invoices' : 'فواتير غير مسددة (آجلة)' }}</span>
                <div class="text-3xl font-black text-amber-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($pendingInvoicesTotal, 2) }} <span class="text-xs font-bold">ر.س</span></div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                <span class="text-xs font-bold text-teal-600">{{ $isEn ? 'VAT 15% Collected' : 'حصيلة الضريبة 15% (ZATCA)' }}</span>
                <div class="text-3xl font-black text-teal-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($vatCollectedTotal, 2) }} <span class="text-xs font-bold">ر.س</span></div>
            </div>
        </div>

        {{-- Revenue Breakdown: Corporate vs Individual --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Corporate Contracts Revenue' : 'إيرادات عقود ومجتمعات الشركات' }}</h3>
                    <span class="px-3 py-1 bg-blue-50 text-blue-800 rounded-full font-bold text-[11px]">B2B</span>
                </div>
                <div class="text-2xl font-black text-blue-900 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($corporateRevenue, 2) }} ر.س</div>
                <p class="text-xs text-gray-500">{{ $isEn ? 'Revenue generated from corporate client service requests and contract billings' : 'الإيرادات المحصلة من مطالبة شركات القطاع الخاص والعقود' }}</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Individual Patients Revenue' : 'إيرادات الأفراد والخدمات المنزلية' }}</h3>
                    <span class="px-3 py-1 bg-purple-50 text-purple-800 rounded-full font-bold text-[11px]">B2C</span>
                </div>
                <div class="text-2xl font-black text-purple-900 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($individualRevenue, 2) }} ر.س</div>
                <p class="text-xs text-gray-500">{{ $isEn ? 'Revenue generated from direct patient bookings and medical store orders' : 'الإيرادات المحصلة مباشرة من حروجزات خدمات الأفراد ومتجر المستلزمات' }}</p>
            </div>
        </div>

        {{-- Pending Refund Requests Table --}}
        @if($pendingRefunds->count() > 0)
            <div class="bg-amber-50/60 rounded-3xl border border-amber-200 p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-amber-200 pb-3">
                    <h3 class="font-black text-sm text-amber-900">{{ $isEn ? 'Pending Refund Requests Requiring Approval' : 'طلبات استرجاع قيد الانتظار وتتطلب اعتماد الإدارة' }} ({{ $pendingRefunds->count() }})</h3>
                    <a href="{{ route('admin.finance.refunds.index') }}" class="text-xs font-bold text-amber-800 hover:underline">{{ $isEn ? 'View All Refunds' : 'عرض كافة الطلبات' }} →</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }}">
                        <thead>
                            <tr class="text-amber-800 font-extrabold border-b border-amber-200">
                                <th class="p-3">#</th>
                                <th class="p-3">{{ $isEn ? 'Refund Code' : 'رمز الطلب' }}</th>
                                <th class="p-3">{{ $isEn ? 'Customer' : 'العميل' }}</th>
                                <th class="p-3">{{ $isEn ? 'Amount' : 'المبلغ' }}</th>
                                <th class="p-3">{{ $isEn ? 'Reason' : 'سبب الاسترجاع' }}</th>
                                <th class="p-3 text-center">{{ $isEn ? 'Actions' : 'الإجراء' }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-200/50">
                            @foreach($pendingRefunds as $refund)
                                <tr>
                                    <td class="p-3 font-bold text-amber-900">{{ $refund->id }}</td>
                                    <td class="p-3 font-black text-amber-900 dir-ltr">{{ $refund->refund_number }}</td>
                                    <td class="p-3 font-bold text-gray-800">{{ $refund->user->name ?? '-' }}</td>
                                    <td class="p-3 font-black text-amber-900 dir-ltr">{{ number_format($refund->amount, 2) }} ر.س</td>
                                    <td class="p-3 text-gray-700 font-medium">{{ Str::limit($refund->reason, 40) }}</td>
                                    <td class="p-3 flex items-center justify-center gap-2">
                                        <form action="{{ route('admin.finance.refunds.approve', $refund->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-[11px]">قبول</button>
                                        </form>
                                        <form action="{{ route('admin.finance.refunds.reject', $refund->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-rose-600 hover:bg-rose-700 text-white rounded-xl font-bold text-[11px]">رفض</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Recent Invoices --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <h3 class="font-black text-base text-primary">{{ $isEn ? 'Recent ZATCA Tax Invoices' : 'أحدث الفواتير الضريبية المعتمدة' }}</h3>
                <a href="{{ route('admin.finance.invoices.index') }}" class="text-xs font-bold text-primary hover:underline">{{ $isEn ? 'View All Invoices' : 'عرض السجل الكامل' }} →</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }}">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 font-extrabold border-b border-gray-100">
                            <th class="p-3.5">#</th>
                            <th class="p-3.5">{{ $isEn ? 'Invoice #' : 'رقم الفاتورة' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Customer / Company' : 'العميل / الشركة' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Status' : 'حالة الدفع' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Total (SAR)' : 'المجموع' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Actions' : 'الإجراء' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentInvoices as $inv)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3.5 font-bold text-gray-400">{{ $inv->id }}</td>
                                <td class="p-3.5 font-black text-primary dir-ltr">{{ $inv->invoice_number }}</td>
                                <td class="p-3.5 font-bold text-gray-800">{{ $inv->user->name ?? $inv->company->name ?? '-' }}</td>
                                <td class="p-3.5">
                                    @if($inv->payment_status === 'paid')
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 font-extrabold text-[11px] rounded-full">مسددة</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-amber-50 text-amber-700 font-extrabold text-[11px] rounded-full">غير مسددة</span>
                                    @endif
                                </td>
                                <td class="p-3.5 font-black text-gray-900 dir-ltr">{{ number_format($inv->total_amount, 2) }}</td>
                                <td class="p-3.5">
                                    <a href="{{ route('admin.finance.invoices.show', $inv->id) }}" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-[11px]">
                                        {{ $isEn ? 'Details' : 'التفاصيل' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center text-gray-400 font-bold">{{ $isEn ? 'No invoices registered yet.' : 'لا توجد فواتير مسجلة بعد.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-admin-layout>
