@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Corporate & Companies Directory' : 'إدارة ومجتمعات الشركات المتعاقدة' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Corporate Clients & Contracted Entities Management' : 'إدارة حسابات الشركات والقطاعات المتعاقدة' }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        {{-- Flash Messages --}}
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

        {{-- Header & Action Bar --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="font-black text-lg text-primary flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>{{ $isEn ? 'Contracted Companies Register' : 'سجل حسابات الشركات والقطاعات' }} ({{ $companies->total() }})</span>
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">{{ $isEn ? 'View, create, and manage corporate clients, active contracts, and users' : 'استعراض، إضافة، وإدارة حسابات الشركات والعقود السارية والمستفيدين' }}</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.contract-requests.index') }}" class="px-4 py-2.5 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 rounded-xl font-bold text-xs transition-all flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>{{ $isEn ? 'Contract Requests' : 'طلبات التعاقد الواردة' }}</span>
                </a>
                <a href="{{ route('admin.companies.create') }}" class="px-5 py-2.5 bg-[#006C35] hover:bg-[#00572B] text-white rounded-xl font-black text-xs shadow-md transition-all flex items-center gap-2 border-0 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    <span>{{ $isEn ? 'Add New Company' : 'تسجيل شركة جديدة' }}</span>
                </a>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="bg-white p-4 sm:p-5 rounded-3xl border border-gray-200 shadow-sm">
            <form action="{{ route('admin.companies.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $isEn ? 'Company Name, CR #, Code, Phone...' : 'اسم الشركة، السجل، الكود، الجوال...' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                </div>

                <div>
                    <select name="status" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                        <option value="">{{ $isEn ? 'All Statuses' : 'جميع الحالات' }}</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ $isEn ? 'Active' : 'نشط وساري' }}</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>{{ $isEn ? 'Inactive' : 'معطل' }}</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>{{ $isEn ? 'Suspended' : 'موقوف موقتاً' }}</option>
                    </select>
                </div>

                <div>
                    <input type="text" name="city" value="{{ request('city') }}" placeholder="{{ $isEn ? 'Filter by City...' : 'تصفية حسب المدينة...' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="w-full bg-primary text-white py-2.5 rounded-xl font-black text-xs shadow hover:bg-primary-hover transition-colors">
                        {{ $isEn ? 'Filter' : 'تصفية' }}
                    </button>
                    @if(request()->anyFilled(['q', 'status', 'city']))
                        <a href="{{ route('admin.companies.index') }}" class="px-3 py-2.5 bg-gray-100 text-gray-600 rounded-xl font-bold text-xs hover:bg-gray-200">✕</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Companies Table --}}
        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden p-6 space-y-4">
            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 font-extrabold border-b border-gray-200">
                            <th class="p-3.5">{{ $isEn ? 'Company Code & Name' : 'كود واسم الشركة' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'CR Number' : 'السجل التجاري' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Contact Person & Phone' : 'مسؤول التواصل والجوال' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'City' : 'المدينة' }}</th>
                            <th class="p-3.5 text-center">{{ $isEn ? 'Users' : 'المستخدمين' }}</th>
                            <th class="p-3.5 text-center">{{ $isEn ? 'Contracts' : 'العقود' }}</th>
                            <th class="p-3.5 text-center">{{ $isEn ? 'Visits' : 'الزيارات' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Status' : 'الحالة' }}</th>
                            <th class="p-3.5 text-center">{{ $isEn ? 'Actions' : 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($companies as $company)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary font-black flex items-center justify-center text-sm shrink-0">
                                            {{ mb_substr($company->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.companies.show', $company->id) }}" class="font-black text-primary hover:underline text-sm block">{{ $company->name }}</a>
                                            <span class="text-[10px] text-gray-400 font-bold block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $company->company_code ?? 'COMP-N/A' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-3.5 font-bold text-gray-800 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $company->cr_number ?? '-' }}</td>
                                <td class="p-3.5">
                                    <strong class="text-gray-800 font-bold block">{{ $company->contact_person ?? '-' }}</strong>
                                    <span class="text-[10px] text-gray-400 block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $company->phone ?? ($company->email ?? '-') }}</span>
                                </td>
                                <td class="p-3.5 font-bold text-gray-600">{{ $company->city ?? '-' }}</td>
                                <td class="p-3.5 text-center font-bold text-gray-800">{{ $company->users_count }}</td>
                                <td class="p-3.5 text-center font-bold text-accent">{{ $company->contracts_count }}</td>
                                <td class="p-3.5 text-center font-bold text-primary">{{ $company->bookings_count }}</td>
                                <td class="p-3.5 whitespace-nowrap">
                                    @if($company->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 font-extrabold text-[11px] rounded-full border border-emerald-200 shadow-sm whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                            <span>{{ $isEn ? 'Active' : 'نشط' }}</span>
                                        </span>
                                    @elseif($company->status === 'suspended')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-700 font-extrabold text-[11px] rounded-full border border-amber-200 shadow-sm whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shrink-0"></span>
                                            <span>{{ $isEn ? 'Suspended' : 'موقوف مؤقتاً' }}</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-700 font-extrabold text-[11px] rounded-full border border-rose-200 shadow-sm whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 shrink-0"></span>
                                            <span>{{ $isEn ? 'Inactive' : 'معطل' }}</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3.5 text-center space-x-1">
                                    <a href="{{ route('admin.companies.show', $company->id) }}" class="px-3 py-1.5 bg-[#006C35] text-white font-bold rounded-xl text-[11px] shadow hover:bg-[#00572B] transition-all inline-block">
                                        {{ $isEn ? 'Manage' : 'إدارة الحساب' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No corporate accounts found matching criteria.' : 'لا توجد حسابات شركات تطابق معايير البحث.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pt-2">
                {{ $companies->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>
