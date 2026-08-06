@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Medical Visit Details #' . $booking->booking_number : 'تفاصيل الزيارة الطبية #' . $booking->booking_number }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Standalone Service Request & Operations Management' : 'تفاصيل وتحديات الخدمة الطبية والتشغيلية' }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        {{-- Flash Notifications --}}
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

        {{-- Top Header Summary --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-1">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-black text-accent bg-accent/10 px-3 py-1 rounded-full dir-ltr">#{{ $booking->booking_number }}</span>
                    <h2 class="text-2xl font-black text-primary">{{ $booking->service->title ?? ($isEn ? 'Medical Home Service' : 'خدمة طبية منزلية') }}</h2>
                </div>
                <p class="text-xs text-gray-500">
                    {{ $isEn ? 'Patient Name:' : 'اسم المريض:' }} <strong class="text-gray-800">{{ $booking->patient_name ?? ($booking->user->name ?? '-') }}</strong> | 
                    {{ $isEn ? 'Date:' : 'التاريخ:' }} <strong class="text-gray-800 dir-ltr">{{ $booking->booking_date }} | {{ $booking->booking_time }}</strong> | 
                    {{ $isEn ? 'Price:' : 'السعر:' }} <strong class="text-primary dir-ltr">{{ number_format($booking->total_price, 2) }} {{ $isEn ? 'SAR' : 'ر.س' }}</strong>
                </p>
            </div>

            <div class="flex items-center gap-3">
                @php
                    $statusBadges = [
                        'requested' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => $isEn ? 'Requested' : 'مطلوب'],
                        'assigned' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'label' => $isEn ? 'Assigned' : 'تم الإسناد'],
                        'accepted' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'label' => $isEn ? 'Accepted' : 'تم القبول'],
                        'in_progress' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'label' => $isEn ? 'In Progress' : 'جاري التنفيذ'],
                        'completed' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'label' => $isEn ? 'Completed' : 'مكتملة'],
                        'verified' => ['bg' => 'bg-teal-50', 'text' => 'text-teal-800', 'label' => $isEn ? 'Verified ✓' : 'معتمدة وموثقة ✓'],
                        'cancelled' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'label' => $isEn ? 'Cancelled' : 'ملغاة'],
                    ];
                    $badge = $statusBadges[$booking->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => $booking->status];
                @endphp
                <span class="px-4 py-2 rounded-2xl text-xs font-black {{ $badge['bg'] }} {{ $badge['text'] }} border border-current">
                    {{ $badge['label'] }}
                </span>

                @if($booking->status === 'completed')
                    <form action="{{ route('admin.bookings.verify', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-xl font-black text-xs shadow-md transition-all border-0 cursor-pointer">
                            {{ $isEn ? 'Verify Visit ✓' : 'اعتماد وتوثيق الزيارة ✓' }}
                        </button>
                    </form>
                @endif

                <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition-all">
                    {{ $isEn ? 'Back to Register' : 'العودة للسجل' }}
                </a>
            </div>
        </div>

        {{-- Grid: Details & Assignment Controls --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Left Column: Patient, Service, and Company Info --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Patient & Visit Metadata --}}
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-base text-primary border-b border-gray-100 pb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>{{ $isEn ? 'Patient & Visit Address Information' : 'بيانات المريض وعنوان الزيارة' }}</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="space-y-1">
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'Patient Name' : 'اسم المريض' }}</span>
                            <strong class="text-gray-800 text-sm font-black block">{{ $booking->patient_name ?? ($booking->user->name ?? '-') }}</strong>
                        </div>

                        <div class="space-y-1">
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'Identification ID / Iqama' : 'الهوية الوطنية / الإقامة' }}</span>
                            <strong class="text-gray-800 font-bold block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $booking->identification_number ?? ($booking->user->identification_number ?? '-') }} ({{ $booking->identification_type ?? 'saudi_id' }})</strong>
                        </div>

                        <div class="space-y-1">
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'Contact Phone' : 'جوال التواصل' }}</span>
                            <strong class="text-gray-800 font-bold block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $booking->phone }}</strong>
                        </div>

                        <div class="space-y-1">
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'City & District' : 'المدينة والحي' }}</span>
                            <strong class="text-gray-800 font-bold block">{{ $booking->city }}</strong>
                        </div>

                        <div class="sm:col-span-2 space-y-1">
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'Full Home Address' : 'العنوان التفصيلي للزيارة' }}</span>
                            <strong class="text-gray-800 font-bold block">{{ $booking->address }}</strong>
                        </div>

                        @if($booking->notes)
                            <div class="sm:col-span-2 space-y-1 bg-amber-50 p-3 rounded-2xl border border-amber-200">
                                <span class="text-amber-800 font-bold block">{{ $isEn ? 'Operational Visit Notes:' : 'ملاحظات وتوجيهات للزيارة:' }}</span>
                                <p class="text-amber-900 font-medium">{{ $booking->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Corporate Contract Details (If applicable) --}}
                @if($booking->company)
                    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-4">
                        <h3 class="font-black text-base text-primary border-b border-gray-100 pb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>{{ $isEn ? 'Corporate Contract Reference' : 'بيانات التعاقد للشركة والجهة' }}</span>
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div class="space-y-1">
                                <span class="text-gray-400 font-bold block">{{ $isEn ? 'Company Name' : 'اسم الشركة المتعاقدة' }}</span>
                                <strong class="text-primary font-black block text-sm">{{ $booking->company->name }}</strong>
                            </div>

                            <div class="space-y-1">
                                <span class="text-gray-400 font-bold block">{{ $isEn ? 'Active Contract #' : 'رقم العقد الساري' }}</span>
                                <strong class="text-gray-800 font-bold block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $booking->contract->contract_number ?? ($booking->company->company_code ?? '-') }}</strong>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Real Timeline Audit Logs --}}
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
                    <h3 class="font-black text-base text-primary border-b border-gray-100 pb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $isEn ? 'Audit Trail & Operations Timeline' : 'الخط الزمني وسجل مراقبة العمليات Real Timeline' }}</span>
                    </h3>

                    <div class="relative border-r-2 border-primary/20 {{ $isEn ? 'border-r-0 border-l-2 ml-3' : 'mr-3' }} space-y-6 pr-6 {{ $isEn ? 'pl-6 pr-0' : '' }}">
                        {{-- Booking Creation --}}
                        <div class="relative">
                            <span class="absolute -right-8 {{ $isEn ? '-left-8 right-auto' : '' }} top-0 w-4 h-4 rounded-full bg-primary ring-4 ring-primary/20"></span>
                            <div class="text-xs">
                                <strong class="text-primary font-black block text-sm">{{ $isEn ? 'Service Requested' : 'تم إنشاء طلب الخدمة' }}</strong>
                                <span class="text-gray-400 block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $booking->created_at->format('Y-m-d H:i:s') }}</span>
                            </div>
                        </div>

                        {{-- Audit Log Events --}}
                        @foreach($timelineLogs as $log)
                            <div class="relative">
                                <span class="absolute -right-8 {{ $isEn ? '-left-8 right-auto' : '' }} top-0 w-4 h-4 rounded-full bg-accent ring-4 ring-accent/20"></span>
                                <div class="text-xs space-y-0.5">
                                    <strong class="text-gray-800 font-bold block">{{ $log->action }}</strong>
                                    <p class="text-gray-600">{{ $log->old_values ?? $log->new_values }}</p>
                                    <span class="text-gray-400 block text-[10px] dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $log->created_at->format('Y-m-d H:i:s') }} • {{ $log->user->name ?? 'System' }}</span>
                                </div>
                            </div>
                        @endforeach

                        @if($booking->verified_at)
                            <div class="relative">
                                <span class="absolute -right-8 {{ $isEn ? '-left-8 right-auto' : '' }} top-0 w-4 h-4 rounded-full bg-teal-600 ring-4 ring-teal-200"></span>
                                <div class="text-xs">
                                    <strong class="text-teal-800 font-black block text-sm">{{ $isEn ? 'Visit Verified & Confirmed' : 'تم اعتماد وتوثيق الزيارة' }}</strong>
                                    <span class="text-gray-400 block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $booking->verified_at }} • {{ $booking->verifiedBy->name ?? 'Admin' }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Right Column: Assignment & Reassignment Control Card --}}
            <div class="space-y-6">
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6 sticky top-6">
                    <h3 class="font-black text-base text-primary border-b border-gray-100 pb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        <span>{{ $isEn ? 'Service Practitioner Assignment' : 'إسناد الزيارة للممارس الطبي' }}</span>
                    </h3>

                    {{-- Current Provider Display --}}
                    <div class="p-4 bg-gray-50 rounded-2xl border border-gray-200 space-y-2">
                        <span class="text-xs font-bold text-gray-500 block">{{ $isEn ? 'Currently Assigned Practitioner:' : 'الممارس المسند له حالياً:' }}</span>
                        @if($booking->assignedProvider)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-primary text-white font-black flex items-center justify-center text-sm shrink-0">
                                    {{ mb_substr($booking->assignedProvider->name, 0, 1) }}
                                </div>
                                <div>
                                    <strong class="text-primary font-black block text-sm">{{ $booking->assignedProvider->name }}</strong>
                                    <span class="text-gray-500 text-[11px] block">{{ $booking->assignedProvider->role }} • {{ $booking->assignedProvider->staffProfile->license_number ?? '-' }}</span>
                                </div>
                            </div>
                            <span class="text-[10px] text-gray-400 block pt-1 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $isEn ? 'Assigned At:' : 'تاريخ الإسناد:' }} {{ $booking->assigned_at }}</span>
                        @else
                            <div class="p-3 bg-amber-50 text-amber-800 text-xs font-bold rounded-xl border border-amber-200">
                                {{ $isEn ? '⚠️ No practitioner currently assigned' : '⚠️ لم يتم إسناد هذه الزيارة لممارس بعد' }}
                            </div>
                        @endif
                    </div>

                    {{-- Interactive Assignment Form --}}
                    <form action="{{ route('admin.bookings.assign', $booking->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ $isEn ? 'Select Active Practitioner for Assignment / Reassignment *' : 'اختر الممارس الطبي لإسناد/إعادة الإسناد *' }}</label>
                            <select name="assigned_provider_id" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                                <option value="">{{ $isEn ? '-- Choose Qualified Active Staff --' : '-- اختر ممارس طبي نشط ومؤهل --' }}</option>
                                @foreach($staffList as $staff)
                                    <option value="{{ $staff->id }}" {{ $booking->assigned_provider_id == $staff->id ? 'selected' : '' }}>
                                        {{ $staff->name }} ({{ $staff->role }} - {{ $staff->staffProfile->specialty ?? 'General' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-[#006C35] hover:bg-[#00572B] text-white py-3.5 rounded-xl font-black text-xs shadow-md transition-all border-0 cursor-pointer flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ $booking->assigned_provider_id ? ($isEn ? 'Reassign Visit to Practitioner' : 'إعادة إسناد الزيارة') : ($isEn ? 'Assign Visit to Practitioner' : 'تأكيد إسناد الزيارة') }}</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>
</x-admin-layout>
