@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Laboratory Samples Management' : 'إدارة عينات وقسم المختبر' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Laboratory Samples & Diagnostics Directory' : 'سجل عينات المختبر والتشخيص الطبي' }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
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

        {{-- Metrics Summary Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.605 15.13a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-gray-400 block">{{ $isEn ? 'Total Samples' : 'إجمالي العينات' }}</span>
                    <span class="text-lg font-black text-gray-900">{{ $stats['total'] }}</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-gray-400 block">{{ $isEn ? 'Registered' : 'مسجلة جديدة' }}</span>
                    <span class="text-lg font-black text-amber-600">{{ $stats['registered'] }}</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-gray-400 block">{{ $isEn ? 'In Processing' : 'قيد التحليل' }}</span>
                    <span class="text-lg font-black text-blue-600">{{ $stats['processing'] }}</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-gray-400 block">{{ $isEn ? 'Result Ready' : 'جاهزة للتقرير' }}</span>
                    <span class="text-lg font-black text-purple-600">{{ $stats['result_ready'] }}</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-black">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-gray-400 block">{{ $isEn ? 'Delivered' : 'تم التسليم' }}</span>
                    <span class="text-lg font-black text-emerald-600">{{ $stats['delivered'] }}</span>
                </div>
            </div>
        </div>

        {{-- Filters & Actions Header --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="font-black text-base text-primary">{{ $isEn ? 'Lab Samples Register' : 'سجل عينات المختبر الطبية' }}</h3>
                    <p class="text-xs text-gray-500">{{ $isEn ? 'Manage 9-stage sample workflow, assigned lab staff, and PDF reports' : 'متابعة مراحل العينة الـ 9، وتكليف الفنيين ورفع تقارير PDF' }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.lab-samples.create') }}" class="px-4 py-2.5 bg-accent hover:bg-amber-600 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        <span>{{ $isEn ? 'Register New Sample' : 'تسجيل عينة جديدة' }}</span>
                    </a>
                </div>
            </div>

            {{-- Filter Form --}}
            <form method="GET" action="{{ route('admin.lab-samples.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-3 pt-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $isEn ? 'Search Visit Code, Patient...' : 'بحث برقم زيارة، اسم المريض...' }}" class="px-3 py-2 border border-gray-200 rounded-xl text-xs focus:ring-1 focus:ring-primary">
                
                <select name="status" class="px-3 py-2 border border-gray-200 rounded-xl text-xs focus:ring-1 focus:ring-primary">
                    <option value="">{{ $isEn ? 'All Workflow Stages' : 'جميع مراحل العينة' }}</option>
                    <option value="registered" {{ request('status') == 'registered' ? 'selected' : '' }}>1. registered (مسجلة)</option>
                    <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>2. assigned (مسندة)</option>
                    <option value="sample_collected" {{ request('status') == 'sample_collected' ? 'selected' : '' }}>3. sample_collected (تم الجمع)</option>
                    <option value="sent_to_lab" {{ request('status') == 'sent_to_lab' ? 'selected' : '' }}>4. sent_to_lab (أرسلت للمختبر)</option>
                    <option value="received_by_lab" {{ request('status') == 'received_by_lab' ? 'selected' : '' }}>5. received_by_lab (استلمت بمختبر)</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>6. processing (قيد التحليل)</option>
                    <option value="result_ready" {{ request('status') == 'result_ready' ? 'selected' : '' }}>7. result_ready (النتيجة جاهزة)</option>
                    <option value="report_uploaded" {{ request('status') == 'report_uploaded' ? 'selected' : '' }}>8. report_uploaded (تم رفع التقرير)</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>9. delivered (تم التسليم)</option>
                </select>

                <select name="company_id" class="px-3 py-2 border border-gray-200 rounded-xl text-xs focus:ring-1 focus:ring-primary">
                    <option value="">{{ $isEn ? 'All Companies' : 'جميع الشركات' }}</option>
                    @foreach($companies as $c)
                    <option value="{{ $c->id }}" {{ request('company_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>

                <select name="assigned_staff_id" class="px-3 py-2 border border-gray-200 rounded-xl text-xs focus:ring-1 focus:ring-primary">
                    <option value="">{{ $isEn ? 'All Lab Techs' : 'جميع فنيي المختبر' }}</option>
                    @foreach($labTechs as $t)
                    <option value="{{ $t->id }}" {{ request('assigned_staff_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                    @endforeach
                </select>

                <div class="flex items-center gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary-hover transition-colors">
                        {{ $isEn ? 'Filter' : 'تطبيق الفلترة' }}
                    </button>
                    <a href="{{ route('admin.lab-samples.index') }}" class="px-3 py-2 bg-gray-100 text-gray-600 text-xs font-bold rounded-xl hover:bg-gray-200">
                        {{ $isEn ? 'Reset' : 'إعادة ضبط' }}
                    </a>
                </div>
            </form>
        </div>

        {{-- Samples Table --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-right border-collapse">
                    <thead>
                        <tr class="bg-surface text-gray-700 font-bold border-b border-gray-200">
                            <th class="p-3">#</th>
                            <th class="p-3">{{ $isEn ? 'Visit Code' : 'رمز الزيارة' }}</th>
                            <th class="p-3">{{ $isEn ? 'Patient' : 'المريض' }}</th>
                            <th class="p-3">{{ $isEn ? 'Company' : 'الشركة' }}</th>
                            <th class="p-3">{{ $isEn ? 'Assigned Staff' : 'فني المختبر' }}</th>
                            <th class="p-3">{{ $isEn ? 'Stage & Status' : 'المرحلة والحالة' }}</th>
                            <th class="p-3">{{ $isEn ? 'Medical Report' : 'التقرير الطبي' }}</th>
                            <th class="p-3">{{ $isEn ? 'Date' : 'التاريخ' }}</th>
                            <th class="p-3 text-center">{{ $isEn ? 'Actions' : 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($samples as $s)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-bold text-gray-400">{{ $s->id }}</td>
                            <td class="p-3 font-black text-primary dir-ltr text-right">{{ $s->visit_code }}</td>
                            <td class="p-3">
                                <span class="font-bold text-gray-800 block">{{ $s->patient->name ?? '-' }}</span>
                                <span class="text-[10px] text-gray-400 dir-ltr">{{ $s->patient->phone ?? '' }}</span>
                            </td>
                            <td class="p-3 font-bold text-gray-700">
                                {{ $s->company->name ?? ($isEn ? 'Individual Patient' : 'عميل أفراد') }}
                            </td>
                            <td class="p-3 font-bold text-gray-700">
                                {{ $s->assignedStaff->name ?? ($isEn ? 'Not Assigned' : 'غير مسند') }}
                            </td>
                            <td class="p-3">
                                @php
                                    $stageIndex = $s->getCurrentStageIndex();
                                    $badgeColor = match($s->sample_status) {
                                        'registered' => 'bg-amber-50 text-amber-700 border-amber-200',
                                        'assigned' => 'bg-blue-50 text-blue-700 border-blue-200',
                                        'sample_collected' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                        'sent_to_lab' => 'bg-cyan-50 text-cyan-700 border-cyan-200',
                                        'received_by_lab' => 'bg-sky-50 text-sky-700 border-sky-200',
                                        'processing' => 'bg-purple-50 text-purple-700 border-purple-200',
                                        'result_ready' => 'bg-teal-50 text-teal-700 border-teal-200',
                                        'report_uploaded' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'delivered' => 'bg-emerald-100 text-emerald-800 border-emerald-300 font-black',
                                        default => 'bg-gray-50 text-gray-700 border-gray-200'
                                    };
                                @endphp
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold border inline-block {{ $badgeColor }}">
                                    {{ $stageIndex }}/9. {{ $s->sample_status }}
                                </span>
                            </td>
                            <td class="p-3">
                                @if($s->medicalReport)
                                    <a href="{{ route('medical-reports.download', $s->medicalReport->id) }}" target="_blank" class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-red-50 text-red-700 border border-red-200 rounded-lg text-[10px] font-bold hover:bg-red-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span>PDF ({{ number_format($s->medicalReport->file_size / 1024, 1) }} KB)</span>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic text-[11px]">{{ $isEn ? 'Pending PDF' : 'بانتظار التقرير' }}</span>
                                @endif
                            </td>
                            <td class="p-3 text-gray-500 font-medium">{{ $s->created_at->format('Y/m/d H:i') }}</td>
                            <td class="p-3 text-center">
                                <a href="{{ route('admin.lab-samples.show', $s->id) }}" class="px-3 py-1 bg-primary text-white rounded-lg text-[10px] font-bold hover:bg-primary-hover transition-colors inline-block">
                                    {{ $isEn ? 'View & Manage' : 'عرض والتفاصيل' }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center text-gray-400">
                                <p class="font-bold text-sm">{{ $isEn ? 'No lab samples found' : 'لا توجد عينات مختبر مسجلة حالياً' }}</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($samples->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $samples->links() }}
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
