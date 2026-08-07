@php
    $isEn = app()->getLocale() == 'en';
@endphp

<x-admin-layout title="{{ $isEn ? 'Contracts Management' : 'إدارة عقود الشركات' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Corporate Contracts Directory' : 'سجل عقود الشركات والجهات المتعاقدة' }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        {{-- Flash messages --}}
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-2xl flex items-center justify-between">
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold rounded-2xl flex items-center justify-between">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Top Bar & Header --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-black text-primary flex items-center gap-2">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>{{ $isEn ? 'Corporate Contracts Register' : 'سجل العقود والاتفاقيات الطبية' }}</span>
                </h2>
                <p class="text-xs text-gray-500 mt-1">{{ $isEn ? 'Manage active, draft, and expired contracts, special service pricing, and company terms.' : 'استعراض وإدارة العقود السارية والموقوفة، وتحديد أسعار الخدمات التعاقدية المخصصة.' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.contracts.create') }}" class="px-5 py-3 bg-[#006C35] text-white font-extrabold text-xs rounded-2xl shadow-lg hover:bg-[#00572B] transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    <span>{{ $isEn ? 'Create New Contract' : 'إنشاء عقد جديد' }}</span>
                </a>
            </div>
        </div>

        {{-- Search & Filters --}}
        <div class="bg-white p-5 rounded-3xl border border-gray-200 shadow-sm">
            <form action="{{ route('admin.contracts.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $isEn ? 'Search contract #, company...' : 'بحث برقم العقد، اسم الشركة...' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold text-gray-800 focus:outline-none focus:border-primary">
                </div>
                <div>
                    <select name="company_id" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold text-gray-800 focus:outline-none focus:border-primary">
                        <option value="">{{ $isEn ? 'All Companies' : 'جميع الشركات' }}</option>
                        @foreach($companies as $comp)
                            <option value="{{ $comp->id }}" {{ request('company_id') == $comp->id ? 'selected' : '' }}>{{ $comp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="status" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold text-gray-800 focus:outline-none focus:border-primary">
                        <option value="">{{ $isEn ? 'All Statuses' : 'جميع الحالات' }}</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ $isEn ? 'Active' : 'نشط' }}</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ $isEn ? 'Pending Review' : 'قيد التدقيق' }}</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>{{ $isEn ? 'Draft' : 'مسودة' }}</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>{{ $isEn ? 'Expired' : 'منتهي' }}</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>{{ $isEn ? 'Suspended' : 'موقوف' }}</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white font-extrabold text-xs py-3 rounded-xl shadow transition-all">
                        {{ $isEn ? 'Apply Filter' : 'تصفية النتائج' }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Contracts Table --}}
        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden p-6 space-y-4">
            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 font-extrabold border-b border-gray-200">
                            <th class="p-3.5">{{ $isEn ? 'Contract Number' : 'رقم العقد' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Company' : 'الشركة المتعاقدة' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Validity Period' : 'فترة الصلاحية' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Payment Terms' : 'شروط الدفع' }}</th>
                            <th class="p-3.5 text-center">{{ $isEn ? 'Covered Services' : 'الخدمات المشمولة' }}</th>
                            <th class="p-3.5 text-center">{{ $isEn ? 'Beneficiaries' : 'المستفيدين' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Status' : 'الحالة' }}</th>
                            <th class="p-3.5 text-center">{{ $isEn ? 'Actions' : 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($contracts as $contract)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-3.5 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                                    {{ $contract->contract_number }}
                                </td>
                                <td class="p-3.5">
                                    <div class="font-bold text-gray-800">{{ $contract->company->name ?? '-' }}</div>
                                    <span class="text-[11px] text-gray-400 font-bold block">CR: {{ $contract->company->cr_number ?? 'N/A' }}</span>
                                </td>
                                <td class="p-3.5 font-bold text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                                    {{ $contract->start_date }} → {{ $contract->end_date }}
                                </td>
                                <td class="p-3.5 font-bold text-gray-700">{{ $contract->payment_terms }}</td>
                                <td class="p-3.5 text-center font-bold text-accent">{{ $contract->contractPrices->count() }} {{ $isEn ? 'services' : 'خدمة' }}</td>
                                <td class="p-3.5 text-center font-bold text-primary">{{ $contract->beneficiaries->count() }} {{ $isEn ? 'beneficiaries' : 'مستفيد' }}</td>
                                <td class="p-3.5 whitespace-nowrap">
                                    @if($contract->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 font-extrabold text-[11px] rounded-full border border-emerald-200 shadow-sm whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                            <span>{{ $isEn ? 'Active' : 'نشط' }}</span>
                                        </span>
                                    @elseif($contract->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 font-extrabold text-[11px] rounded-full border border-amber-200 shadow-sm whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0"></span>
                                            <span>{{ $isEn ? 'Pending Review' : 'قيد التدقيق' }}</span>
                                        </span>
                                    @elseif($contract->status === 'draft')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-100 text-gray-700 font-extrabold text-[11px] rounded-full border border-gray-300 shadow-sm whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-500 shrink-0"></span>
                                            <span>{{ $isEn ? 'Draft' : 'مسودة' }}</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-700 font-extrabold text-[11px] rounded-full border border-rose-200 shadow-sm whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 shrink-0"></span>
                                            <span>{{ $contract->status }}</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3.5 text-center">
                                    <a href="{{ route('admin.contracts.show', $contract->id) }}" class="px-3 py-1.5 bg-[#006C35] text-white font-bold rounded-xl text-[11px] shadow hover:bg-[#00572B] transition-all inline-block">
                                        {{ $isEn ? 'View Details & Pricing' : 'تفاصيل العقد والأسعار' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No corporate contracts found matching criteria.' : 'لا توجد عقود شركات تطابق معايير البحث.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pt-4">
                {{ $contracts->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>
