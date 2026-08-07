@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Corporate Contract Requests' : 'طلبات التعاقد الواردة من الشركات' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Corporate Services Public Contract Requests Register' : 'سجل طلبات التعاقد الواردة من نموذج الخدمات الطبية' }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
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

        {{-- Header Summary --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="font-black text-lg text-primary flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>{{ $isEn ? 'Corporate Contract Requests' : 'سجل طلبات التعاقد الواردة' }} ({{ $contractRequests->total() }})</span>
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">{{ $isEn ? 'Review, approve, reject, and convert incoming corporate contract requests into companies' : 'مراجعة وقبول ورفض طلبات التعاقد وتحويل المقبول منها لحسابات شركات رسمية' }}</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.companies.index') }}" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition-all">
                    {{ $isEn ? 'Back to Companies' : 'سجل الشركات' }}
                </a>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="bg-white p-4 sm:p-5 rounded-3xl border border-gray-200 shadow-sm">
            <form action="{{ route('admin.contract-requests.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-5 gap-3">
                <div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $isEn ? 'Company Name, Contact, Email, CR...' : 'اسم الشركة، المسؤول، البريد، السجل...' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                </div>

                <div>
                    <select name="status" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                        <option value="">{{ $isEn ? 'All Workflow Statuses' : 'جميع الحالات' }}</option>
                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>{{ $isEn ? 'New' : 'جديد' }}</option>
                        <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>{{ $isEn ? 'Under Review' : 'قيد المراجعة' }}</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>{{ $isEn ? 'Approved' : 'معتمد (مقبول)' }}</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ $isEn ? 'Rejected' : 'مرفوض' }}</option>
                    </select>
                </div>

                <div>
                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                </div>

                <div>
                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="w-full bg-primary text-white py-2.5 rounded-xl font-black text-xs shadow hover:bg-primary-hover transition-colors">
                        {{ $isEn ? 'Filter' : 'تصفية' }}
                    </button>
                    @if(request()->anyFilled(['q', 'status', 'from_date', 'to_date']))
                        <a href="{{ route('admin.contract-requests.index') }}" class="px-3 py-2.5 bg-gray-100 text-gray-600 rounded-xl font-bold text-xs hover:bg-gray-200">✕</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Requests Table --}}
        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden p-6 space-y-4">
            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-700 font-extrabold border-b border-gray-200">
                            <th class="p-3.5">#ID</th>
                            <th class="p-3.5">{{ $isEn ? 'Company Name' : 'اسم الشركة / الجهة' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Contact Person & Phone' : 'مسؤول التواصل والجوال' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'City' : 'المدينة' }}</th>
                            <th class="p-3.5 text-center">{{ $isEn ? 'Beneficiaries' : 'المستفيدين المتوقعين' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Submitted At' : 'تاريخ التقديم' }}</th>
                            <th class="p-3.5">{{ $isEn ? 'Status' : 'الحالة' }}</th>
                            <th class="p-3.5 text-center">{{ $isEn ? 'Details & Actions' : 'التفاصيل والإجراء' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($contractRequests as $req)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-3.5 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">#REQ-{{ $req->id }}</td>
                                <td class="p-3.5">
                                    <strong class="text-gray-800 font-black block text-sm">{{ $req->company_name }}</strong>
                                    <span class="text-[10px] text-gray-400 block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">CR: {{ $req->cr_number ?? '-' }}</span>
                                </td>
                                <td class="p-3.5">
                                    <strong class="text-gray-800 font-bold block">{{ $req->contact_person }}</strong>
                                    <span class="text-[10px] text-gray-400 block dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $req->phone }} • {{ $req->email }}</span>
                                </td>
                                <td class="p-3.5 font-bold text-gray-600">{{ $req->city ?? '-' }}</td>
                                <td class="p-3.5 text-center font-black text-accent">{{ $req->expected_beneficiaries }}</td>
                                <td class="p-3.5 text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $req->created_at->format('Y-m-d H:i') }}</td>
                                <td class="p-3.5">
                                    @php
                                        $badges = [
                                            'new' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => $isEn ? 'New' : 'جديد'],
                                            'under_review' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'label' => $isEn ? 'Under Review' : 'قيد المراجعة'],
                                            'approved' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'label' => $isEn ? 'Approved' : 'مقبول'],
                                            'rejected' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'label' => $isEn ? 'Rejected' : 'مرفوض'],
                                        ];
                                        $badge = $badges[$req->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => $req->status];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black {{ $badge['bg'] }} {{ $badge['text'] }}">
                                        {{ $badge['label'] }}
                                    </span>
                                    @if($req->convertedCompany)
                                        <span class="block text-[9px] text-emerald-700 font-bold mt-1">✓ {{ $isEn ? 'Converted' : 'تم التحويل لشركة' }}</span>
                                    @endif
                                </td>
                                <td class="p-3.5 text-center">
                                    <a href="{{ route('admin.contract-requests.show', $req->id) }}" class="px-3 py-1.5 bg-[#006C35] text-white font-bold rounded-xl text-[11px] shadow hover:bg-[#00572B] transition-all inline-block">
                                        {{ $isEn ? 'Review & Convert' : 'المراجعة والتحويل' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No contract requests found matching criteria.' : 'لا توجد طلبات تعاقد تطابق معايير البحث.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pt-2">
                {{ $contractRequests->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>
