@php
    $isEn = app()->getLocale() == 'en';
@endphp

<x-admin-layout title="{{ $isEn ? 'Contract Details' : 'تفاصيل العقد والتعاقد' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Contract Details & Services Pricing' : 'تفاصيل العقد والخدمات المشمولة والتسعير' }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}" x-data="{ activeTab: '{{ $activeTab }}' }">
        
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

        {{-- Top Summary Header --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-3xl bg-primary/10 text-primary font-black flex items-center justify-center text-xl shrink-0">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="space-y-1">
                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $contract->contract_number }}</h2>
                        @if($contract->status === 'active')
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-emerald-50 text-emerald-700 font-extrabold text-xs rounded-full border border-emerald-200 shadow-sm whitespace-nowrap">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                <span>{{ $isEn ? 'Active' : 'نشط' }}</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-rose-50 text-rose-700 font-extrabold text-xs rounded-full border border-rose-200 shadow-sm whitespace-nowrap">
                                <span class="w-2 h-2 rounded-full bg-rose-500 shrink-0"></span>
                                <span>{{ $contract->status }}</span>
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500">
                        {{ $isEn ? 'Company:' : 'الشركة المتعاقدة:' }} <strong class="text-gray-800 font-black">{{ $contract->company->name ?? '-' }}</strong> | 
                        {{ $isEn ? 'Payment Terms:' : 'شروط الدفع:' }} {{ $contract->payment_terms }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.contracts.edit', $contract->id) }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 font-extrabold text-xs rounded-2xl transition-all">
                    {{ $isEn ? 'Edit Terms' : 'تعديل العقد' }}
                </a>
                <a href="{{ route('admin.companies.show', $contract->company_id) }}" class="px-5 py-2.5 bg-primary/10 hover:bg-primary/20 text-primary font-extrabold text-xs rounded-2xl transition-all">
                    {{ $isEn ? 'View Company' : 'عرض الشركة' }}
                </a>
            </div>
        </div>

        {{-- Metrics Row --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-3xl border border-gray-200 shadow-sm">
                <span class="text-xs text-gray-400 font-bold block">{{ $isEn ? 'Covered Services' : 'الخدمات المشمولة' }}</span>
                <span class="text-2xl font-black text-primary block mt-1">{{ $contract->contractPrices->count() }}</span>
            </div>
            <div class="bg-white p-5 rounded-3xl border border-gray-200 shadow-sm">
                <span class="text-xs text-gray-400 font-bold block">{{ $isEn ? 'Active Beneficiaries' : 'المستفيدين المعتمدين' }}</span>
                <span class="text-2xl font-black text-accent block mt-1">{{ $contract->beneficiaries->count() }}</span>
            </div>
            <div class="bg-white p-5 rounded-3xl border border-gray-200 shadow-sm">
                <span class="text-xs text-gray-400 font-bold block">{{ $isEn ? 'Executed Visits' : 'الزيارات المنفذة' }}</span>
                <span class="text-2xl font-black text-emerald-600 block mt-1">{{ $contract->bookings->count() }}</span>
            </div>
            <div class="bg-white p-5 rounded-3xl border border-gray-200 shadow-sm">
                <span class="text-xs text-gray-400 font-bold block">{{ $isEn ? 'Validity Period' : 'فترة الصلاحية' }}</span>
                <span class="text-xs font-black text-gray-700 block mt-2 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $contract->start_date }} → {{ $contract->end_date }}</span>
            </div>
        </div>

        {{-- Tabs Navigation --}}
        <div class="bg-white rounded-3xl border border-gray-200 p-2 shadow-sm flex items-center gap-2 overflow-x-auto">
            <button @click="activeTab = 'overview'" :class="activeTab === 'overview' ? 'bg-primary text-white font-black' : 'text-gray-600 font-bold hover:bg-gray-100'" class="px-5 py-2.5 rounded-2xl text-xs transition-all whitespace-nowrap">
                {{ $isEn ? 'Overview' : 'نظرة عامة' }}
            </button>
            <button @click="activeTab = 'services'" :class="activeTab === 'services' ? 'bg-primary text-white font-black' : 'text-gray-600 font-bold hover:bg-gray-100'" class="px-5 py-2.5 rounded-2xl text-xs transition-all whitespace-nowrap flex items-center gap-1.5">
                <span>{{ $isEn ? 'Included Services & Pricing' : 'الخدمات المشمولة والأسعار' }}</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] bg-accent/20 text-accent font-black">{{ $contract->contractPrices->count() }}</span>
            </button>
            <button @click="activeTab = 'beneficiaries'" :class="activeTab === 'beneficiaries' ? 'bg-primary text-white font-black' : 'text-gray-600 font-bold hover:bg-gray-100'" class="px-5 py-2.5 rounded-2xl text-xs transition-all whitespace-nowrap">
                {{ $isEn ? 'Beneficiaries List' : 'سجل المستفيدين' }} ({{ $contract->beneficiaries->count() }})
            </button>
            <button @click="activeTab = 'visits'" :class="activeTab === 'visits' ? 'bg-primary text-white font-black' : 'text-gray-600 font-bold hover:bg-gray-100'" class="px-5 py-2.5 rounded-2xl text-xs transition-all whitespace-nowrap">
                {{ $isEn ? 'Service Requests / Visits' : 'طلبات الزيارات' }} ({{ $contract->bookings->count() }})
            </button>
        </div>

        {{-- TAB 1: OVERVIEW --}}
        <div x-show="activeTab === 'overview'" class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm space-y-6">
            <h3 class="text-base font-black text-primary border-b border-gray-100 pb-3">{{ $isEn ? 'Contract Summary' : 'ملخص شروط الاتفاقية' }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500 font-bold">{{ $isEn ? 'Contract Number:' : 'رقم العقد:' }}</span>
                        <span class="font-black text-primary dir-ltr">{{ $contract->contract_number }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500 font-bold">{{ $isEn ? 'Contracted Company:' : 'الشركة المتعاقدة:' }}</span>
                        <span class="font-black text-gray-800">{{ $contract->company->name ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500 font-bold">{{ $isEn ? 'CR Number:' : 'السجل التجاري:' }}</span>
                        <span class="font-bold text-gray-700 dir-ltr">{{ $contract->company->cr_number ?? 'N/A' }}</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500 font-bold">{{ $isEn ? 'Start Date:' : 'تاريخ البداية:' }}</span>
                        <span class="font-bold text-gray-800 dir-ltr">{{ $contract->start_date }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500 font-bold">{{ $isEn ? 'End Date:' : 'تاريخ النهاية:' }}</span>
                        <span class="font-bold text-gray-800 dir-ltr">{{ $contract->end_date }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-50">
                        <span class="text-gray-500 font-bold">{{ $isEn ? 'Discount Percentage Override:' : 'نسبة الخصم التعاقدي:' }}</span>
                        <span class="font-extrabold text-emerald-600">{{ $contract->discount_percentage }}%</span>
                    </div>
                </div>
            </div>

            @if($contract->notes)
                <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 space-y-1">
                    <span class="text-xs font-black text-gray-700 block">{{ $isEn ? 'Contract Notes:' : 'ملاحظات وشروط العقد:' }}</span>
                    <p class="text-xs text-gray-600 leading-relaxed">{{ $contract->notes }}</p>
                </div>
            @endif
        </div>

        {{-- TAB 2: INCLUDED SERVICES & PRICING --}}
        <div x-show="activeTab === 'services'" class="space-y-6">
            {{-- Add Service Form --}}
            <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm space-y-4">
                <h3 class="text-sm font-black text-primary flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    <span>{{ $isEn ? 'Add Service & Set Contract Price' : 'إضافة خدمة جديدة للعقد وتحديد السعر التعاقدي المخصص' }}</span>
                </h3>

                @if($availableServices->isNotEmpty())
                    <form action="{{ route('admin.contracts.services.add', $contract->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Select Service *' : 'اختر الخدمة الطبية *' }}</label>
                            <select name="service_id" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                                @foreach($availableServices as $srv)
                                    <option value="{{ $srv->id }}">{{ $srv->name }} (السعر العام: {{ number_format($srv->price, 2) }} ر.س)</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Custom Contract Price (SAR) *' : 'السعر التعاقدي المخصص (ر.س) *' }}</label>
                            <input type="number" step="0.01" min="0" name="custom_price" placeholder="0.00" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-[#006C35] hover:bg-[#00572B] text-white font-extrabold text-xs py-3 rounded-xl shadow transition-all">
                                {{ $isEn ? 'Attach Service & Price' : 'إضافة الخدمة وسعر العقد' }}
                            </button>
                        </div>
                    </form>
                @else
                    <p class="text-xs text-gray-500 font-bold bg-gray-50 p-4 rounded-2xl">{{ $isEn ? 'All available medical services have already been added to this contract.' : 'جميع الخدمات الطبية المتاحة مضافة ومسقّفة أصلًا لهذا العقد.' }}</p>
                @endif
            </div>

            {{-- Included Services Table --}}
            <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden p-6">
                <h3 class="text-sm font-black text-primary mb-4">{{ $isEn ? 'Included Services & Contract Pricing Table' : 'جدول الخدمات المشمولة والأسعار التعاقدية المخصصة' }}</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-700 font-extrabold border-b border-gray-200">
                                <th class="p-3.5">{{ $isEn ? 'Service Name' : 'اسم الخدمة الطبية' }}</th>
                                <th class="p-3.5">{{ $isEn ? 'Standard Public Price' : 'السعر العام بالتطبيق' }}</th>
                                <th class="p-3.5">{{ $isEn ? 'Custom Contract Price' : 'السعر التعاقدي المخصص' }}</th>
                                <th class="p-3.5">{{ $isEn ? 'Discount Savings' : 'قيمة الخصم للشركة' }}</th>
                                <th class="p-3.5 text-center">{{ $isEn ? 'Actions' : 'الإجراءات' }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($contract->contractPrices as $cp)
                                @php
                                    $publicPrice = $cp->service->price ?? 0;
                                    $savings = $publicPrice - $cp->custom_price;
                                @endphp
                                <tr class="hover:bg-gray-50/80 transition-colors">
                                    <td class="p-3.5 font-bold text-gray-800">{{ $cp->service->name ?? '-' }}</td>
                                    <td class="p-3.5 font-bold text-gray-500 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($publicPrice, 2) }} SAR</td>
                                    <td class="p-3.5 font-black text-primary text-sm dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($cp->custom_price, 2) }} SAR</td>
                                    <td class="p-3.5 font-bold text-emerald-600">
                                        @if($savings > 0)
                                            {{ number_format($savings, 2) }} SAR (توفير للشركة)
                                        @else
                                            سعر خاص
                                        @endif
                                    </td>
                                    <td class="p-3.5 text-center">
                                        <div class="flex items-center justify-center gap-2" x-data="{ editPrice: false, priceVal: '{{ $cp->custom_price }}' }">
                                            <button @click="editPrice = !editPrice" class="px-2.5 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-lg text-[11px]">
                                                {{ $isEn ? 'Update Price' : 'تعديل السعر' }}
                                            </button>
                                            <form action="{{ route('admin.contracts.services.remove', ['contract' => $contract->id, 'serviceId' => $cp->service_id]) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من إزالة الخدمة من العقد؟')">
                                                @csrf
                                                <button type="submit" class="px-2.5 py-1 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold rounded-lg text-[11px]">
                                                    {{ $isEn ? 'Remove' : 'إزالة' }}
                                                </button>
                                            </form>

                                            {{-- Inline Edit Price Modal/Form --}}
                                            <template x-if="editPrice">
                                                <div class="fixed inset-0 bg-black/40 z-50 flex items-center justify-center p-4">
                                                    <div class="bg-white p-6 rounded-3xl max-w-sm w-full space-y-4 text-right dir-rtl shadow-2xl">
                                                        <h4 class="font-black text-sm text-primary">تحديث السعر التعاقدي للخدمة</h4>
                                                        <p class="text-xs text-gray-500">{{ $cp->service->name }}</p>
                                                        <form action="{{ route('admin.contracts.prices.update', ['contract' => $contract->id, 'priceId' => $cp->id]) }}" method="POST" class="space-y-3">
                                                            @csrf
                                                            <input type="number" step="0.01" min="0" name="custom_price" x-model="priceVal" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold">
                                                            <div class="flex justify-end gap-2">
                                                                <button type="button" @click="editPrice = false" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-xl text-xs">إلغاء</button>
                                                                <button type="submit" class="px-4 py-2 bg-primary text-white font-extrabold rounded-xl text-xs">حفظ السعر</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No custom service prices added to this contract yet.' : 'لم يتم إضافة أسعار تعاقدية مخصصة لهذا العقد بعد.' }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- TAB 3: BENEFICIARIES --}}
        <div x-show="activeTab === 'beneficiaries'" class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden p-6 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-black text-primary">{{ $isEn ? 'Enrolled Beneficiaries' : 'المستفيدين المعتمدين تحت هذا العقد' }}</h3>
                <a href="{{ route('admin.beneficiaries.create', ['company_id' => $contract->company_id]) }}" class="px-4 py-2 bg-primary text-white font-bold text-xs rounded-xl shadow hover:bg-primary-hover transition-all">
                    {{ $isEn ? '+ Add Beneficiary' : '+ إضافة مستفيد جديد' }}
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 font-extrabold border-b border-gray-200">
                            <th class="p-3.5">{{ $isEn ? 'Beneficiary Name' : 'اسم المستفيد' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'ID Type & Number' : 'نوع ورقم الهوية' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Employee ID' : 'الرقم الوظيفي' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Linked Patient Account' : 'الحساب المسجل بالنظام' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Status' : 'الحالة' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($contract->beneficiaries as $ben)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-3.5 font-bold text-gray-800">{{ $ben->name }}</td>
                                <td class="p-3.5 font-bold text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ strtoupper($ben->identification_type) }}: {{ $ben->identification_number }}</td>
                                <td class="p-3.5 font-bold text-gray-500">{{ $ben->employee_id_number ?? '-' }}</td>
                                <td class="p-3.5 font-bold text-primary">
                                    @if($ben->patient)
                                        <span class="text-emerald-700 font-black">✓ {{ $ben->patient->name }} (ID: {{ $ben->patient->id }})</span>
                                    @else
                                        <span class="text-gray-400 font-bold">{{ $isEn ? 'Unlinked (Standalone)' : 'غير مرتبط بحساب مستخدم' }}</span>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No beneficiaries registered under this contract yet.' : 'لا يوجد مستفيدين مسجلين تحت هذا العقد بعد.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TAB 4: VISITS --}}
        <div x-show="activeTab === 'visits'" class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden p-6">
            <h3 class="text-sm font-black text-primary mb-4">{{ $isEn ? 'Corporate Service Requests Executed Under Contract' : 'سجل زيارات وطلبات الخدمات الطبية المنفذة بموجب العقد' }}</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 font-extrabold border-b border-gray-200">
                            <th class="p-3.5">{{ $isEn ? 'Booking Number' : 'رقم الحجز' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Patient / Beneficiary' : 'المريض / المستفيد' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Service Requested' : 'الخدمة الطبية' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Date & Time' : 'التاريخ والوقت' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Contract Price' : 'المبلغ التعاقدي' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Status' : 'الحالة' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($contract->bookings as $b)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-3.5 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $b->booking_number }}</td>
                                <td class="p-3.5 font-bold text-gray-800">{{ $b->patient_name }}</td>
                                <td class="p-3.5 font-bold text-gray-700">{{ $b->service->name ?? '-' }}</td>
                                <td class="p-3.5 font-bold text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $b->booking_date }} {{ $b->booking_time }}</td>
                                <td class="p-3.5 font-black text-primary text-sm dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($b->total_price, 2) }} SAR</td>
                                <td class="p-3.5 font-bold text-emerald-700">{{ $b->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No service requests submitted under this contract yet.' : 'لا توجد طلبات زيارات منفذة بموجب هذا العقد حتى الآن.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-admin-layout>
