@php
    $isEn = app()->getLocale() == 'en';
    $isAdmin = in_array(Auth::user()->role, ['admin', 'super_admin', 'manager']);
    $layoutName = $isAdmin ? 'admin-layout' : 'app-layout';
@endphp

<x-dynamic-component :component="$layoutName" title="{{ $isEn ? 'Medical Staff Portal & Operations' : 'بوابة العمليات والكادر الطبي' }}">
    @if($isAdmin)
        <x-slot name="headerTitle">{{ $isEn ? 'Medical Practitioner Operations Portal' : 'لوحة عمليات منفذي الخدمة الطبية' }}</x-slot>
    @endif

    <div class="space-y-8 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        {{-- Header Title --}}
        <div style="background: linear-gradient(135deg, #004823 0%, #006C35 50%, #00381B 100%) !important;" class="p-8 rounded-3xl text-white shadow-xl flex flex-col md:flex-row items-center justify-between gap-6 border border-white/10">
            <div>
                <h2 class="text-2xl font-black mb-1 text-white">{{ $isEn ? 'Medical Practitioner Operations Portal' : 'لوحة عمليات منفذي الخدمة الطبية' }}</h2>
                <p class="text-xs text-medical-200">{{ $isEn ? 'Manage assigned medical home visits, track patient status, and update execution pipeline' : 'إدارة الزيارات الطبية المسندة، متابعة الحالات، وتحديث مسار التنفيذ' }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-white/10 rounded-2xl text-xs font-bold border border-white/10 text-white">{{ $isEn ? 'Medical Staff:' : 'الكادر الطبي:' }} {{ Auth::user()->name }}</span>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                <span class="text-xs font-bold text-gray-500">{{ $isEn ? 'Assigned Today Visits' : 'زيارات اليوم المسندة' }}</span>
                <div class="text-3xl font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $todaysVisits }}</div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                <span class="text-xs font-bold text-amber-600">{{ $isEn ? 'Pending Acceptance' : 'في انتظار القبول' }}</span>
                <div class="text-3xl font-black text-amber-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $pendingAcceptance }}</div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                <span class="text-xs font-bold text-blue-600">{{ $isEn ? 'Visits In Progress' : 'زيارات جاري تنفيذها' }}</span>
                <div class="text-3xl font-black text-blue-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $inProgress }}</div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                <span class="text-xs font-bold text-emerald-600">{{ $isEn ? 'Completed Visits' : 'زيارات مكتملة التنفيذ' }}</span>
                <div class="text-3xl font-black text-emerald-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $completed }}</div>
            </div>
        </div>

        {{-- Assigned Visits Table --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-6">
            <h3 class="font-black text-lg text-primary border-b border-gray-100 pb-4">{{ $isEn ? 'Assigned Medical Visits Schedule' : 'جدول الزيارات المسندة للكادر' }}</h3>

            <div class="overflow-x-auto">
                <table class="w-full {{ $isEn ? 'text-left' : 'text-right' }} text-xs">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 font-extrabold">
                            <th class="p-4">{{ $isEn ? 'Booking #' : 'رقم الحجز' }}</th>
                            <th class="p-4">{{ $isEn ? 'Patient / Customer' : 'المريض / العميل' }}</th>
                            <th class="p-4">{{ $isEn ? 'Requested Service' : 'الخدمة المطلوبة' }}</th>
                            <th class="p-4">{{ $isEn ? 'Date & Time' : 'التاريخ والوقت' }}</th>
                            <th class="p-4">{{ $isEn ? 'City & Address' : 'العنوان والمدينة' }}</th>
                            <th class="p-4">{{ $isEn ? 'Operational Status' : 'الحالة التشغيلية' }}</th>
                            <th class="p-4 text-center">{{ $isEn ? 'Actions & Pipeline' : 'الإجراءات والتحكم' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($assignedVisits as $visit)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-4 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $visit->booking_number }}</td>
                                <td class="p-4 font-bold text-gray-800">{{ $visit->patient_name ?? ($visit->user->name ?? ($isEn ? 'Unassigned' : 'غير محدد')) }}</td>
                                <td class="p-4 font-bold text-accent">{{ $visit->service->title ?? ($isEn ? 'Home Visit' : 'خدمة منزلية') }}</td>
                                <td class="p-4 text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $visit->booking_date }} | {{ $visit->booking_time }}</td>
                                <td class="p-4 text-gray-500">{{ $visit->city }} - {{ $visit->address }}</td>
                                <td class="p-4">
                                    @if($visit->status === 'assigned')
                                        <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700">{{ $isEn ? 'Pending Acceptance' : 'بانتظار القبول' }}</span>
                                    @elseif($visit->status === 'accepted')
                                        <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700">{{ $isEn ? 'Accepted' : 'تم القبول' }}</span>
                                    @elseif($visit->status === 'in_progress')
                                        <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-purple-50 text-purple-700">{{ $isEn ? 'In Progress' : 'جاري التنفيذ' }}</span>
                                    @elseif($visit->status === 'completed')
                                        <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700">{{ $isEn ? 'Completed' : 'مكتملة' }}</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-gray-100 text-gray-700">{{ $visit->status }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <form action="{{ route('staff.visits.update-status', $visit->id) }}" method="POST" class="inline-flex items-center gap-2">
                                        @csrf
                                        @if($visit->status === 'assigned')
                                            <button type="submit" name="status" value="accepted" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow">{{ $isEn ? 'Accept Visit' : 'قبول الزيارة' }}</button>
                                        @elseif($visit->status === 'accepted')
                                            <button type="submit" name="status" value="in_progress" class="px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-bold shadow">{{ $isEn ? 'Start Visit' : 'بدء الزيارة' }}</button>
                                        @elseif($visit->status === 'in_progress')
                                            <button type="submit" name="status" value="completed" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold shadow">{{ $isEn ? 'Complete Service' : 'إكمال الخدمة' }}</button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No medical visits currently assigned to you.' : 'لا توجد زيارات طبية مسندة إليك حالياً.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $assignedVisits->links() }}
            </div>
        </div>

    </div>
</x-dynamic-component>
