@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Staff Member Details' : 'تفاصيل الممارس الطبي' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Staff Profile & Assigned Visits History: ' . $staff->name : 'تفاصيل ملف الكادر وتاريخ الزيارات المسندة: ' . $staff->name }}</x-slot>

    <div class="space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        {{-- Top Summary Card --}}
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-3xl bg-primary/10 text-primary font-black flex items-center justify-center text-2xl shrink-0">
                    {{ mb_substr($staff->name, 0, 1) }}
                </div>
                <div class="space-y-1">
                    <div class="flex items-center gap-3">
                        <h2 class="text-2xl font-black text-primary">{{ $staff->name }}</h2>
                        @if($staff->is_active && ($staff->staffProfile->is_active ?? true))
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-full border border-emerald-200">{{ $isEn ? '● Active' : '● نشط ومتاح' }}</span>
                        @else
                            <span class="px-3 py-1 bg-rose-50 text-rose-700 font-bold text-xs rounded-full border border-rose-200">{{ $isEn ? '○ Inactive' : '○ معطل' }}</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500">
                        {{ $isEn ? 'Role:' : 'الدور:' }} <strong class="text-gray-800">{{ $staff->role }}</strong> | 
                        {{ $isEn ? 'Specialty:' : 'التخصص:' }} <strong class="text-gray-800">{{ $staff->staffProfile->specialty ?? '-' }}</strong> | 
                        {{ $isEn ? 'License #:' : 'الترخيص:' }} <strong class="text-gray-800 dir-ltr">{{ $staff->staffProfile->license_number ?? '-' }}</strong>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.staff.edit', $staff->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow transition-all">
                    {{ $isEn ? 'Edit Profile' : 'تعديل البيانات' }}
                </a>
                <a href="{{ route('admin.staff.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl font-bold text-xs transition-all">
                    {{ $isEn ? 'Back to List' : 'عودة للقائمة' }}
                </a>
            </div>
        </div>

        {{-- Assigned Visits Table --}}
        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-6 sm:p-8 space-y-6">
            <h3 class="font-black text-lg text-primary border-b border-gray-100 pb-3">{{ $isEn ? 'Assigned Medical Home Visits' : 'سجل الزيارات الطبية المنزلية المسندة' }} ({{ $assignedVisits->total() }})</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }}">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-700 font-extrabold">
                            <th class="p-4">{{ $isEn ? 'Booking #' : 'رقم الحجز' }}</th>
                            <th class="p-4">{{ $isEn ? 'Patient' : 'المريض / العميل' }}</th>
                            <th class="p-4">{{ $isEn ? 'Service' : 'الخدمة الطبية' }}</th>
                            <th class="p-4">{{ $isEn ? 'Date & Time' : 'تاريخ الموعد' }}</th>
                            <th class="p-4">{{ $isEn ? 'City' : 'المدينة' }}</th>
                            <th class="p-4">{{ $isEn ? 'Status' : 'الحالة التشغيلية' }}</th>
                            <th class="p-4 text-center">{{ $isEn ? 'Action' : 'التفاصيل' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($assignedVisits as $visit)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-4 font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $visit->booking_number }}</td>
                                <td class="p-4 font-bold text-gray-800">{{ $visit->patient_name ?? ($visit->user->name ?? '-') }}</td>
                                <td class="p-4 font-bold text-accent">{{ $visit->service->title ?? '-' }}</td>
                                <td class="p-4 text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $visit->booking_date }} | {{ $visit->booking_time }}</td>
                                <td class="p-4 font-bold text-gray-600">{{ $visit->city }}</td>
                                <td class="p-4">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-primary/10 text-primary">{{ $visit->status }}</span>
                                </td>
                                <td class="p-4 text-center">
                                    <a href="{{ route('admin.bookings.show', $visit->id) }}" class="text-accent font-bold hover:underline text-xs">{{ $isEn ? 'View Visit' : 'معاينة' }}</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No visits currently assigned to this practitioner.' : 'لا توجد زيارات مسندة لهذا الممارس حالياً.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pt-4">
                {{ $assignedVisits->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>
