@php
    $isEn = app()->getLocale() == 'en';
@endphp

<x-admin-layout title="{{ $isEn ? 'Invoices Management' : 'سجل الفواتير الضريبية ZATCA' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Tax Invoices Register & ZATCA Status' : 'سجل الفواتير الضريبية المعتمدة والتكامل مع ZATCA' }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}" x-data="{ openCorporateModal: false }">

        {{-- Filter & Action Bar --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form method="GET" action="{{ route('admin.finance.invoices.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $isEn ? 'Search invoice #, customer name...' : 'بحث برقم الفاتورة، اسم العميل، الجوال...' }}" class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs font-bold w-64 focus:outline-none focus:border-primary">
                
                <select name="payment_status" class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                    <option value="">{{ $isEn ? 'All Payment Statuses' : 'جميع حالات الدفع' }}</option>
                    <option value="paid" {{ request('payment_status') === 'paid' ? 'selected' : '' }}>مسددة (Paid)</option>
                    <option value="unpaid" {{ request('payment_status') === 'unpaid' ? 'selected' : '' }}>غير مسددة (Unpaid)</option>
                    <option value="refunded" {{ request('payment_status') === 'refunded' ? 'selected' : '' }}>مسترجعة (Refunded)</option>
                </select>

                <select name="company_id" class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                    <option value="">{{ $isEn ? 'All Companies' : 'جميع الشركات' }}</option>
                    @foreach($companies as $comp)
                        <option value="{{ $comp->id }}" {{ request('company_id') == $comp->id ? 'selected' : '' }}>{{ $comp->name }}</option>
                    @endforeach
                </select>

                <button type="submit" class="px-5 py-2.5 bg-primary text-white font-black rounded-xl text-xs hover:bg-primary-dark transition-all">
                    {{ $isEn ? 'Filter' : 'بحث وتصفية' }}
                </button>
            </form>

            <button @click="openCorporateModal = true" class="px-5 py-2.5 bg-[#006C35] hover:bg-[#00572B] text-white font-extrabold rounded-2xl text-xs shadow-md transition-all whitespace-nowrap">
                + {{ $isEn ? 'Issue Corporate Invoice' : 'إصدار فاتورة مطالبة شركة' }}
            </button>
        </div>

        {{-- Invoices Table --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }}">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 font-extrabold border-b border-gray-100">
                            <th class="p-3.5">#</th>
                            <th class="p-3.5">{{ $isEn ? 'Invoice Number' : 'رقم الفاتورة' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Customer / Company' : 'العميل / الشركة المتعاقدة' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Issue Date' : 'تاريخ الإصدار' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Payment Status' : 'حالة السداد' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'ZATCA Status' : 'حالة ZATCA' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Total (SAR)' : 'المجموع الشامل' }}</th>
                            <th class="p-3.5 text-center">{{ $isEn ? 'Actions' : 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($invoices as $inv)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-3.5 font-bold text-gray-400">{{ $inv->id }}</td>
                                <td class="p-3.5 font-black text-primary dir-ltr">{{ $inv->invoice_number }}</td>
                                <td class="p-3.5 font-bold text-gray-800">
                                    {{ $inv->user->name ?? $inv->company->name ?? '-' }}
                                    @if($inv->company)
                                        <span class="block text-[10px] text-gray-400 font-medium">{{ $inv->company->name }}</span>
                                    @endif
                                </td>
                                <td class="p-3.5 font-medium text-gray-600 dir-ltr">{{ $inv->issue_date->format('Y-m-d') }}</td>
                                <td class="p-3.5">
                                    @if($inv->payment_status === 'paid')
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 font-extrabold text-[11px] rounded-full">مسددة بالكامل</span>
                                    @elseif($inv->payment_status === 'refunded')
                                        <span class="px-2.5 py-1 bg-rose-50 text-rose-700 font-extrabold text-[11px] rounded-full">مسترجعة</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-amber-50 text-amber-700 font-extrabold text-[11px] rounded-full">غير مسددة</span>
                                    @endif
                                </td>
                                <td class="p-3.5">
                                    <span class="px-2.5 py-1 bg-teal-50 text-teal-800 font-bold text-[10px] rounded-full border border-teal-200">
                                        ZATCA {{ strtoupper($inv->zatca_status) }}
                                    </span>
                                </td>
                                <td class="p-3.5 font-black text-gray-900 dir-ltr">{{ number_format($inv->total_amount, 2) }} ر.س</td>
                                <td class="p-3.5 flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.finance.invoices.show', $inv->id) }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-[11px]">
                                        {{ $isEn ? 'View Detail' : 'عرض والتفاصيل' }}
                                    </a>
                                    <a href="{{ route('invoices.download', $inv->id) }}" target="_blank" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-[11px] inline-flex items-center gap-1">
                                        <span>PDF</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No invoices found.' : 'لا توجد فواتير مطابقة للبحث.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pt-4">
                {{ $invoices->links() }}
            </div>
        </div>

        {{-- Issue Corporate Invoice Modal --}}
        <div x-show="openCorporateModal" x-cloak class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-3 sm:p-6 overflow-y-auto">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative border border-gray-100 space-y-4 text-right">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Issue Corporate Contract Invoice' : 'إصدار فاتورة مطالبة عقد شركة' }}</h3>
                    <button @click="openCorporateModal = false" class="text-gray-400 hover:text-gray-600">✕</button>
                </div>
                <form action="{{ route('admin.finance.invoices.corporate.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-1">اختر الشركة المتعاقدة *</label>
                        <select name="company_id" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold">
                            @foreach($companies as $comp)
                                <option value="{{ $comp->id }}">{{ $comp->name }} ({{ $comp->company_code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-1">رقم/معرف العقد *</label>
                        <select name="contract_id" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold">
                            @foreach(\App\Models\Contract::where('status', 'active')->get() as $ct)
                                <option value="{{ $ct->id }}">{{ $ct->contract_code }} - {{ $ct->company->name ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-1">المبلغ غير شامل الضريبة (ر.س) *</label>
                        <input type="number" step="0.01" name="amount" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-1">الوصف / بيان المطالبة *</label>
                        <textarea name="description" rows="2" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold resize-none">مطالبة شهرية لعقد الخدمات الطبية المعتمدة للشركات</textarea>
                    </div>
                    <div class="pt-2 flex justify-end gap-2 border-t border-gray-100">
                        <button type="button" @click="openCorporateModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-xl text-xs">إلغاء</button>
                        <button type="submit" class="px-5 py-2 bg-[#006C35] text-white font-extrabold rounded-xl text-xs">إصدار الفاتورة الضريبية</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-admin-layout>
