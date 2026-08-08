@php
    $isEn = app()->getLocale() == 'en';
@endphp

<x-admin-layout title="{{ $isEn ? 'Refund Requests Management' : 'إدارة طلبات الاعتماد والاسترجاع المالي' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Customer Refund Requests & Financial Approvals' : 'سجل طلبات الاسترجاع واعتمادات الإدارة المالية' }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">

        {{-- Filter Bar --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <form method="GET" action="{{ route('admin.finance.refunds.index') }}" class="flex flex-wrap items-center gap-3">
                <select name="status" class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                    <option value="">{{ $isEn ? 'All Statuses' : 'جميع الحالات' }}</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>قيد الانتظار (Pending)</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>مقبولة (Approved)</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>مرفوضة (Rejected)</option>
                </select>

                <button type="submit" class="px-5 py-2.5 bg-primary text-white font-black rounded-xl text-xs hover:bg-primary-dark transition-all">
                    {{ $isEn ? 'Filter' : 'تصفية' }}
                </button>
            </form>
        </div>

        {{-- Refunds Table --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }}">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 font-extrabold border-b border-gray-100">
                            <th class="p-3.5">#</th>
                            <th class="p-3.5">{{ $isEn ? 'Refund Code' : 'رمز الاسترجاع' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Customer' : 'العميل' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Amount' : 'المبلغ' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Reason' : 'السبب' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Status' : 'الحالة' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Processed Date' : 'تاريخ المعالجة' }}</th>
                            <th class="p-3.5 text-center">{{ $isEn ? 'Actions' : 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($refunds as $ref)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-3.5 font-bold text-gray-400">{{ $ref->id }}</td>
                                <td class="p-3.5 font-black text-primary dir-ltr">{{ $ref->refund_number }}</td>
                                <td class="p-3.5 font-bold text-gray-800">{{ $ref->user->name ?? '-' }}</td>
                                <td class="p-3.5 font-black text-gray-900 dir-ltr">{{ number_format($ref->amount, 2) }} ر.س</td>
                                <td class="p-3.5 text-gray-600 font-medium">{{ $ref->reason }}</td>
                                <td class="p-3.5">
                                    @if($ref->status === 'approved')
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 font-extrabold text-[11px] rounded-full">تمت الموافقة</span>
                                    @elseif($ref->status === 'rejected')
                                        <span class="px-2.5 py-1 bg-rose-50 text-rose-700 font-extrabold text-[11px] rounded-full">مرفوض</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-amber-50 text-amber-700 font-extrabold text-[11px] rounded-full">قيد المراجعة</span>
                                    @endif
                                </td>
                                <td class="p-3.5 text-gray-500 dir-ltr">{{ $ref->processed_at ? $ref->processed_at->format('Y-m-d H:i') : '-' }}</td>
                                <td class="p-3.5 flex items-center justify-center gap-2">
                                    @if($ref->status === 'pending')
                                        <form action="{{ route('admin.finance.refunds.approve', $ref->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-[11px]">اعتماد وقبول</button>
                                        </form>
                                        <form action="{{ route('admin.finance.refunds.reject', $ref->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-rose-600 hover:bg-rose-700 text-white font-bold rounded-xl text-[11px]">رفض</button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 font-medium text-[11px] italic">مكتمل المعالجة</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No refund requests recorded.' : 'لا توجد طلبات استرجاع مسجلة.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pt-4">
                {{ $refunds->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>
