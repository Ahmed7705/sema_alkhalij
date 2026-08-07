@php
    $isEn = app()->getLocale() == 'en';
    $isAdmin = in_array(Auth::user()->role, ['admin', 'super_admin', 'manager']);
    $layoutName = $isAdmin ? 'admin-layout' : 'app-layout';
@endphp

<x-dynamic-component :component="$layoutName" title="{{ $isEn ? 'Corporate Portal & Contracts View' : 'بوابة الشركات والتعاقدات' }}">
    @if($isAdmin)
        <x-slot name="headerTitle">{{ $isEn ? 'Corporate Portal & Beneficiaries Operations' : 'بوابة الشركات والجهات المتعاقدة والمستفيدين' }}</x-slot>
    @endif

    <div class="space-y-8 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}" x-data="{ openRequestModal: false, openBeneficiaryModal: false, activeTab: '{{ $activeTab ?? 'requests' }}' }">
        
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

        {{-- Company Selector for Admin users --}}
        @if($isAdmin && isset($allCompanies) && count($allCompanies) > 1)
            <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-sm flex items-center justify-between gap-4">
                <span class="text-xs font-bold text-gray-700">{{ $isEn ? 'Switch Corporate Entity View (Admin Control Mode):' : 'عرض بوابة شركة متعاقدة أخرى (تحكم الأدمن):' }}</span>
                <form action="{{ route('company.portal') }}" method="GET" class="flex items-center gap-2">
                    <select name="company_id" onchange="this.form.submit()" class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-1.5 text-xs font-bold text-gray-800 focus:outline-none focus:border-primary">
                        @foreach($allCompanies as $compOption)
                            <option value="{{ $compOption->id }}" {{ $compOption->id == $company->id ? 'selected' : '' }}>
                                {{ $compOption->name }} ({{ $compOption->company_code ?? 'CODE' }})
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        @endif

        {{-- Company Header Banner --}}
        <div style="background: linear-gradient(135deg, #004823 0%, #006C35 50%, #00381B 100%) !important;" class="p-8 rounded-3xl text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 border border-white/10">
            <div class="space-y-1">
                <span class="text-xs text-accent font-black tracking-wide">{{ $isEn ? 'Contracted Corporate Portal' : 'بوابة الشركات المتعاقدة — Corporate Portal' }}</span>
                <h2 class="text-3xl font-black text-white">{{ str_replace(' (حساب تجريبي)', '', $company->name) }}</h2>
                <p class="text-xs text-medical-200">
                    {{ $isEn ? 'CR Number:' : 'رقم السجل التجاري:' }} {{ $company->cr_number ?? ($isEn ? 'Unregistered' : 'غير مسجل') }} | 
                    {{ $isEn ? 'City:' : 'المدينة:' }} {{ $company->city }} |
                    {{ $isEn ? 'Contact Person:' : 'مسؤول التواصل:' }} {{ $company->contact_person ?? ($isEn ? 'Corporate Admin' : 'مدير التعاقدات') }}
                </p>
            </div>
            <div class="flex items-center gap-3">
                <button @click="openBeneficiaryModal = true" class="bg-white/10 hover:bg-white/20 text-white font-bold text-xs px-4 py-3.5 rounded-2xl border border-white/20 transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    <span>{{ $isEn ? '+ Add Beneficiary' : '+ إضافة مستفيد' }}</span>
                </button>
                @if($activeContract)
                    <button @click="openRequestModal = true" class="bg-accent hover:bg-accent-hover text-white font-black text-xs px-6 py-3.5 rounded-2xl shadow-lg transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span>{{ $isEn ? 'Submit New Service Request' : 'تقديم طلب خدمة جديد لمستفيد' }}</span>
                    </button>
                @else
                    <div class="bg-white/10 text-white/60 font-bold text-xs px-6 py-3.5 rounded-2xl border border-white/20 flex items-center gap-2 cursor-not-allowed" title="{{ $isEn ? 'No active contract — contact admin' : 'لا يوجد عقد نشط — تواصل مع الإدارة' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/></svg>
                        <span>{{ $isEn ? 'No Active Contract' : 'لا يوجد عقد نشط' }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- No Active Contract Warning Banner --}}
        @if(!$activeContract)
            <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start gap-3" dir="{{ $isEn ? 'ltr' : 'rtl' }}">
                <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                </svg>
                <div class="space-y-1">
                    <p class="text-sm font-black text-amber-800">
                        {{ $isEn ? 'No Active Contract Found' : 'لا يوجد عقد نشط لهذه الشركة' }}
                    </p>
                    <p class="text-xs text-amber-700 font-medium">
                        {{ $isEn
                            ? 'Corporate service requests cannot be submitted without a valid active contract. Please contact the system administrator to create or activate a contract.'
                            : 'لا يمكن تقديم طلبات خدمة تعاقدية بدون عقد صالح ونشط. يرجى التواصل مع إدارة النظام لإنشاء أو تفعيل العقد.' }}
                    </p>
                    @if($isAdmin)
                        <a href="{{ route('admin.contracts.create') }}?company_id={{ $company->id }}" class="inline-flex items-center gap-1 text-xs font-extrabold text-amber-800 hover:text-amber-900 underline mt-1">
                            {{ $isEn ? 'Create Contract Now →' : 'إنشاء عقد الآن ←' }}
                        </a>
                    @endif
                </div>
            </div>
        @endif

        {{-- Contract & Metric Summary --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                <span class="text-xs font-bold text-gray-500 block">{{ $isEn ? 'Active Contract Number' : 'رقم العقد الساري' }}</span>
                <div class="text-xl font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $activeContract->contract_number ?? ($isEn ? 'No Active Contract' : 'لا يوجد عقد نشط') }}</div>
                <span class="text-[11px] text-emerald-600 font-bold block">{{ $isEn ? 'Payment Terms:' : 'شروط الدفع:' }} {{ $activeContract->payment_terms ?? ($isEn ? 'Immediate' : 'فوري') }}</span>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                <span class="text-xs font-bold text-gray-500 block">{{ $isEn ? 'Approved Beneficiaries Count' : 'عدد المستفيدين المعتمدين' }}</span>
                <div class="text-2xl font-black text-accent dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $beneficiariesCount }} <span class="text-xs text-gray-400 font-bold">{{ $isEn ? 'beneficiaries' : 'مستفيد' }}</span></div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                <span class="text-xs font-bold text-gray-500 block">{{ $isEn ? 'Contract Validity Period' : 'تاريخ صلاحية العقد' }}</span>
                <div class="text-sm font-black text-gray-800 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $activeContract->start_date ?? '-' }} {{ $isEn ? 'to' : 'إلى' }} {{ $activeContract->end_date ?? '-' }}</div>
            </div>
        </div>

        {{-- Tab Navigation --}}
        <div class="bg-white rounded-3xl border border-gray-200 p-2 shadow-sm flex items-center gap-2 overflow-x-auto">
            <button @click="activeTab = 'requests'" :class="activeTab === 'requests' ? 'bg-primary text-white font-black' : 'text-gray-600 font-bold hover:bg-gray-100'" class="px-5 py-2.5 rounded-2xl text-xs transition-all whitespace-nowrap">
                {{ $isEn ? 'Service Requests & Tracking' : 'طلبات الخدمات والمتابعة التشغيلية' }}
            </button>
            <button @click="activeTab = 'contracts'" :class="activeTab === 'contracts' ? 'bg-primary text-white font-black' : 'text-gray-600 font-bold hover:bg-gray-100'" class="px-5 py-2.5 rounded-2xl text-xs transition-all whitespace-nowrap">
                {{ $isEn ? 'Contracts & Rates' : 'العقود والأسعار المعتمدة' }} ({{ $contractsList->count() }})
            </button>
            <button @click="activeTab = 'beneficiaries'" :class="activeTab === 'beneficiaries' ? 'bg-primary text-white font-black' : 'text-gray-600 font-bold hover:bg-gray-100'" class="px-5 py-2.5 rounded-2xl text-xs transition-all whitespace-nowrap">
                {{ $isEn ? 'Company Beneficiaries' : 'المستفيدين المسجلين' }} ({{ $beneficiaries->count() }})
            </button>
            <button @click="activeTab = 'lab_samples'" :class="activeTab === 'lab_samples' ? 'bg-primary text-white font-black' : 'text-gray-600 font-bold hover:bg-gray-100'" class="px-5 py-2.5 rounded-2xl text-xs transition-all whitespace-nowrap">
                {{ $isEn ? 'Lab Samples & Reports' : 'عينات وتقارير المختبر' }} ({{ $companyLabSamples->count() }})
            </button>
        </div>


        {{-- TAB 1: SERVICE REQUESTS --}}
        <div x-show="activeTab === 'requests'" class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
            <h3 class="font-black text-lg text-primary border-b border-gray-100 pb-4">{{ $isEn ? 'Corporate Medical Service Requests & Tracking' : 'طلبات الخدمات والمتابعة التشغيلية للشركة' }}</h3>

            <div class="overflow-x-auto">
                <table class="w-full {{ $isEn ? 'text-left' : 'text-right' }} text-xs">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 font-extrabold">
                            <th class="p-4">{{ $isEn ? 'Order No.' : 'رقم الطلب' }}</th>
                            <th class="p-4">{{ $isEn ? 'Beneficiary Name' : 'اسم المستفيد' }}</th>
                            <th class="p-4">{{ $isEn ? 'National ID / Iqama' : 'الهوية الوطنية / الإقامة' }}</th>
                            <th class="p-4">{{ $isEn ? 'Requested Service' : 'الخدمة المطلوبة' }}</th>
                            <th class="p-4">{{ $isEn ? 'Appointment Date' : 'تاريخ الموعد' }}</th>
                            <th class="p-4">{{ $isEn ? 'Contract Rate' : 'التكلفة التعاقدية' }}</th>
                            <th class="p-4">{{ $isEn ? 'Status' : 'الحالة التشغيلية' }}</th>
                            <th class="p-4 text-center">{{ $isEn ? 'Print / PDF' : 'الطباعة' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($companyBookings as $booking)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-4 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $booking->booking_number }}</td>
                                <td class="p-4 font-bold text-gray-800">{{ $booking->patient_name }}</td>
                                <td class="p-4 font-bold text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $booking->identification_number }} ({{ $booking->identification_type }})</td>
                                <td class="p-4 font-bold text-accent">{{ $booking->service->name ?? ($isEn ? 'Medical Service' : 'خدمة طبية') }}</td>
                                <td class="p-4 text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $booking->booking_date }} | {{ $booking->booking_time }}</td>
                                <td class="p-4 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($booking->total_price, 2) }} {{ $isEn ? 'SAR' : 'ر.س' }}</td>
                                <td class="p-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[11px] font-bold bg-primary/10 text-primary">{{ $booking->status }}</span>
                                </td>
                                <td class="p-4 text-center">
                                    <a href="{{ route('company.requests.print', $booking->id) }}" target="_blank" title="{{ $isEn ? 'Print Official Order' : 'طباعة تعميد الطلب' }}" class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold inline-block">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No corporate service requests recorded yet.' : 'لا توجد طلبات خدمات مسجلة للشركة حتى الآن.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $companyBookings->links() }}
            </div>
        </div>

        {{-- TAB 2: CONTRACTS & RATES --}}
        <div x-show="activeTab === 'contracts'" class="space-y-6">
            @foreach($contractsList as $cnt)
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <div>
                            <span class="text-xs font-bold text-gray-400 block">{{ $isEn ? 'Contract Number:' : 'رقم العقد:' }}</span>
                            <h4 class="text-lg font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $cnt->contract_number }}</h4>
                        </div>
                        <div>
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-emerald-50 text-emerald-700 font-extrabold text-xs rounded-full border border-emerald-200">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                <span>{{ $cnt->status === 'active' ? ($isEn ? 'Active' : 'نشط وساري') : $cnt->status }}</span>
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-xs">
                        <div>
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'Start Date:' : 'تاريخ البداية:' }}</span>
                            <span class="font-bold text-gray-800 block mt-0.5 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $cnt->start_date }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'End Date:' : 'تاريخ النهاية:' }}</span>
                            <span class="font-bold text-gray-800 block mt-0.5 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $cnt->end_date }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'Payment Terms:' : 'شروط التسوية:' }}</span>
                            <span class="font-bold text-gray-800 block mt-0.5">{{ $cnt->payment_terms }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'Covered Services Count:' : 'عدد الخدمات المشمولة:' }}</span>
                            <span class="font-bold text-accent block mt-0.5">{{ $cnt->contractPrices->count() }} {{ $isEn ? 'services' : 'خدمة' }}</span>
                        </div>
                    </div>

                    {{-- Covered Services Table --}}
                    <div class="pt-2">
                        <span class="text-xs font-black text-gray-700 block mb-2">{{ $isEn ? 'Approved Medical Services & Custom Contract Rates:' : 'الخدمات الطبية المعتمدة والأسعار التعاقدية للشركة:' }}</span>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-500 font-extrabold border-b border-gray-100">
                                        <th class="p-3">{{ $isEn ? 'Service Name' : 'اسم الخدمة الطبية' }}</th>
                                        <th class="p-3">{{ $isEn ? 'Public Price' : 'السعر العام' }}</th>
                                        <th class="p-3">{{ $isEn ? 'Corporate Approved Contract Rate' : 'السعر التعاقدي المعتمد للشركة' }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($cnt->contractPrices as $cp)
                                        <tr>
                                            <td class="p-3 font-bold text-gray-800">{{ $cp->service->name ?? '-' }}</td>
                                            <td class="p-3 font-bold text-gray-400 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($cp->service->price ?? 0, 2) }} SAR</td>
                                            <td class="p-3 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($cp->custom_price, 2) }} SAR</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="p-4 text-center text-gray-400 font-bold">{{ $isEn ? 'Standard corporate pricing applies.' : 'تطبق الأسعار والخصومات القياسية المعتمدة بالعقد.' }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- TAB 3: BENEFICIARIES --}}
        <div x-show="activeTab === 'beneficiaries'" class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-black text-lg text-primary">{{ $isEn ? 'Enrolled Company Beneficiaries' : 'قائمة المستفيدين المعتمدين بشركتكم' }}</h3>
                <button @click="openBeneficiaryModal = true" class="px-4 py-2 bg-[#006C35] text-white font-bold text-xs rounded-xl shadow hover:bg-[#00572B] transition-all">
                    {{ $isEn ? '+ Register New Beneficiary' : '+ تسجيل مستفيد جديد' }}
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 font-extrabold border-b border-gray-100">
                            <th class="p-3.5">{{ $isEn ? 'Beneficiary Name' : 'اسم المستفيد' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'ID Type & Number' : 'نوع ورقم الهوية' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Employee ID' : 'الرقم الوظيفي' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Phone' : 'الجوال' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Contract' : 'العقد المرتبط' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Status' : 'حالة الاستحقاق' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($beneficiaries as $ben)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-3.5 font-bold text-gray-800">{{ $ben->name }}</td>
                                <td class="p-3.5 font-bold text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ strtoupper($ben->identification_type) }}: {{ $ben->identification_number }}</td>
                                <td class="p-3.5 font-bold text-gray-500">{{ $ben->employee_id_number ?? '-' }}</td>
                                <td class="p-3.5 font-bold text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $ben->phone ?? '-' }}</td>
                                <td class="p-3.5 font-bold text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $ben->contract->contract_number ?? 'N/A' }}</td>
                                <td class="p-3.5 whitespace-nowrap">
                                    @if($ben->status === 'active')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 font-extrabold text-[11px] rounded-full">● {{ $isEn ? 'Active' : 'مستحق ونشط' }}</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-rose-50 text-rose-700 font-extrabold text-[11px] rounded-full">○ {{ $isEn ? 'Inactive' : 'غير نشط' }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No beneficiaries registered under your company yet.' : 'لا يوجد مستفيدين مسجلين لشركتكم بعد.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TAB 4: LAB SAMPLES & REPORTS --}}
        <div x-show="activeTab === 'lab_samples'" class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                <div>
                    <h3 class="font-black text-lg text-primary">{{ $isEn ? 'Company Beneficiaries Lab Samples & Reports' : 'سجل عينات وتقارير مختبر مستفيدي الشركة' }}</h3>
                    <p class="text-xs text-gray-500">{{ $isEn ? 'Real-time 9-stage tracking and secure PDF report downloads for your company beneficiaries' : 'تتبع العينات والنتائج الخاصة بمستفيدي الشركة والتحميل الآمن للتقارير' }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 font-extrabold border-b border-gray-100">
                            <th class="p-4">#</th>
                            <th class="p-4">{{ $isEn ? 'Visit Code' : 'رمز الزيارة' }}</th>
                            <th class="p-4">{{ $isEn ? 'Beneficiary Patient' : 'المريض / المستفيد' }}</th>
                            <th class="p-4">{{ $isEn ? 'Workflow Status' : 'حالة العينة' }}</th>
                            <th class="p-4">{{ $isEn ? 'Medical PDF Report' : 'التقرير الطبي' }}</th>
                            <th class="p-4">{{ $isEn ? 'Date' : 'تاريخ التسجيل' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($companyLabSamples as $sample)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-4 font-bold text-gray-400">{{ $sample->id }}</td>
                                <td class="p-4 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $sample->visit_code }}</td>
                                <td class="p-4 font-bold text-gray-800">{{ $sample->patient->name ?? '-' }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-800 text-[11px] font-bold border border-blue-200">
                                        {{ $sample->getCurrentStageIndex() }}/9. {{ $sample->sample_status }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    @if($sample->medicalReport && in_array($sample->sample_status, ['result_ready', 'report_uploaded', 'delivered']))
                                        <a href="{{ route('medical-reports.download', $sample->medicalReport->id) }}" target="_blank" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-sm transition-all inline-flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            <span>{{ $isEn ? 'Download PDF' : 'تحميل النتيجة PDF' }}</span>
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic text-[11px]">{{ $isEn ? 'Pending Lab Result' : 'بانتظار الفحص والتقرير' }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-gray-500 font-medium dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $sample->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No lab samples registered for your company beneficiaries yet.' : 'لا توجد عينات فحص مسجلة لمستفيدي شركتكم حتى الآن.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


        {{-- New Service Request Modal --}}
        <div x-show="openRequestModal" x-cloak class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-3 sm:p-6 overflow-y-auto">
            <div class="bg-white rounded-3xl max-w-xl w-full max-h-[85vh] flex flex-col shadow-2xl relative border border-gray-100 {{ $isEn ? 'text-left' : 'text-right' }} overflow-hidden">
                
                {{-- Modal Header --}}
                <div class="p-5 border-b border-gray-100 flex items-center justify-between shrink-0 bg-gray-50/50">
                    <h3 class="font-black text-base text-primary">{{ $isEn ? 'Submit New Service Request for Beneficiary' : 'تقديم طلب خدمة جديدة لمستفيد الشركة' }}</h3>
                    <button @click="openRequestModal = false" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-xl hover:bg-gray-200 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Modal Scrollable Body --}}
                <div class="p-5 overflow-y-auto flex-1 space-y-4">
                    <form id="corporateRequestForm" action="{{ route('company.requests.store') }}" method="POST" class="space-y-3.5">
                        @csrf
                        <input type="hidden" name="company_id" value="{{ $company->id }}">
                        <input type="hidden" name="contract_id" value="{{ $activeContract->id ?? '' }}">

                        @if($beneficiaries->isNotEmpty())
                            <div>
                                <label class="text-xs font-bold text-primary block mb-1">{{ $isEn ? 'Select Enrolled Beneficiary (Optional)' : 'اختر مستفيداً معتمداً مسجلاً بالنظام (اختياري)' }}</label>
                                <select id="beneficiarySelect" name="beneficiary_id" onchange="
                                    let selected = this.options[this.selectedIndex];
                                    if(selected.value) {
                                        document.getElementById('patientNameInput').value = selected.dataset.name || '';
                                        document.getElementById('idTypeInput').value = selected.dataset.type || 'saudi_id';
                                        document.getElementById('idNumInput').value = selected.dataset.number || '';
                                        document.getElementById('phoneInput').value = selected.dataset.phone || '';
                                    }
                                " class="w-full bg-emerald-50/50 border border-emerald-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                                    <option value="">{{ $isEn ? '-- Manual Input or Select Beneficiary --' : '-- إدخال مباشر أو اختر مستفيد مسجل --' }}</option>
                                    @foreach($beneficiaries as $ben)
                                        <option value="{{ $ben->id }}" data-name="{{ $ben->name }}" data-type="{{ $ben->identification_type }}" data-number="{{ $ben->identification_number }}" data-phone="{{ $ben->phone }}">
                                            {{ $ben->name }} ({{ strtoupper($ben->identification_type) }}: {{ $ben->identification_number }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Full Beneficiary Name *' : 'اسم المستفيد الكامل *' }}</label>
                                <input type="text" id="patientNameInput" name="patient_name" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Identification Type *' : 'نوع الهوية *' }}</label>
                                <select id="idTypeInput" name="identification_type" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                                    <option value="saudi_id">{{ $isEn ? 'Saudi National ID' : 'هوية وطنية سعودية' }}</option>
                                    <option value="iqama">{{ $isEn ? 'Iqama / Residency' : 'إقامة متقدمة/مقيم' }}</option>
                                    <option value="border_number">{{ $isEn ? 'Border Number' : 'رقم حدود' }}</option>
                                    <option value="gcc_id">{{ $isEn ? 'GCC ID' : 'هوية خليجية' }}</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'ID / Iqama Number *' : 'رقم الهوية / الإقامة *' }}</label>
                                <input type="text" id="idNumInput" name="identification_number" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Contact Phone Number *' : 'رقم جوال التواصل *' }}</label>
                                <input type="text" id="phoneInput" name="phone" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Requested Medical Service *' : 'الخدمة الطبية المطلوبة *' }}</label>
                                <select name="service_id" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                                    @foreach($services as $serv)
                                        <option value="{{ $serv->id }}">{{ $serv->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Appointment Date *' : 'تاريخ الموعد *' }}</label>
                                <input type="date" name="booking_date" value="{{ date('Y-m-d') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Appointment Time *' : 'وقت الموعد *' }}</label>
                                <input type="text" name="booking_time" value="10:00 AM" placeholder="{{ $isEn ? 'e.g. 10:00 AM' : 'مثال: 10:00 صباحاً' }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'City *' : 'المدينة *' }}</label>
                                <input type="text" name="city" value="{{ $company->city }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Detailed Visit Address *' : 'العنوان التفصيلي للزيارة المنزلية *' }}</label>
                            <input type="text" name="address" value="حي العليا، الرياض" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Additional Visit Notes' : 'ملاحظات إضافية للزيارة' }}</label>
                            <textarea name="notes" rows="2" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary resize-none"></textarea>
                        </div>
                    </form>
                </div>

                {{-- Sticky Modal Footer --}}
                <div class="p-4 border-t border-gray-100 bg-gray-50/50 flex items-center justify-end gap-3 shrink-0">
                    <button type="button" @click="openRequestModal = false" class="px-4 py-2.5 rounded-xl font-bold text-xs text-gray-500 hover:bg-gray-200 transition-colors">{{ $isEn ? 'Cancel' : 'إلغاء' }}</button>
                    <button type="submit" form="corporateRequestForm" class="px-6 py-2.5 bg-[#006C35] hover:bg-[#00572B] text-white rounded-xl font-black text-xs shadow-md transition-all cursor-pointer">{{ $isEn ? 'Confirm & Submit Request' : 'تأكيد وإرسال الطلب' }}</button>
                </div>
            </div>
        </div>

        {{-- Add Beneficiary Modal --}}
        <div x-show="openBeneficiaryModal" x-cloak class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-3 sm:p-6 overflow-y-auto">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative border border-gray-100 space-y-4 {{ $isEn ? 'text-left' : 'text-right' }}">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Register New Beneficiary' : 'تسجيل مستفيد جديد تحت عقد الشركة' }}</h3>
                    <button @click="openBeneficiaryModal = false" class="text-gray-400 hover:text-gray-600">✕</button>
                </div>
                <form action="{{ route('company.beneficiaries.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="company_id" value="{{ $company->id }}">
                    <input type="hidden" name="contract_id" value="{{ $activeContract->id ?? '' }}">

                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Beneficiary Name *' : 'اسم المستفيد *' }}</label>
                        <input type="text" name="name" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'ID Type *' : 'نوع الهوية *' }}</label>
                        <select name="identification_type" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold">
                            <option value="saudi_id">هوية وطنية (Saudi ID)</option>
                            <option value="iqama">إقامة (Iqama)</option>
                            <option value="border_number">رقم حدود (Border #)</option>
                            <option value="gcc_id">هوية خليجية (GCC ID)</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'ID / Iqama Number *' : 'رقم الهوية / الإقامة *' }}</label>
                        <input type="text" name="identification_number" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Employee ID (Optional)' : 'الرقم الوظيفي (اختياري)' }}</label>
                        <input type="text" name="employee_id_number" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Phone (Optional)' : 'الجوال (اختياري)' }}</label>
                        <input type="text" name="phone" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold">
                    </div>
                    <div class="pt-2 flex justify-end gap-2 border-t border-gray-100">
                        <button type="button" @click="openBeneficiaryModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-xl text-xs">إلغاء</button>
                        <button type="submit" class="px-5 py-2 bg-[#006C35] text-white font-extrabold rounded-xl text-xs">تسجيل المستفيد</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-dynamic-component>
