<x-app-layout>
    <div class="py-10 bg-surface min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 text-right dir-rtl">
            
            {{-- Breadcrumb & Header --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-gray-200 pb-6">
                <div>
                    <a href="{{ route('profile') }}" class="text-xs font-bold text-gray-400 hover:text-primary flex items-center gap-1 mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        <span>العودة لبوابة حسابي</span>
                    </a>
                    <h1 class="text-2xl font-black text-primary">تفاصيل الحجز والزيارة الطبية #{{ $booking->booking_number }}</h1>
                </div>
                <div>
                    <span class="px-4 py-2 rounded-xl text-xs font-bold shadow-sm inline-block
                        @if($booking->status === 'completed' || $booking->status === 'verified') bg-emerald-100 text-emerald-800 border border-emerald-200
                        @elseif($booking->status === 'in_progress') bg-blue-100 text-blue-800 border border-blue-200
                        @elseif($booking->status === 'assigned' || $booking->status === 'accepted') bg-amber-100 text-amber-800 border border-amber-200
                        @else bg-gray-100 text-gray-800 border border-gray-200 @endif">
                        حالة الزيارة: {{ __($booking->status) }}
                    </span>
                </div>
            </div>

            {{-- Patient Workflow Visual Tracker (المسار التشغيلي للزيارة) --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
                <h3 class="font-black text-sm text-primary border-b border-gray-100 pb-3">مراحل وخطوات تنفيذ الزيارة الطبية</h3>
                
                @php
                    $steps = [
                        'requested' => 'تم استلام الطلب',
                        'assigned' => 'تم إسناد الكادر',
                        'accepted' => 'تم قبول الزيارة',
                        'in_progress' => 'قيد التنفيذ الميداني',
                        'completed' => 'تم اكتمال الزيارة',
                        'verified' => 'تم التحقق والاعتماد'
                    ];
                    $statusOrder = ['requested' => 1, 'assigned' => 2, 'accepted' => 3, 'in_progress' => 4, 'completed' => 5, 'verified' => 6];
                    $currentLevel = $statusOrder[$booking->status] ?? 1;
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 text-center">
                    @foreach($steps as $key => $label)
                        @php $level = $statusOrder[$key]; @endphp
                        <div class="p-3 rounded-2xl border text-xs font-bold space-y-1.5 transition-all
                            @if($level <= $currentLevel) bg-emerald-50 border-emerald-300 text-emerald-800 shadow-sm @else bg-gray-50 border-gray-200 text-gray-400 opacity-60 @endif">
                            <div class="w-6 h-6 rounded-full mx-auto flex items-center justify-center font-black text-[10px]
                                @if($level <= $currentLevel) bg-emerald-600 text-white @else bg-gray-300 text-gray-600 @endif">
                                {{ $level }}
                            </div>
                            <span class="block text-[11px] leading-tight">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Visit & Service Details Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Service & Patient Information --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary border-b border-gray-100 pb-3">معلومات الخدمة والزيارة</h3>
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-bold">اسم الخدمة الطبية:</span>
                            <span class="font-black text-primary">{{ $booking->service ? $booking->service->title : 'خدمة منزلية' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-bold">تاريخ الموعد:</span>
                            <span class="font-bold text-gray-800 dir-ltr">{{ $booking->booking_date }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-bold">الوقت المحدد:</span>
                            <span class="font-bold text-gray-800 dir-ltr">{{ $booking->booking_time }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-bold">مدينة الزيارة:</span>
                            <span class="font-bold text-gray-800">{{ $booking->city ?? 'الرياض' }}</span>
                        </div>
                        <div class="flex justify-between py-1">
                            <span class="text-gray-500 font-bold">العنوان والتفاصيل:</span>
                            <span class="font-bold text-gray-800">{{ $booking->address ?? 'العنوان المسجل' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Provider & Financial Summary --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary border-b border-gray-100 pb-3">الفريق الطبي والتكلفة المالية</h3>
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-bold">الممارس الطبي المسند:</span>
                            <span class="font-black text-primary">{{ $booking->assignedProvider ? $booking->assignedProvider->name : 'جاري تعيين الكادر الطبي' }}</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-bold">حالة الفاتورة والدفع:</span>
                            <span class="font-bold text-emerald-600">{{ $booking->payment_status === 'paid' ? 'تم السداد' : 'بانتظار الدفع' }} ({{ $booking->payment_method ?? 'نقداً/شبكة' }})</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-gray-50">
                            <span class="text-gray-500 font-bold">إجمالي المبلغ:</span>
                            <span class="font-black text-accent text-sm dir-ltr">{{ number_format($booking->total_price, 2) }} ر.س</span>
                        </div>
                        <div class="py-1">
                            <span class="text-gray-500 font-bold block mb-1">ملاحظات الزيارة:</span>
                            <p class="p-3 bg-gray-50 rounded-xl text-gray-700 font-medium text-[11px] leading-relaxed">{{ $booking->notes ?? 'لا توجد ملاحظات إضافية' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Lab Sample Tracking & Medical Reports Section --}}
            @if($booking->labSample || $booking->medicalReports->count() > 0)
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-6">
                    <h3 class="font-black text-sm text-primary border-b border-gray-100 pb-3">تتبع العينات المخبرية ونتائج التقرير PDF</h3>

                    {{-- Lab Sample Status Flow --}}
                    @if($booking->labSample)
                        <div class="p-4 bg-surface rounded-2xl border border-gray-100 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-xs text-primary">كود الزيارة المخبرية: <strong class="text-accent dir-ltr inline-block">{{ $booking->labSample->visit_code }}</strong></span>
                                <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-bold text-[11px] border border-blue-200">حالة العينة: {{ __($booking->labSample->sample_status) }}</span>
                            </div>
                        </div>
                    @endif

                    {{-- Reports PDF Section --}}
                    @if($booking->medicalReports->count() > 0)
                        <div class="space-y-3">
                            <h4 class="font-bold text-xs text-gray-700">تقارير نتائج التقرير الطبي المتاحة للتحميل:</h4>
                            @foreach($booking->medicalReports as $report)
                                <div class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-100 flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        </div>
                                        <div>
                                            <span class="font-bold text-xs text-primary block">{{ $report->file_name }}</span>
                                            <span class="text-[11px] text-gray-500">تاريخ الرفع: {{ $report->uploaded_at ?? $report->created_at->format('Y-m-d') }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('medical-reports.download', $report->id) }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-sm transition-all flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        <span>تحميل التقرير PDF</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
