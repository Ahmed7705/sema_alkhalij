@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Company Details — ' . $company->name : 'تفاصيل شركة — ' . $company->name }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Corporate Client Account Management: ' . $company->name : 'ملف وإدارة حساب الشركة المتعاقدة: ' . $company->name }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}" x-data="{ activeTab: 'overview' }">
        
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

        {{-- Top Summary Header Card --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-3xl bg-primary/10 text-primary font-black flex items-center justify-center text-2xl shrink-0">
                    {{ mb_substr($company->name, 0, 1) }}
                </div>
                <div class="space-y-1">
                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl font-black text-primary">{{ $company->name }}</h2>
                        @if($company->status === 'active')
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-emerald-50 text-emerald-700 font-extrabold text-xs rounded-full border border-emerald-200 shadow-sm whitespace-nowrap">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                <span>{{ $isEn ? 'Active' : 'نشط' }}</span>
                            </span>
                        @elseif($company->status === 'suspended')
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-amber-50 text-amber-700 font-extrabold text-xs rounded-full border border-amber-200 shadow-sm whitespace-nowrap">
                                <span class="w-2 h-2 rounded-full bg-amber-500 shrink-0"></span>
                                <span>{{ $isEn ? 'Suspended' : 'موقوف مؤقتاً' }}</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-rose-50 text-rose-700 font-extrabold text-xs rounded-full border border-rose-200 shadow-sm whitespace-nowrap">
                                <span class="w-2 h-2 rounded-full bg-rose-500 shrink-0"></span>
                                <span>{{ $isEn ? 'Inactive' : 'معطل' }}</span>
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500">
                        {{ $isEn ? 'Code:' : 'الكود:' }} <strong class="text-gray-800 dir-ltr">{{ $company->company_code ?? 'COMP-N/A' }}</strong> | 
                        {{ $isEn ? 'CR #:' : 'السجل:' }} <strong class="text-gray-800 dir-ltr">{{ $company->cr_number ?? '-' }}</strong> | 
                        {{ $isEn ? 'City:' : 'المدينة:' }} <strong class="text-gray-800">{{ $company->city ?? '-' }}</strong>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <form action="{{ route('admin.companies.toggle', $company->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2.5 rounded-xl font-bold text-xs shadow-sm transition-all cursor-pointer border {{ $company->status === 'active' ? 'bg-rose-50 text-rose-700 border-rose-200 hover:bg-rose-100' : 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' }}">
                        {{ $company->status === 'active' ? ($isEn ? 'Deactivate Company' : 'تعطيل حساب الشركة') : ($isEn ? 'Activate Company' : 'تفعيل حساب الشركة') }}
                    </button>
                </form>

                <a href="{{ route('admin.companies.edit', $company->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow transition-all">
                    {{ $isEn ? 'Edit Info' : 'تعديل البيانات' }}
                </a>
                
                <a href="{{ route('admin.companies.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-xl font-bold text-xs transition-all">
                    {{ $isEn ? 'Back' : 'رجوع' }}
                </a>
            </div>
        </div>

        {{-- Tab Navigation Bar --}}
        <div class="bg-white p-2 rounded-2xl border border-gray-200 shadow-sm flex items-center gap-2 overflow-x-auto">
            <button @click="activeTab = 'overview'" :class="activeTab === 'overview' ? 'bg-primary text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'" class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer border-0">
                {{ $isEn ? 'Overview' : 'نظرة عامة' }}
            </button>
            <button @click="activeTab = 'users'" :class="activeTab === 'users' ? 'bg-primary text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'" class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer border-0 flex items-center gap-1.5">
                <span>{{ $isEn ? 'Company Users' : 'مستخدمي الشركة' }}</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] bg-white/20 text-current font-bold">{{ $users->total() }}</span>
            </button>
            <button @click="activeTab = 'contracts'" :class="activeTab === 'contracts' ? 'bg-primary text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'" class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer border-0 flex items-center gap-1.5">
                <span>{{ $isEn ? 'Contracts' : 'العقود' }}</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] bg-white/20 text-current font-bold">{{ $contracts->total() }}</span>
            </button>
            <button @click="activeTab = 'visits'" :class="activeTab === 'visits' ? 'bg-primary text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'" class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer border-0 flex items-center gap-1.5">
                <span>{{ $isEn ? 'Service Visits' : 'طلبات الزيارات' }}</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] bg-white/20 text-current font-bold">{{ $bookings->total() }}</span>
            </button>
            <button @click="activeTab = 'history'" :class="activeTab === 'history' ? 'bg-primary text-white shadow-md' : 'text-gray-600 hover:bg-gray-100'" class="px-5 py-2.5 rounded-xl text-xs font-black transition-all cursor-pointer border-0">
                {{ $isEn ? 'Audit History' : 'سجل العمليات Audit' }}
            </button>
        </div>

        {{-- TAB 1: OVERVIEW --}}
        <div x-show="activeTab === 'overview'" class="space-y-6">
            {{-- Metrics Cards Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-3xl border border-gray-200 shadow-sm space-y-1">
                    <span class="text-xs font-bold text-gray-500 block">{{ $isEn ? 'Active Contracts' : 'العقود النشطة والسارية' }}</span>
                    <strong class="text-2xl font-black text-accent block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $activeContractsCount }}</strong>
                </div>

                <div class="bg-white p-5 rounded-3xl border border-gray-200 shadow-sm space-y-1">
                    <span class="text-xs font-bold text-gray-500 block">{{ $isEn ? 'Beneficiaries Count' : 'عدد المستفيدين المغطين' }}</span>
                    <strong class="text-2xl font-black text-primary block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $beneficiariesCount }}</strong>
                </div>

                <div class="bg-white p-5 rounded-3xl border border-gray-200 shadow-sm space-y-1">
                    <span class="text-xs font-bold text-gray-500 block">{{ $isEn ? 'Total Service Requests' : 'إجمالي طلبات الخدمة' }}</span>
                    <strong class="text-2xl font-black text-gray-800 block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $totalVisitsCount }}</strong>
                </div>

                <div class="bg-white p-5 rounded-3xl border border-gray-200 shadow-sm space-y-1">
                    <span class="text-xs font-bold text-gray-500 block">{{ $isEn ? 'Completed Medical Visits' : 'الزيارات الطبية المكتملة' }}</span>
                    <strong class="text-2xl font-black text-emerald-600 block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $completedVisitsCount }}</strong>
                </div>
            </div>

            {{-- Company Information Details Card --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-4">
                <h3 class="font-black text-base text-primary border-b border-gray-100 pb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>{{ $isEn ? 'Company Account Metadata' : 'معلومات الحساب والسجل التجاري' }}</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 text-xs">
                    <div class="space-y-1">
                        <span class="text-gray-400 font-bold block">{{ $isEn ? 'Contact Person' : 'مسؤول التواصل' }}</span>
                        <strong class="text-gray-800 font-black text-sm block">{{ $company->contact_person ?? '-' }}</strong>
                    </div>

                    <div class="space-y-1">
                        <span class="text-gray-400 font-bold block">{{ $isEn ? 'Phone Number' : 'رقم الجوال' }}</span>
                        <strong class="text-gray-800 font-bold block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $company->phone ?? '-' }}</strong>
                    </div>

                    <div class="space-y-1">
                        <span class="text-gray-400 font-bold block">{{ $isEn ? 'Official Email' : 'البريد الإلكتروني' }}</span>
                        <strong class="text-gray-800 font-bold block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $company->email ?? '-' }}</strong>
                    </div>

                    <div class="space-y-1">
                        <span class="text-gray-400 font-bold block">{{ $isEn ? 'Commercial Registration' : 'السجل التجاري (CR)' }}</span>
                        <strong class="text-gray-800 font-bold block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $company->cr_number ?? '-' }}</strong>
                    </div>

                    <div class="space-y-1">
                        <span class="text-gray-400 font-bold block">{{ $isEn ? 'Registration Date' : 'تاريخ التسجيل' }}</span>
                        <strong class="text-gray-800 font-bold block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $company->created_at->format('Y-m-d') }}</strong>
                    </div>

                    <div class="space-y-1">
                        <span class="text-gray-400 font-bold block">{{ $isEn ? 'Contract Request Reference' : 'طلب التعاقد الأصلي' }}</span>
                        @if($company->contractRequest)
                            <a href="{{ route('admin.contract-requests.show', $company->contractRequest->id) }}" class="text-accent font-bold hover:underline">#REQ-{{ $company->contractRequest->id }}</a>
                        @else
                            <span class="text-gray-500 font-bold">{{ $isEn ? 'Direct Registration' : 'تسجيل مباشر' }}</span>
                        @endif
                    </div>

                    <div class="sm:col-span-2 space-y-1">
                        <span class="text-gray-400 font-bold block">{{ $isEn ? 'Address & Headquarter Details' : 'العنوان الميداني والمقر الرئيسي' }}</span>
                        <strong class="text-gray-800 font-bold block">{{ $company->address ?? '-' }}</strong>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB 2: COMPANY USERS MANAGEMENT --}}
        <div x-show="activeTab === 'users'" class="space-y-6">
            {{-- Add Company User Form Card --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-4">
                <h3 class="font-black text-base text-primary border-b border-gray-100 pb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    <span>{{ $isEn ? 'Register & Link New User for Company' : 'إضافة وتسجيل مستخدم جديد لحساب الشركة' }}</span>
                </h3>

                <form action="{{ route('admin.companies.users.add', $company->id) }}" method="POST" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'User Name *' : 'اسم المستخدم *' }}</label>
                        <input type="text" name="name" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Email Address *' : 'البريد الإلكتروني *' }}</label>
                        <input type="email" name="email" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Phone Number *' : 'رقم الجوال *' }}</label>
                        <input type="text" name="phone" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Password *' : 'كلمة المرور *' }}</label>
                        <input type="password" name="password" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary dir-ltr">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Corporate Role *' : 'الدور والصلاحية بالشركة *' }}</label>
                        <select name="role" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                            <option value="company_admin">{{ $isEn ? 'Company Admin (Full Access)' : 'مدير الشركة (صلاحية كاملة)' }}</option>
                            <option value="company_operator">{{ $isEn ? 'Company Operator (Requests Only)' : 'مشغل شركة (طلب خدمات فقط)' }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Account Status *' : 'حالة الحساب *' }}</label>
                        <select name="is_active" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                            <option value="1">{{ $isEn ? 'Active' : 'نشط ومفعل' }}</option>
                            <option value="0">{{ $isEn ? 'Inactive' : 'معطل' }}</option>
                        </select>
                    </div>

                    <div class="sm:col-span-3 flex justify-end">
                        <button type="submit" class="bg-[#006C35] hover:bg-[#00572B] text-white px-6 py-2.5 rounded-xl font-black text-xs shadow transition-all border-0 cursor-pointer">
                            {{ $isEn ? 'Add Company User' : 'حفظ وتثبيت مستخدم الشركة' }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- Users Table --}}
            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6 space-y-4">
                <h4 class="font-black text-base text-primary border-b border-gray-100 pb-3">{{ $isEn ? 'Active Company Users List' : 'قائمة مستخدمي الشركة المسجلين بالنظام' }}</h4>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }}">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-gray-700 font-extrabold">
                                <th class="p-3">{{ $isEn ? 'User Name' : 'اسم المستخدم' }}</th>
                                <th class="p-3">{{ $isEn ? 'Email & Phone' : 'البريد والجوال' }}</th>
                                <th class="p-3">{{ $isEn ? 'Role' : 'الصلاحية' }}</th>
                                <th class="p-3">{{ $isEn ? 'Status' : 'الحالة' }}</th>
                                <th class="p-3 text-center">{{ $isEn ? 'Actions' : 'الإجراءات' }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-3 font-bold text-gray-800">{{ $user->name }}</td>
                                    <td class="p-3">
                                        <span class="block text-gray-800 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $user->email }}</span>
                                        <span class="block text-gray-400 text-[10px] dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $user->phone }}</span>
                                    </td>
                                    <td class="p-3">
                                        <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold bg-primary/10 text-primary">{{ $user->role }}</span>
                                    </td>
                                    <td class="p-3">
                                        @if($user->is_active)
                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 font-bold text-[10px] rounded-full border border-emerald-200">{{ $isEn ? 'Active' : 'نشط' }}</span>
                                        @else
                                            <span class="px-2 py-0.5 bg-rose-50 text-rose-700 font-bold text-[10px] rounded-full border border-rose-200">{{ $isEn ? 'Inactive' : 'معطل' }}</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center flex items-center justify-center gap-2">
                                        <form action="{{ route('admin.companies.users.toggle', [$company->id, $user->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1 text-[11px] font-bold rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition-colors">
                                                {{ $user->is_active ? ($isEn ? 'Deactivate' : 'تعطيل') : ($isEn ? 'Activate' : 'تفعيل') }}
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.companies.users.detach', [$company->id, $user->id]) }}" method="POST" onsubmit="return confirm('{{ $isEn ? 'Detach user from company?' : 'هل أنت تأكد من إزالة إرتباط المستخدم بهذه الشركة؟' }}')">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1 text-[11px] font-bold rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 transition-colors border-0 cursor-pointer">
                                                {{ $isEn ? 'Detach' : 'إزالة الارتباط' }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-gray-400 font-bold">{{ $isEn ? 'No users currently assigned to this corporate account.' : 'لا يوجد مستخدمون مرتبكون بهذه الشركة حالياً.' }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pt-2">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        {{-- TAB 3: CONTRACTS --}}
        <div x-show="activeTab === 'contracts'" class="space-y-6">
            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6 space-y-4">
                <h4 class="font-black text-base text-primary border-b border-gray-100 pb-3">{{ $isEn ? 'Corporate Contracts Register' : 'سجل العقود المبرمة للشركة' }}</h4>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }}">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-gray-700 font-extrabold">
                                <th class="p-3">{{ $isEn ? 'Contract #' : 'رقم العقد' }}</th>
                                <th class="p-3">{{ $isEn ? 'Start Date' : 'تاريخ البداية' }}</th>
                                <th class="p-3">{{ $isEn ? 'End Date' : 'تاريخ النهاية' }}</th>
                                <th class="p-3">{{ $isEn ? 'Payment Terms' : 'شروط الدفع' }}</th>
                                <th class="p-3">{{ $isEn ? 'Status' : 'حالة العقد' }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($contracts as $contract)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-3 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $contract->contract_number }}</td>
                                    <td class="p-3 font-bold text-gray-800 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $contract->start_date }}</td>
                                    <td class="p-3 font-bold text-gray-800 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $contract->end_date }}</td>
                                    <td class="p-3 font-bold text-gray-600">{{ $contract->payment_terms }}</td>
                                    <td class="p-3">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black {{ $contract->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-700' }}">
                                            {{ $contract->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-gray-400 font-bold">{{ $isEn ? 'No active or historical contracts recorded for this company.' : 'لا توجد عقود مسجلة لهذه الشركة حتى الآن.' }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pt-2">
                    {{ $contracts->links() }}
                </div>
            </div>
        </div>

        {{-- TAB 4: VISITS --}}
        <div x-show="activeTab === 'visits'" class="space-y-6">
            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6 space-y-4">
                <h4 class="font-black text-base text-primary border-b border-gray-100 pb-3">{{ $isEn ? 'Corporate Beneficiaries Service Visits' : 'زيارات وطلبات الخدمات الطبية للمستفيدين' }}</h4>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }}">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200 text-gray-700 font-extrabold">
                                <th class="p-3">{{ $isEn ? 'Booking #' : 'رقم الحجز' }}</th>
                                <th class="p-3">{{ $isEn ? 'Patient Beneficiary' : 'المستفيد' }}</th>
                                <th class="p-3">{{ $isEn ? 'Service' : 'الخدمة' }}</th>
                                <th class="p-3">{{ $isEn ? 'Practitioner' : 'الممارس المسند' }}</th>
                                <th class="p-3">{{ $isEn ? 'Date' : 'تاريخ الزيارة' }}</th>
                                <th class="p-3">{{ $isEn ? 'Status' : 'الحالة' }}</th>
                                <th class="p-3 text-center">{{ $isEn ? 'Details' : 'التفاصيل' }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($bookings as $booking)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-3 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">#{{ $booking->booking_number }}</td>
                                    <td class="p-3 font-bold text-gray-800">{{ $booking->patient_name }}</td>
                                    <td class="p-3 font-bold text-accent">{{ $booking->service->title ?? '-' }}</td>
                                    <td class="p-3 font-bold text-gray-600">{{ $booking->assignedProvider->name ?? 'Unassigned' }}</td>
                                    <td class="p-3 text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $booking->booking_date }} | {{ $booking->booking_time }}</td>
                                    <td class="p-3">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-primary/10 text-primary">{{ $booking->status }}</span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-accent font-bold hover:underline">{{ $isEn ? 'View' : 'معاينة' }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-6 text-center text-gray-400 font-bold">{{ $isEn ? 'No service requests recorded for this company.' : 'لا توجد طلبات خدمات منزلية مسجلة لهذه الشركة حتى الآن.' }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pt-2">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>

        {{-- TAB 5: HISTORY --}}
        <div x-show="activeTab === 'history'" class="space-y-6">
            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6 space-y-6">
                <h4 class="font-black text-base text-primary border-b border-gray-100 pb-3">{{ $isEn ? 'Audit Activity Logs' : 'سجل تتبع ومراقبة العمليات المنجزة Real Audit Trail' }}</h4>

                <div class="relative border-r-2 border-primary/20 {{ $isEn ? 'border-r-0 border-l-2 ml-3' : 'mr-3' }} space-y-6 pr-6 {{ $isEn ? 'pl-6 pr-0' : '' }}">
                    @forelse($auditLogs as $log)
                        <div class="relative">
                            <span class="absolute -right-8 {{ $isEn ? '-left-8 right-auto' : '' }} top-0 w-4 h-4 rounded-full bg-accent ring-4 ring-accent/20"></span>
                            <div class="text-xs space-y-0.5">
                                <strong class="text-gray-800 font-bold block">{{ $log->action }}</strong>
                                <p class="text-gray-600">{{ $log->old_values ?? $log->new_values }}</p>
                                <span class="text-gray-400 block text-[10px] dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $log->created_at->format('Y-m-d H:i:s') }} • {{ $log->user->name ?? 'System' }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-400 text-xs font-bold text-center py-4">{{ $isEn ? 'No activity logs found.' : 'لا توجد سجلات تتبع لهذه الشركة.' }}</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
