@php
    $isEn = app()->getLocale() == 'en';
    $isAdmin = in_array(Auth::user()->role, ['admin', 'super_admin', 'manager']);
    $layoutName = $isAdmin ? 'admin-layout' : 'app-layout';
@endphp

<x-dynamic-component :component="$layoutName" title="{{ $isEn ? 'Corporate Portal & Contracts View' : 'بوابة الشركات والتعاقدات' }}">
    @if($isAdmin)
        <x-slot name="headerTitle">{{ $isEn ? 'Corporate Portal & Beneficiaries Operations' : 'بوابة الشركات والجهات المتعاقدة والمستفيدين' }}</x-slot>
    @endif

    <div class="space-y-8 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}" x-data="{ openRequestModal: false }">
        
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
            <div>
                <button @click="openRequestModal = true" class="bg-accent hover:bg-accent-hover text-white font-black text-xs px-6 py-3.5 rounded-2xl shadow-lg transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    <span>{{ $isEn ? 'Submit New Service Request for Beneficiary' : 'تقديم طلب خدمة جديد لمستفيد' }}</span>
                </button>
            </div>
        </div>

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

        {{-- Service Requests Table --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
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
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($companyBookings as $booking)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-4 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $booking->booking_number }}</td>
                                <td class="p-4 font-bold text-gray-800">{{ $booking->patient_name }}</td>
                                <td class="p-4 font-bold text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $booking->identification_number }} ({{ $booking->identification_type }})</td>
                                <td class="p-4 font-bold text-accent">{{ $booking->service->title ?? ($isEn ? 'Medical Service' : 'خدمة طبية') }}</td>
                                <td class="p-4 text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $booking->booking_date }} | {{ $booking->booking_time }}</td>
                                <td class="p-4 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($booking->total_price, 2) }} {{ $isEn ? 'SAR' : 'ر.س' }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-primary/10 text-primary">{{ $booking->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No corporate service requests recorded yet.' : 'لا توجد طلبات خدمات مسجلة للشركة حتى الآن.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $companyBookings->links() }}
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

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Full Beneficiary Name' : 'اسم المستفيد الكامل' }}</label>
                                <input type="text" name="patient_name" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Identification Type' : 'نوع الهوية' }}</label>
                                <select name="identification_type" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                                    <option value="saudi_id">{{ $isEn ? 'Saudi National ID' : 'هوية وطنية سعودية' }}</option>
                                    <option value="iqama">{{ $isEn ? 'Iqama / Residency' : 'إقامة متقدمة/مقيم' }}</option>
                                    <option value="border_no">{{ $isEn ? 'Border Number' : 'رقم حد' }}</option>
                                    <option value="gcc_id">{{ $isEn ? 'GCC ID' : 'هوية خليجية' }}</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'ID / Iqama Number' : 'رقم الهوية / الإقامة' }}</label>
                                <input type="text" name="identification_number" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Contact Phone Number' : 'رقم جوال التواصل' }}</label>
                                <input type="text" name="phone" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Requested Medical Service' : 'الخدمة الطبية المطلوبة' }}</label>
                                <select name="service_id" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                                    @foreach($services as $serv)
                                        <option value="{{ $serv->id }}">{{ $serv->title }} ({{ number_format($serv->price, 0) }} {{ $isEn ? 'SAR' : 'ر.س' }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Appointment Date' : 'تاريخ الموعد' }}</label>
                                <input type="date" name="booking_date" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Appointment Time' : 'وقت الموعد' }}</label>
                                <input type="text" name="booking_time" placeholder="{{ $isEn ? 'e.g. 10:00 AM' : 'مثال: 10:00 صباحاً' }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'City' : 'المدينة' }}</label>
                                <input type="text" name="city" value="{{ $company->city }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                            </div>
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Detailed Visit Address' : 'العنوان التفصيلي للزيارة المنزلية' }}</label>
                            <input type="text" name="address" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
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

    </div>
</x-dynamic-component>
