@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Contract Request Details #' . $contractRequest->id : 'تفاصيل طلب التعاقد #' . $contractRequest->id }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Corporate Services Contract Request Review & Conversion' : 'مراجعة طلب التعاقد وتحويله إلى حساب شركة رسمية' }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}" x-data="{ showRejectModal: false }">
        
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

        {{-- Header Bar --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-1">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-black text-accent bg-accent/10 px-3 py-1 rounded-full dir-ltr">#REQ-{{ $contractRequest->id }}</span>
                    <h2 class="text-2xl font-black text-primary">{{ $contractRequest->company_name }}</h2>
                </div>
                <p class="text-xs text-gray-500">
                    {{ $isEn ? 'Contact:' : 'مسؤول التواصل:' }} <strong class="text-gray-800">{{ $contractRequest->contact_person }}</strong> | 
                    {{ $isEn ? 'Phone:' : 'الجوال:' }} <strong class="text-gray-800 dir-ltr">{{ $contractRequest->phone }}</strong> | 
                    {{ $isEn ? 'Date:' : 'التاريخ:' }} <strong class="text-gray-800 dir-ltr">{{ $contractRequest->created_at->format('Y-m-d H:i') }}</strong>
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                @php
                    $badges = [
                        'new' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => $isEn ? 'New' : 'جديد'],
                        'under_review' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'label' => $isEn ? 'Under Review' : 'قيد المراجعة'],
                        'approved' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'label' => $isEn ? 'Approved' : 'معتمد (مقبول)'],
                        'rejected' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'label' => $isEn ? 'Rejected' : 'مرفوض'],
                    ];
                    $badge = $badges[$contractRequest->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => $contractRequest->status];
                @endphp
                <span class="px-4 py-2 rounded-2xl text-xs font-black {{ $badge['bg'] }} {{ $badge['text'] }} border border-current">
                    {{ $badge['label'] }}
                </span>

                {{-- Workflow Action Buttons --}}
                @if($contractRequest->status === 'new')
                    <form action="{{ route('admin.contract-requests.status', $contractRequest->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="under_review">
                        <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2.5 rounded-xl font-bold text-xs shadow transition-all border-0 cursor-pointer">
                            {{ $isEn ? 'Mark as Under Review' : 'بدء المراجعة والتدقيق' }}
                        </button>
                    </form>
                @endif

                @if($contractRequest->status === 'under_review')
                    <form action="{{ route('admin.contract-requests.status', $contractRequest->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl font-bold text-xs shadow transition-all border-0 cursor-pointer">
                            {{ $isEn ? 'Approve Request ✓' : 'الموافقة الاعتماد ✓' }}
                        </button>
                    </form>

                    <button @click="showRejectModal = true" class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2.5 rounded-xl font-bold text-xs shadow transition-all border-0 cursor-pointer">
                        {{ $isEn ? 'Reject Request ✕' : 'رفض الطلب ✕' }}
                    </button>
                @endif

                {{-- Convert to Company Action --}}
                @if($contractRequest->status === 'approved' && !$contractRequest->converted_company_id)
                    <form action="{{ route('admin.contract-requests.convert', $contractRequest->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-[#006C35] hover:bg-[#00572B] text-white px-5 py-2.5 rounded-xl font-black text-xs shadow-lg transition-all border-0 cursor-pointer flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span>{{ $isEn ? 'Create Company from Approved Request' : 'تحويل الطلب إلى شركة رسمية' }}</span>
                        </button>
                    </form>
                @endif

                @if($contractRequest->convertedCompany)
                    <a href="{{ route('admin.companies.show', $contractRequest->convertedCompany->id) }}" class="bg-primary text-white px-4 py-2.5 rounded-xl font-bold text-xs shadow transition-all flex items-center gap-2">
                        <span>{{ $isEn ? 'View Converted Company' : 'عرض حساب الشركة' }}</span>
                        <span class="text-[10px] bg-white/20 px-2 py-0.5 rounded dir-ltr">{{ $contractRequest->convertedCompany->company_code }}</span>
                    </a>
                @endif

                <a href="{{ route('admin.contract-requests.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition-all">
                    {{ $isEn ? 'Back to List' : 'العودة للقائمة' }}
                </a>
            </div>
        </div>

        {{-- Submitted Details Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-base text-primary border-b border-gray-100 pb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>{{ $isEn ? 'Submitted Corporate Information' : 'بيانات التعاقد والشركة المقدمة' }}</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="space-y-1">
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'Company Name' : 'اسم الشركة / الجهة' }}</span>
                            <strong class="text-primary font-black text-sm block">{{ $contractRequest->company_name }}</strong>
                        </div>

                        <div class="space-y-1">
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'CR Number' : 'السجل التجاري' }}</span>
                            <strong class="text-gray-800 font-bold block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $contractRequest->cr_number ?? '-' }}</strong>
                        </div>

                        <div class="space-y-1">
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'Contact Person' : 'مسؤول التواصل' }}</span>
                            <strong class="text-gray-800 font-bold block">{{ $contractRequest->contact_person }}</strong>
                        </div>

                        <div class="space-y-1">
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'Contact Phone' : 'جوال التواصل' }}</span>
                            <strong class="text-gray-800 font-bold block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $contractRequest->phone }}</strong>
                        </div>

                        <div class="space-y-1">
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'Official Email' : 'البريد الإلكتروني' }}</span>
                            <strong class="text-gray-800 font-bold block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $contractRequest->email }}</strong>
                        </div>

                        <div class="space-y-1">
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'City' : 'المدينة' }}</span>
                            <strong class="text-gray-800 font-bold block">{{ $contractRequest->city ?? '-' }}</strong>
                        </div>

                        <div class="space-y-1">
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'Expected Beneficiaries' : 'عدد المستفيدين المتوقعين' }}</span>
                            <strong class="text-accent font-black text-sm block">{{ $contractRequest->expected_beneficiaries }} {{ $isEn ? 'Beneficiaries' : 'مستفيد' }}</strong>
                        </div>

                        <div class="space-y-1">
                            <span class="text-gray-400 font-bold block">{{ $isEn ? 'Requested Services' : 'الخدمات الطبية المطلوبة' }}</span>
                            <strong class="text-gray-800 font-bold block">{{ $contractRequest->requested_services ?? '-' }}</strong>
                        </div>

                        @if($contractRequest->notes)
                            <div class="sm:col-span-2 space-y-1 bg-gray-50 p-4 rounded-2xl border border-gray-200">
                                <span class="text-gray-500 font-bold block">{{ $isEn ? 'Company Notes & Requirements:' : 'ملاحظات ومتطلبات الشركة:' }}</span>
                                <p class="text-gray-800 font-medium">{{ $contractRequest->notes }}</p>
                            </div>
                        @endif

                        @if($contractRequest->rejection_reason)
                            <div class="sm:col-span-2 space-y-1 bg-rose-50 p-4 rounded-2xl border border-rose-200">
                                <span class="text-rose-800 font-bold block">{{ $isEn ? 'Rejection Reason:' : 'سبب عدم قبول الطلب / الرفض:' }}</span>
                                <p class="text-rose-900 font-bold">{{ $contractRequest->rejection_reason }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Audit Trail & Review Metadata --}}
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-4">
                    <h3 class="font-black text-base text-primary border-b border-gray-100 pb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $isEn ? 'Review Timeline & Operations Log' : 'سجل التدقيق والمراجعة الزمني' }}</span>
                    </h3>

                    <div class="relative border-r-2 border-primary/20 {{ $isEn ? 'border-r-0 border-l-2 ml-3' : 'mr-3' }} space-y-5 pr-6 {{ $isEn ? 'pl-6 pr-0' : '' }}">
                        <div class="relative">
                            <span class="absolute -right-8 {{ $isEn ? '-left-8 right-auto' : '' }} top-0 w-4 h-4 rounded-full bg-primary ring-4 ring-primary/20"></span>
                            <div class="text-xs">
                                <strong class="text-primary font-black block text-sm">{{ $isEn ? 'Contract Request Submitted' : 'تم استلام طلب التعاقد' }}</strong>
                                <span class="text-gray-400 block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $contractRequest->created_at->format('Y-m-d H:i:s') }}</span>
                            </div>
                        </div>

                        @if($contractRequest->reviewed_at)
                            <div class="relative">
                                <span class="absolute -right-8 {{ $isEn ? '-left-8 right-auto' : '' }} top-0 w-4 h-4 rounded-full bg-amber-500 ring-4 ring-amber-100"></span>
                                <div class="text-xs">
                                    <strong class="text-amber-800 font-bold block">{{ $isEn ? 'Marked Under Review' : 'بدء مراجعة الطلب' }}</strong>
                                    <span class="text-gray-400 block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $contractRequest->reviewed_at }} • {{ $contractRequest->reviewedBy->name ?? 'Admin' }}</span>
                                </div>
                            </div>
                        @endif

                        @if($contractRequest->approved_at)
                            <div class="relative">
                                <span class="absolute -right-8 {{ $isEn ? '-left-8 right-auto' : '' }} top-0 w-4 h-4 rounded-full bg-emerald-600 ring-4 ring-emerald-100"></span>
                                <div class="text-xs">
                                    <strong class="text-emerald-800 font-bold block">{{ $isEn ? 'Approved' : 'تم الاعتماد والموافقة' }}</strong>
                                    <span class="text-gray-400 block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $contractRequest->approved_at }} • {{ $contractRequest->approvedBy->name ?? 'Admin' }}</span>
                                </div>
                            </div>
                        @endif

                        @foreach($auditLogs as $log)
                            <div class="relative">
                                <span class="absolute -right-8 {{ $isEn ? '-left-8 right-auto' : '' }} top-0 w-4 h-4 rounded-full bg-accent ring-4 ring-accent/20"></span>
                                <div class="text-xs space-y-0.5">
                                    <strong class="text-gray-800 font-bold block">{{ $log->action }}</strong>
                                    <p class="text-gray-600">{{ $log->old_values ?? $log->new_values }}</p>
                                    <span class="text-gray-400 block text-[10px] dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $log->created_at->format('Y-m-d H:i:s') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- Summary Sidebar Card --}}
            <div class="space-y-6">
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-5 sticky top-6">
                    <h3 class="font-black text-base text-primary border-b border-gray-100 pb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>{{ $isEn ? 'Conversion & Status Summary' : 'ملخص الحالة والتحويل' }}</span>
                    </h3>

                    @if($contractRequest->convertedCompany)
                        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-200 space-y-2">
                            <span class="text-xs font-bold text-emerald-800 block">{{ $isEn ? '✓ Converted to Company Account' : '✓ تم التحويل إلى شركة رسمية' }}</span>
                            <strong class="text-primary font-black block text-sm">{{ $contractRequest->convertedCompany->name }}</strong>
                            <span class="text-gray-500 text-[11px] block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $contractRequest->convertedCompany->company_code }}</span>
                            <a href="{{ route('admin.companies.show', $contractRequest->convertedCompany->id) }}" class="inline-block mt-2 px-4 py-2 bg-primary text-white text-xs font-bold rounded-xl shadow hover:bg-primary-hover transition-colors">
                                {{ $isEn ? 'Open Company File' : 'فتح ملف الشركة' }}
                            </a>
                        </div>
                    @elseif($contractRequest->status === 'approved')
                        <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200 space-y-2">
                            <span class="text-xs font-bold text-amber-800 block">{{ $isEn ? 'Ready for Conversion' : 'الطلب جاهز للتحويل لشركة' }}</span>
                            <p class="text-amber-900 text-xs font-medium">{{ $isEn ? 'Request approved. Click button above to generate company profile.' : 'الطلب معتمد ومكتمل. اضغط زر التحويل أعلاه لإنشاء ملف الشركة تلقائياً.' }}</p>
                        </div>
                    @else
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-200 space-y-2">
                            <span class="text-xs font-bold text-gray-700 block">{{ $isEn ? 'Current Status' : 'الحالة الحالية' }}</span>
                            <p class="text-gray-600 text-xs font-medium">{{ $isEn ? 'Transition request to Approved status before creating company.' : 'يجب اعتماد الطلب وقبوله أولاً للتمكن من تحويله لشركة بالنظام.' }}</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        {{-- REJECT MODAL DIALOG --}}
        <div x-show="showRejectModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div class="bg-white rounded-3xl max-w-md w-full p-6 space-y-5 shadow-2xl">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <h3 class="font-black text-base text-rose-700">{{ $isEn ? 'Reject Contract Request' : 'رفض طلب التعاقد' }}</h3>
                    <button @click="showRejectModal = false" class="text-gray-400 hover:text-gray-600 text-lg font-bold">✕</button>
                </div>

                <form action="{{ route('admin.contract-requests.status', $contractRequest->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="status" value="rejected">

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">{{ $isEn ? 'Rejection Reason *' : 'سبب رفض الطلب *' }}</label>
                        <textarea name="rejection_reason" required rows="4" placeholder="{{ $isEn ? 'Specify reason for rejection...' : 'اكتب سبب عدم قبول أو رفض طلب التعاقد...' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-rose-600"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" @click="showRejectModal = false" class="px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-100 rounded-xl">{{ $isEn ? 'Cancel' : 'إلغاء' }}</button>
                        <button type="submit" class="px-6 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow transition-colors border-0 cursor-pointer">
                            {{ $isEn ? 'Confirm Rejection' : 'تأكيد الرفض' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-admin-layout>
