@php
    $isEn = app()->getLocale() == 'en';
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

<x-admin-layout title="{{ $isEn ? 'Lab Sample Details' : 'تفاصيل ومسار عينة المختبر' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Lab Sample & Diagnostic Report' : 'تفاصيل العينة ومسار المعالجة الطبية' }}</x-slot>

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
                    <p class="text-xs text-gray-500">{{ $isEn ? 'Created at' : 'تاريخ التسجيل' }}: {{ $sample->created_at->format('Y/m/d H:i') }}</p>
                </div>
            </div>
            
            <a href="{{ route('admin.lab-samples.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-200 transition-colors">
                {{ $isEn ? 'Back to Samples Directory' : 'العودة لقائمة العينات' }}
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

        {{-- 9-Stage Workflow Interactive Stepper --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
            <h3 class="font-black text-sm text-primary mb-4">{{ $isEn ? '9-Stage Laboratory Workflow Timeline' : 'مراحل ومسار العينة الطبي المكتمل (9 مراحل)' }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-9 gap-2">
                @php $idx = 1; @endphp
                @foreach($stages as $key => $info)
                    @php
                        $isPassed = $currentStage >= $idx;
                        $isCurrent = $currentStage == $idx;
                        $bgColor = $isCurrent ? 'bg-primary text-white border-primary shadow-md' : ($isPassed ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-gray-50 text-gray-400 border-gray-100');
                    @endphp
                    <div class="p-3 rounded-xl border text-center flex flex-col justify-between transition-all {{ $bgColor }}">
                        <div>
                            <span class="text-[10px] font-black block opacity-75">Stage {{ $idx }}</span>
                            <span class="text-[11px] font-bold block mt-1 leading-tight">{{ $info['title_ar'] }}</span>
                        </div>
                        <div class="mt-2 pt-2 border-t border-black/10 text-[9px] font-semibold dir-ltr">
                            {{ $info['time'] ? $info['time']->format('m/d H:i') : '--:--' }}
                        </div>
                    </div>
                    @php $idx++; @endphp
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Main Details & Workflow Actions --}}
            <div class="md:col-span-2 space-y-6">
                
                {{-- Metadata Grid --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs font-bold text-gray-400 block mb-1">{{ $isEn ? 'Patient Name' : 'اسم المريض' }}</span>
                        <span class="text-sm font-black text-gray-800">{{ $sample->patient->name ?? '-' }}</span>
                        <span class="text-xs text-gray-500 block font-mono dir-ltr text-right">{{ $sample->patient->phone ?? '' }}</span>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-gray-400 block mb-1">{{ $isEn ? 'Corporate Company' : 'الشركة الرعاية' }}</span>
                        <span class="text-sm font-black text-gray-800">{{ $sample->company->name ?? ($isEn ? 'Individual' : 'أفراد (مستقل)') }}</span>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-gray-400 block mb-1">{{ $isEn ? 'Booking Reference' : 'رقم الحجز المرتبط' }}</span>
                        <span class="text-sm font-black text-primary font-mono dir-ltr text-right">{{ $sample->booking->booking_number ?? ($isEn ? 'Direct Visit' : 'زيارة مباشرة') }}</span>
                    </div>

                    <div>
                        <span class="text-xs font-bold text-gray-400 block mb-1">{{ $isEn ? 'Assigned Lab Staff' : 'فني المختبر المسند' }}</span>
                        <span class="text-sm font-black text-gray-800">{{ $sample->assignedStaff->name ?? ($isEn ? 'Unassigned' : 'غير مسند بعد') }}</span>
                    </div>
                </div>

                {{-- Workflow Action Form --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Update Workflow Stage' : 'تحديث وتمرير مرحلة العينة' }}</h3>
                    
                    <form method="POST" action="{{ route('admin.lab-samples.status', $sample->id) }}" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Target Workflow Status' : 'الحالة المستهدفة' }}</label>
                                <select name="sample_status" required class="w-full px-3 py-2 border border-gray-200 rounded-xl text-xs focus:ring-1 focus:ring-primary">
                                    <option value="registered" {{ $sample->sample_status == 'registered' ? 'selected' : '' }}>1. registered (مسجلة)</option>
                                    <option value="assigned" {{ $sample->sample_status == 'assigned' ? 'selected' : '' }}>2. assigned (مسندة)</option>
                                    <option value="sample_collected" {{ $sample->sample_status == 'sample_collected' ? 'selected' : '' }}>3. sample_collected (تم الجمع)</option>
                                    <option value="sent_to_lab" {{ $sample->sample_status == 'sent_to_lab' ? 'selected' : '' }}>4. sent_to_lab (أرسلت للمختبر)</option>
                                    <option value="received_by_lab" {{ $sample->sample_status == 'received_by_lab' ? 'selected' : '' }}>5. received_by_lab (استلمت بالمختبر)</option>
                                    <option value="processing" {{ $sample->sample_status == 'processing' ? 'selected' : '' }}>6. processing (قيد التحليل)</option>
                                    <option value="result_ready" {{ $sample->sample_status == 'result_ready' ? 'selected' : '' }}>7. result_ready (النتيجة جاهزة)</option>
                                    <option value="report_uploaded" {{ $sample->sample_status == 'report_uploaded' ? 'selected' : '' }}>8. report_uploaded (تم رفع التقرير)</option>
                                    <option value="delivered" {{ $sample->sample_status == 'delivered' ? 'selected' : '' }}>9. delivered (تم التسليم)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Stage Transition Notes' : 'ملاحظات الانتقال' }}</label>
                                <input type="text" name="notes" placeholder="{{ $isEn ? 'Reason or lab note...' : 'سبب أو ملاحظة الفحص...' }}" class="w-full px-3 py-2 border border-gray-200 rounded-xl text-xs focus:ring-1 focus:ring-primary">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-5 py-2 bg-primary hover:bg-primary-hover text-white text-xs font-bold rounded-xl transition-colors">
                                {{ $isEn ? 'Advance Workflow State' : 'اعتماد التحديث والمرحلة' }}
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Medical PDF Report Section --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Official Medical PDF Report' : 'التقرير والنتيجة الطبية المعتمدة (PDF)' }}</h3>
                    </div>

                    @if($sample->medicalReport)
                        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-700 flex items-center justify-center font-black">
                                    PDF
                                </div>
                                <div>
                                    <span class="font-bold text-xs text-gray-900 block">{{ $sample->medicalReport->file_name }}</span>
                                    <span class="text-[10px] text-gray-500 block">
                                        {{ number_format($sample->medicalReport->file_size / 1024, 1) }} KB | Uploaded by: {{ $sample->medicalReport->uploader->name ?? 'Admin' }} | {{ $sample->medicalReport->uploaded_at->format('Y/m/d H:i') }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <a href="{{ route('medical-reports.download', $sample->medicalReport->id) }}" target="_blank" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    <span>{{ $isEn ? 'Download PDF' : 'تحميل التقرير' }}</span>
                                </a>

                                <form method="POST" action="{{ route('medical-reports.destroy', $sample->medicalReport->id) }}" onsubmit="return confirm('هل أنت تأكد من رغبتك في حذف هذا التقرير النهائي؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-2 bg-red-100 text-red-700 rounded-xl text-xs font-bold hover:bg-red-200">
                                        {{ $isEn ? 'Delete' : 'حذف' }}
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Replace Report Form --}}
                        <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 space-y-3">
                            <h4 class="font-bold text-xs text-gray-700">{{ $isEn ? 'Replace Medical Report (Version Audit Saved)' : 'استبدال التقرير الطبي (حفظ النسخة السابقة بسجل الإصدارات)' }}</h4>
                            <form method="POST" action="{{ route('medical-reports.replace', $sample->medicalReport->id) }}" enctype="multipart/form-data" class="flex flex-col md:flex-row items-center gap-3">
                                @csrf
                                <input type="file" name="report_pdf" accept="application/pdf" required class="text-xs text-gray-500">
                                <input type="text" name="reason" placeholder="سبب الاستبدال..." class="flex-1 px-3 py-1.5 border rounded-xl text-xs">
                                <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-xl text-xs font-bold hover:bg-amber-700">
                                    {{ $isEn ? 'Upload New Version' : 'رفع وتأكيد الاستبدال' }}
                                </button>
                            </form>
                        </div>

                        {{-- Version Audit Log --}}
                        @if($sample->medicalReport->versions->count() > 0)
                        <div class="space-y-2 pt-2">
                            <h4 class="font-bold text-xs text-gray-600">{{ $isEn ? 'Previous PDF Report Versions' : 'سجل التعديلات والإصدارات السابقة للتقرير' }}</h4>
                            <div class="space-y-2">
                                @foreach($sample->medicalReport->versions as $ver)
                                <div class="p-3 bg-white border border-gray-100 rounded-xl text-[11px] flex items-center justify-between">
                                    <div>
                                        <span class="font-bold text-gray-800 block">{{ $ver->file_name }}</span>
                                        <span class="text-gray-400">Replaced by {{ $ver->replacer->name ?? 'Staff' }} on {{ $ver->created_at->format('Y/m/d H:i') }}</span>
                                        <span class="text-amber-700 italic block">{{ $ver->reason }}</span>
                                    </div>
                                    <span class="font-mono text-gray-500">{{ number_format($ver->file_size / 1024, 1) }} KB</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                    @else
                        {{-- Fresh Upload Form --}}
                        <div class="p-6 rounded-xl border border-dashed border-gray-300 text-center space-y-4">
                            <svg class="w-10 h-10 text-gray-400 mx-auto" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <div>
                                <p class="font-bold text-xs text-gray-700">{{ $isEn ? 'No official PDF report uploaded yet' : 'لم يتم رفع التقرير الطبي لهذه العينة حتى الآن' }}</p>
                                <p class="text-[11px] text-gray-400">{{ $isEn ? 'Upload PDF max 10MB' : 'امتداد PDF بحجم أقصى 10 ميجابايت' }}</p>
                            </div>

                            <form method="POST" action="{{ route('medical-reports.store') }}" enctype="multipart/form-data" class="max-w-md mx-auto space-y-3">
                                @csrf
                                <input type="hidden" name="patient_id" value="{{ $sample->patient_id }}">
                                <input type="hidden" name="lab_sample_id" value="{{ $sample->id }}">
                                <input type="hidden" name="booking_id" value="{{ $sample->booking_id }}">

                                <input type="file" name="report_pdf" accept="application/pdf" required class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">

                                <button type="submit" class="w-full px-4 py-2.5 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary-hover transition-colors">
                                    {{ $isEn ? 'Upload Official Report PDF' : 'رفع التقرير الطبي وتغيير الحالة' }}
                                </button>
                            </form>
                        </div>
                    @endif

                </div>

            </div>

            {{-- Sidebar Assignment & Timeline Log --}}
            <div class="space-y-6">
                
                {{-- Staff Assignment Form --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Assign Lab Technician' : 'تكليفات الفنيين بالمختبر' }}</h3>

                    <form method="POST" action="{{ route('admin.lab-samples.assign', $sample->id) }}" class="space-y-3">
                        @csrf
                        <select name="assigned_staff_id" required class="w-full px-3 py-2 border border-gray-200 rounded-xl text-xs">
                            <option value="">{{ $isEn ? '-- Select Technician --' : '-- اختر فني المختبر --' }}</option>
                            @foreach($labTechs as $tech)
                            <option value="{{ $tech->id }}" {{ $sample->assigned_staff_id == $tech->id ? 'selected' : '' }}>
                                {{ $tech->name }}
                            </option>
                            @endforeach
                        </select>
                        
                        <button type="submit" class="w-full px-4 py-2 bg-accent text-white text-xs font-bold rounded-xl hover:bg-amber-600 transition-colors">
                            {{ $isEn ? 'Assign / Reassign Staff' : 'تأكيد إسناد الفني' }}
                        </button>
                    </form>
                </div>

                {{-- Notes Box --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-2">
                    <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Sample Notes' : 'ملاحظات الفحص' }}</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">{{ $sample->notes ?? ($isEn ? 'No specific notes entered.' : 'لا توجد ملاحظات خاصة مسجلة.') }}</p>
                </div>

            </div>
        </div>

    </div>
</x-admin-layout>
