@php
    $isEn = app()->getLocale() == 'en';
    $isAdmin = in_array(Auth::user()->role, ['admin', 'super_admin', 'manager']);
    $layoutName = $isAdmin ? 'admin-layout' : 'app-layout';
    $currentStage = $sample->getCurrentStageIndex();
    $stages = [
        'registered' => ['title' => 'registered', 'title_ar' => '1. تسجيل العينة', 'time' => $sample->created_at],
        'assigned' => ['title' => 'assigned', 'title_ar' => '2. إسناد الفني', 'time' => $sample->assigned_staff_id ? $sample->updated_at : null],
        'sample_collected' => ['title' => 'sample_collected', 'title_ar' => '3. سحب العينة', 'time' => $sample->collected_at],
        'sent_to_lab' => ['title' => 'sent_to_lab', 'title_ar' => '4. إرسال للمختبر', 'time' => $sample->sent_to_lab_at],
        'received_by_lab' => ['title' => 'received_by_lab', 'title_ar' => '5. استلام بالمختبر', 'time' => $sample->received_at],
        'processing' => ['title' => 'processing', 'title_ar' => '6. بدء التحليل', 'time' => $sample->processing_at],
        'result_ready' => ['title' => 'result_ready', 'title_ar' => '7. النتيجة جاهزة', 'time' => $sample->result_ready_at],
        'report_uploaded' => ['title' => 'report_uploaded', 'title_ar' => '8. رفع التقرير', 'time' => $sample->report_uploaded_at],
        'delivered' => ['title' => 'delivered', 'title_ar' => '9. تم التسليم', 'time' => $sample->delivered_at],
    ];
@endphp

<x-dynamic-component :component="$layoutName" title="{{ $isEn ? 'Assigned Sample Management' : 'تفاصيل ومعالجة عينة المختبر' }}">
    @if($isAdmin)
        <x-slot name="headerTitle">{{ $isEn ? 'Assigned Sample Management' : 'تفاصيل ومعالجة عينة المختبر' }}</x-slot>
    @endif
    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">

        
        {{-- Header Bar --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-gray-200 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center font-black text-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.605 15.13a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="font-black text-lg text-primary dir-ltr">{{ $sample->visit_code }}</h2>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-primary/10 text-primary">Stage {{ $currentStage }}/9</span>
                    </div>
                    <p class="text-xs text-gray-500">{{ $isEn ? 'Assigned to' : 'الفني المسند' }}: {{ auth()->user()->name }}</p>
                </div>
            </div>
            
            <a href="{{ route('staff.lab.dashboard') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-200 transition-colors">
                {{ $isEn ? 'Back to Lab Workstation' : 'العودة للوحة المختبر' }}
            </a>
        </div>

        {{-- Flash Alerts --}}
        @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-bold flex items-center gap-2">
            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        {{-- 9-Stage Stepper --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
            <h3 class="font-black text-sm text-primary">{{ $isEn ? '9-Stage Workflow Timeline' : 'المراحل الزمنية الـ 9 للتحليل الطبي' }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-9 gap-2">
                @php $idx = 1; @endphp
                @foreach($stages as $key => $info)
                    @php
                        $isPassed = $currentStage >= $idx;
                        $isCurrent = $currentStage == $idx;
                        $bgColor = $isCurrent ? 'bg-primary text-white border-primary shadow-md' : ($isPassed ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-gray-50 text-gray-400 border-gray-100');
                    @endphp
                    <div class="p-2.5 rounded-xl border text-center flex flex-col justify-between transition-all {{ $bgColor }}">
                        <div>
                            <span class="text-[9px] font-black block opacity-75">Stage {{ $idx }}</span>
                            <span class="text-[10px] font-bold block mt-1 leading-tight">{{ $info['title_ar'] }}</span>
                        </div>
                        <div class="mt-2 pt-1 border-t border-black/10 text-[9px] font-semibold dir-ltr">
                            {{ $info['time'] ? $info['time']->format('m/d H:i') : '--:--' }}
                        </div>
                    </div>
                    @php $idx++; @endphp
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Workflow Status & PDF Upload --}}
            <div class="md:col-span-2 space-y-6">
                
                {{-- Patient Card --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs font-bold text-gray-400 block mb-1">{{ $isEn ? 'Patient' : 'المريض' }}</span>
                        <span class="text-sm font-black text-gray-800">{{ $sample->patient->name ?? '-' }}</span>
                        <span class="text-xs text-gray-500 block font-mono dir-ltr text-right">{{ $sample->patient->phone ?? '' }}</span>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-gray-400 block mb-1">{{ $isEn ? 'Company / Client' : 'الجهة/الشركة' }}</span>
                        <span class="text-sm font-black text-gray-800">{{ $sample->company->name ?? 'عميل أفراد' }}</span>
                    </div>
                </div>

                {{-- Status Update Form --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Update Sample Status' : 'تحديث مرحلة الفحص في المختبر' }}</h3>

                    <form method="POST" action="{{ route('staff.lab.status', $sample->id) }}" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Select Next Status' : 'اختر المرحلة التالية' }}</label>
                                <select name="sample_status" required class="w-full px-3 py-2 border border-gray-200 rounded-xl text-xs">
                                    <option value="assigned" {{ $sample->sample_status == 'assigned' ? 'selected' : '' }}>2. assigned (مسندة)</option>
                                    <option value="sample_collected" {{ $sample->sample_status == 'sample_collected' ? 'selected' : '' }}>3. sample_collected (تم جمع العينة)</option>
                                    <option value="sent_to_lab" {{ $sample->sample_status == 'sent_to_lab' ? 'selected' : '' }}>4. sent_to_lab (أرسلت للمختبر)</option>
                                    <option value="received_by_lab" {{ $sample->sample_status == 'received_by_lab' ? 'selected' : '' }}>5. received_by_lab (استلمت بالمختبر)</option>
                                    <option value="processing" {{ $sample->sample_status == 'processing' ? 'selected' : '' }}>6. processing (جارِ الفحص والتحليل)</option>
                                    <option value="result_ready" {{ $sample->sample_status == 'result_ready' ? 'selected' : '' }}>7. result_ready (النتيجة جاهزة للرفع)</option>
                                    <option value="report_uploaded" {{ $sample->sample_status == 'report_uploaded' ? 'selected' : '' }}>8. report_uploaded (تم رفع التقرير)</option>
                                    <option value="delivered" {{ $sample->sample_status == 'delivered' ? 'selected' : '' }}>9. delivered (تم تسليم النتيجة)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Notes' : 'ملاحظات التحليل' }}</label>
                                <input type="text" name="notes" placeholder="أدخل أي ملاحظات فنية..." class="w-full px-3 py-2 border border-gray-200 rounded-xl text-xs">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-5 py-2 bg-primary hover:bg-primary-hover text-white text-xs font-bold rounded-xl transition-colors">
                                {{ $isEn ? 'Update Status' : 'تحديث وتأكيد المرحلة' }}
                            </button>
                        </div>
                    </form>
                </div>

                {{-- PDF Report Upload --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Official Medical Report (PDF)' : 'رفع تقرير النتائج النهائي (PDF)' }}</h3>

                    @if($sample->medicalReport)
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-between">
                            <div>
                                <span class="font-bold text-xs text-gray-900 block">{{ $sample->medicalReport->file_name }}</span>
                                <span class="text-[10px] text-gray-500">
                                    {{ number_format($sample->medicalReport->file_size / 1024, 1) }} KB | Uploaded at {{ $sample->medicalReport->uploaded_at->format('Y/m/d H:i') }}
                                </span>
                            </div>
                            <a href="{{ route('medical-reports.download', $sample->medicalReport->id) }}" target="_blank" class="px-4 py-2 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700">
                                {{ $isEn ? 'View PDF' : 'استعراض PDF' }}
                            </a>
                        </div>
                    @else
                        <form method="POST" action="{{ route('medical-reports.store') }}" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <input type="hidden" name="patient_id" value="{{ $sample->patient_id }}">
                            <input type="hidden" name="lab_sample_id" value="{{ $sample->id }}">
                            <input type="hidden" name="booking_id" value="{{ $sample->booking_id }}">

                            <input type="file" name="report_pdf" accept="application/pdf" required class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary">

                            <button type="submit" class="w-full px-4 py-2.5 bg-accent hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition-colors">
                                {{ $isEn ? 'Upload Report PDF' : 'رفع تقرير النتائج الطبي المعتمد' }}
                            </button>
                        </form>
                    @endif
                </div>

            </div>

            {{-- Notes Sidebar --}}
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-2">
                    <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Sample Requirements' : 'تعليمات وتوجيهات الفحص' }}</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">{{ $sample->notes ?? 'لا توجد ملاحظات خاصة مسجلة لهذا التقرير.' }}</p>
                </div>
            </div>
        </div>

    </div>
</x-dynamic-component>

