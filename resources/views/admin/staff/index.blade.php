@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Medical Staff Management' : 'إدارة الكادر الطبي والتشغيلي' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Medical Staff & Practitioners Directory' : 'سجل وإدارة الكادر الطبي والمنفذين' }}</x-slot>

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

        {{-- Top Action & Filter Header --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="font-black text-lg text-primary flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>{{ $isEn ? 'Medical Staff Members' : 'أفراد الكادر الطبي' }} ({{ $staffMembers->total() }})</span>
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">{{ $isEn ? 'Manage doctors, nurses, physiotherapists, lab techs, and operational managers' : 'إدارة الأطباء، التمريض، أخصائي العلاج الطبيعي، فنيي المختبر والمشرفين' }}</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.staff.create') }}" class="bg-[#006C35] hover:bg-[#00572B] text-white px-5 py-3 rounded-2xl font-black text-xs shadow-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    <span>{{ $isEn ? 'Add New Staff Practitioner' : 'إضافة ممارس طبي جديد' }}</span>
                </a>
            </div>
        </div>

        {{-- Filters Bar --}}
        <div class="bg-white p-4 sm:p-5 rounded-3xl border border-gray-200 shadow-sm">
            <form action="{{ route('admin.staff.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $isEn ? 'Search name, license #, phone...' : 'بحث بالاسم، رقم الترخيص، الجوال...' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                </div>

                <div>
                    <select name="role" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                        <option value="">{{ $isEn ? 'All Staff Roles' : 'جميع التخصصات والأدوار' }}</option>
                        <option value="doctor" {{ request('role') == 'doctor' ? 'selected' : '' }}>{{ $isEn ? 'Doctor' : 'طبيب' }}</option>
                        <option value="nurse" {{ request('role') == 'nurse' ? 'selected' : '' }}>{{ $isEn ? 'Nurse' : 'تمريض' }}</option>
                        <option value="physio" {{ request('role') == 'physio' ? 'selected' : '' }}>{{ $isEn ? 'Physiotherapist' : 'علاج طبيعي' }}</option>
                        <option value="lab_tech" {{ request('role') == 'lab_tech' ? 'selected' : '' }}>{{ $isEn ? 'Lab Technician' : 'فني مختبر' }}</option>
                        <option value="customer_service" {{ request('role') == 'customer_service' ? 'selected' : '' }}>{{ $isEn ? 'Customer Service / Ops' : 'خدمة عملاء وتشغيل' }}</option>
                        <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>{{ $isEn ? 'Operational Manager' : 'مدير تشغيلي' }}</option>
                    </select>
                </div>

                <div>
                    <select name="is_active" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold focus:outline-none focus:border-primary">
                        <option value="">{{ $isEn ? 'All Account Statuses' : 'جميع حالات الحساب' }}</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>{{ $isEn ? 'Active Only' : 'نشط فقط' }}</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>{{ $isEn ? 'Inactive Only' : 'معطل فقط' }}</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="w-full bg-primary text-white py-2.5 rounded-xl font-black text-xs shadow hover:bg-primary-hover transition-colors">
                        {{ $isEn ? 'Filter Results' : 'تصفية النتائج' }}
                    </button>
                    @if(request()->anyFilled(['q', 'role', 'is_active']))
                        <a href="{{ route('admin.staff.index') }}" class="px-3 py-2.5 bg-gray-100 text-gray-600 rounded-xl font-bold text-xs hover:bg-gray-200">✕</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Staff Directory Table --}}
        <div class="bg-white rounded-3xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }}">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-700 font-extrabold">
                            <th class="p-4">#</th>
                            <th class="p-4">{{ $isEn ? 'Staff Practitioner' : 'الممارس الطبي' }}</th>
                            <th class="p-4">{{ $isEn ? 'Role / Category' : 'الدور / التصنيف' }}</th>
                            <th class="p-4">{{ $isEn ? 'Specialty & Job Title' : 'التخصص والمسمى الوظيفي' }}</th>
                            <th class="p-4">{{ $isEn ? 'License Number' : 'رقم الترخيص المهني' }}</th>
                            <th class="p-4">{{ $isEn ? 'Status' : 'الحالة' }}</th>
                            <th class="p-4 text-center">{{ $isEn ? 'Actions' : 'الإجراءات والتحكم' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($staffMembers as $staff)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="p-4 font-bold text-gray-400">{{ $staff->id }}</td>
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-2xl bg-primary/10 text-primary font-black flex items-center justify-center text-sm shrink-0">
                                            {{ mb_substr($staff->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <strong class="text-primary font-black block text-sm">{{ $staff->name }}</strong>
                                            <span class="text-gray-500 text-[11px] dir-ltr block {{ $isEn ? 'text-left' : 'text-right' }}">{{ $staff->email }} • {{ $staff->phone }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 font-bold">
                                    @php
                                        $roleLabels = [
                                            'doctor' => $isEn ? 'Doctor' : 'طبيب',
                                            'nurse' => $isEn ? 'Nurse' : 'تمريض',
                                            'physio' => $isEn ? 'Physiotherapist' : 'علاج طبيعي',
                                            'lab_tech' => $isEn ? 'Lab Tech' : 'فني مختبر',
                                            'customer_service' => $isEn ? 'Ops / Support' : 'خدمة عملاء وتشغيل',
                                            'manager' => $isEn ? 'Manager' : 'مدير تشغيلي',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black bg-primary/10 text-primary">
                                        {{ $roleLabels[$staff->role] ?? $staff->role }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <strong class="text-gray-800 font-bold block">{{ $staff->staffProfile->specialty ?? ($isEn ? 'General Medical' : 'طب عام ورعاية') }}</strong>
                                    <span class="text-gray-400 text-[10px] block">{{ $staff->staffProfile->job_title ?? '-' }}</span>
                                </td>
                                <td class="p-4 font-bold text-gray-700 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                                    {{ $staff->staffProfile->license_number ?? ($isEn ? 'Pending' : 'قيد التدقيق') }}
                                </td>
                                <td class="p-4">
                                    @if($staff->is_active && ($staff->staffProfile->is_active ?? true))
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            {{ $isEn ? '● Active' : '● نشط ومتاح' }}
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200">
                                            {{ $isEn ? '○ Inactive' : '○ معطل' }}
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.staff.show', $staff->id) }}" title="{{ $isEn ? 'View Details' : 'عرض التفاصيل' }}" class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>

                                        <a href="{{ route('admin.staff.edit', $staff->id) }}" title="{{ $isEn ? 'Edit Member' : 'تعديل البيانات' }}" class="p-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>

                                        <form action="{{ route('admin.staff.toggle', $staff->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" onclick="return confirm('{{ $isEn ? 'Change staff account status?' : 'هل أنت تأكد من تغيير حالة حساب هذا الموظف؟' }}')" title="{{ $staff->is_active ? ($isEn ? 'Deactivate' : 'تعطيل الحساب') : ($isEn ? 'Activate' : 'تنشيط الحساب') }}" class="p-2 rounded-xl {{ $staff->is_active ? 'bg-amber-50 hover:bg-amber-100 text-amber-700' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-700' }} font-bold cursor-pointer border-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-gray-400 font-bold">{{ $isEn ? 'No staff members found matching criteria.' : 'لا يوجد أفراد كادر طبي يطابقون خيارات البحث.' }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-gray-100">
                {{ $staffMembers->links() }}
            </div>
        </div>

    </div>
</x-admin-layout>
