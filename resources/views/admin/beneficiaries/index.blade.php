@php
    $isEn = app()->getLocale() == 'en';
@endphp

<x-admin-layout title="{{ $isEn ? 'Beneficiaries Directory' : 'سجل مستفيدي الشركات' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Corporate Beneficiaries Management' : 'إدارة وسجل المستفيدين والمنسوبين للجهات المتعاقدة' }}</x-slot>

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

        {{-- Top Summary Card --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-black text-primary flex items-center gap-2">
                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>{{ $isEn ? 'Beneficiaries Directory' : 'سجل المستفيدين والمنسوبين المعتمدين' }}</span>
                </h2>
                <p class="text-xs text-gray-500 mt-1">{{ $isEn ? 'Search, filter, and enroll corporate beneficiaries and automatically link with patient profiles.' : 'استعراض وإضافة وتصفية منسوبي ومستفيدي العقود الطبية والربط التلقائي بملفات المرضى.' }}</p>
            </div>
            <div>
                <a href="{{ route('admin.beneficiaries.create') }}" class="px-5 py-3 bg-[#006C35] text-white font-extrabold text-xs rounded-2xl shadow-lg hover:bg-[#00572B] transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    <span>{{ $isEn ? 'Add New Beneficiary' : 'إضافة مستفيد جديد' }}</span>
                </a>
            </div>
        </div>

        {{-- Search & Filters --}}
        <div class="bg-white p-5 rounded-3xl border border-gray-200 shadow-sm">
            <form action="{{ route('admin.beneficiaries.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4">
                <div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $isEn ? 'Search name, ID, phone...' : 'بحث بالاسم، الهوية، الجوال...' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold text-gray-800 focus:outline-none focus:border-primary">
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
                    <select name="contract_id" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold text-gray-800 focus:outline-none focus:border-primary">
                        <option value="">{{ $isEn ? 'All Contracts' : 'جميع العقود' }}</option>
                        @foreach($contracts as $cnt)
                            <option value="{{ $cnt->id }}" {{ request('contract_id') == $cnt->id ? 'selected' : '' }}>{{ $cnt->contract_number }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="identification_type" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold text-gray-800 focus:outline-none focus:border-primary">
                        <option value="">{{ $isEn ? 'All ID Types' : 'جميع أنواع الهوية' }}</option>
                        <option value="saudi_id" {{ request('identification_type') == 'saudi_id' ? 'selected' : '' }}>هوية وطنية (Saudi ID)</option>
                        <option value="iqama" {{ request('identification_type') == 'iqama' ? 'selected' : '' }}>إقامة (Iqama)</option>
                        <option value="border_number" {{ request('identification_type') == 'border_number' ? 'selected' : '' }}>رقم الحدود (Border #)</option>
                        <option value="gcc_id" {{ request('identification_type') == 'gcc_id' ? 'selected' : '' }}>هوية خليجية (GCC ID)</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white font-extrabold text-xs py-3 rounded-xl shadow transition-all">
                        {{ $isEn ? 'Apply Filter' : 'تصفية النتائج' }}
                    </button>
                </div>
            </form>
        </div>

        {{-- Beneficiaries Table --}}
        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden p-6 space-y-4">
            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 font-extrabold border-b border-gray-200">
                            <th class="p-3.5">{{ $isEn ? 'Beneficiary Name' : 'اسم المستفيد' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Identification' : 'نوع ورقم الهوية' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Company & Contract' : 'الشركة والعقد' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Employee ID / Phone' : 'الرقم الوظيفي / الجوال' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Linked Patient Profile' : 'الحساب المسجل' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Status' : 'الحالة' }}</th>
                            <th class="p-3.5 text-center">{{ $isEn ? 'Actions' : 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($beneficiaries as $ben)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-3.5 font-bold text-gray-800">{{ $ben->name }}</td>
                                <td class="p-3.5 font-bold text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                                    <span class="text-primary font-black uppercase text-[11px] block">{{ $ben->identification_type }}</span>
                                    <span>{{ $ben->identification_number }}</span>
                                </td>
                                <td class="p-3.5">
                                    <strong class="text-gray-800 font-bold block">{{ $ben->company->name ?? '-' }}</strong>
                                    <span class="text-gray-400 font-bold text-[11px] dir-ltr block">{{ $ben->contract->contract_number ?? 'N/A' }}</span>
                                </td>
                                <td class="p-3.5 font-bold text-gray-600">
                                    <span>{{ $ben->employee_id_number ?? '-' }}</span>
                                    <span class="text-gray-400 block text-[11px] dir-ltr">{{ $ben->phone ?? '' }}</span>
                                </td>
                                <td class="p-3.5">
                                    @if($ben->patient)
                                        <span class="text-emerald-700 font-black flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            <span>{{ $ben->patient->name }}</span>
                                        </span>
                                    @else
                                        <span class="text-gray-400 font-bold">{{ $isEn ? 'Standalone' : 'غير مرتبط بحساب' }}</span>
                                    @endif
                                </td>
                                <td class="p-3.5 whitespace-nowrap">
                                    @if($ben->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 font-extrabold text-[11px] rounded-full border border-emerald-200 shadow-sm whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                            <span>{{ $isEn ? 'Active' : 'نشط' }}</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-700 font-extrabold text-[11px] rounded-full border border-rose-200 shadow-sm whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 shrink-0"></span>
                                            <span>{{ $isEn ? 'Inactive' : 'معطل' }}</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="p-3.5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.beneficiaries.edit', $ben->id) }}" class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-xl text-[11px]">
                                            {{ $isEn ? 'Edit' : 'تعديل' }}
                                        </a>
                                        <form action="{{ route('admin.beneficiaries.toggle', $ben->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 {{ $ben->status === 'active' ? 'bg-rose-50 hover:bg-rose-100 text-rose-700' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-700' }} font-bold rounded-xl text-[11px]">
                                                {{ $ben->status === 'active' ? ($isEn ? 'Deactivate' : 'تعطيل') : ($isEn ? 'Activate' : 'تنشيط') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No corporate beneficiaries found matching criteria.' : 'لا يوجد مستفيدين يطابقون معايير البحث.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pt-4">
                {{ $beneficiaries->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>
