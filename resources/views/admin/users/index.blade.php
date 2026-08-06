@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Users & Permissions Management (RBAC)' : 'إدارة المستخدمين والصلاحيات' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'User Accounts & RBAC Permissions Register' : 'إدارة سجل المستخدمين والصلاحيات RBAC' }}</x-slot>

    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-5 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
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

        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <div>
                <h3 class="font-black text-base text-primary">{{ $isEn ? 'Registered Users & System Roles' : 'المستخدمين والأدوار المسجلة للنظام' }} ({{ $users->total() }})</h3>
                <p class="text-xs text-gray-500">{{ $isEn ? 'Manage roles, permissions, toggle active accounts, or delete users' : 'تغيير الصلاحيات، تفعيل/تعطيل الحسابات، أو حذف المسجلين' }}</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }} border-collapse">
                <thead>
                    <tr class="bg-surface text-gray-700 font-bold border-b border-gray-200">
                        <th class="p-3">#</th>
                        <th class="p-3">{{ $isEn ? 'Username' : 'اسم المستخدم' }}</th>
                        <th class="p-3">{{ $isEn ? 'Email Address' : 'البريد الإلكتروني' }}</th>
                        <th class="p-3">{{ $isEn ? 'Phone' : 'الجوال' }}</th>
                        <th class="p-3">{{ $isEn ? 'Registration Date' : 'تاريخ التسجيل' }}</th>
                        <th class="p-3">{{ $isEn ? 'Role & Permission' : 'الدور والصلاحية' }}</th>
                        <th class="p-3">{{ $isEn ? 'Account Status' : 'حالة الحساب' }}</th>
                        <th class="p-3 text-center">{{ $isEn ? 'Actions' : 'الإجراءات' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-bold text-gray-400">{{ $u->id }}</td>
                            <td class="p-3 font-black text-primary">{{ $u->name }}</td>
                            <td class="p-3 font-bold text-gray-700 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $u->email }}</td>
                            <td class="p-3 font-bold text-gray-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $u->phone ?? '-' }}</td>
                            <td class="p-3 font-bold text-gray-500">{{ $u->created_at->format('Y/m/d') }}</td>
                            <td class="p-3">
                                <form action="{{ route('admin.users.role', $u->id) }}" method="POST">
                                    @csrf
                                    <select name="role" onchange="this.form.submit()" class="px-2 py-1 bg-gray-50 border border-gray-200 rounded-lg text-[11px] font-bold text-gray-800">
                                        <option value="customer" {{ $u->role === 'customer' ? 'selected' : '' }}>{{ $isEn ? 'Customer / Patient' : 'عميل / مريض' }}</option>
                                        <option value="doctor" {{ $u->role === 'doctor' ? 'selected' : '' }}>{{ $isEn ? 'Visiting Doctor' : 'طبيب زائر (Doctor)' }}</option>
                                        <option value="nurse" {{ $u->role === 'nurse' ? 'selected' : '' }}>{{ $isEn ? 'Home Nurse' : 'ممرض منزلي (Nurse)' }}</option>
                                        <option value="physio" {{ $u->role === 'physio' ? 'selected' : '' }}>{{ $isEn ? 'Physiotherapist' : 'أخصائي علاج طبيعي (Physio)' }}</option>
                                        <option value="lab_tech" {{ $u->role === 'lab_tech' ? 'selected' : '' }}>{{ $isEn ? 'Lab Technician' : 'فني مختبر وعينات (Lab Tech)' }}</option>
                                        <option value="customer_service" {{ $u->role === 'customer_service' ? 'selected' : '' }}>{{ $isEn ? 'Customer Support (CS)' : 'خدمة العملاء (CS)' }}</option>
                                        <option value="manager" {{ $u->role === 'manager' ? 'selected' : '' }}>{{ $isEn ? 'Operational Manager' : 'مدير تشغيلي (Manager)' }}</option>
                                        <option value="company_admin" {{ $u->role === 'company_admin' ? 'selected' : '' }}>{{ $isEn ? 'Company Admin' : 'مدير شركة متعاقدة (Company Admin)' }}</option>
                                        <option value="editor" {{ $u->role === 'editor' ? 'selected' : '' }}>{{ $isEn ? 'Content Editor' : 'محرر محتوى' }}</option>
                                        <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>{{ $isEn ? 'System Admin' : 'مدير نظام (Admin)' }}</option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-3">
                                <form action="{{ route('admin.users.toggle', $u->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $u->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $u->is_active ? ($isEn ? 'Active' : 'نشط') : ($isEn ? 'Disabled' : 'معطل') }}
                                    </button>
                                </form>
                            </td>
                            <td class="p-3">
                                <div class="flex items-center justify-center gap-2">
                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('{{ $isEn ? 'Are you sure you want to permanently delete this user account?' : 'هل أنت تأكد من رغبتك في حذف هذا الحساب نهائياً؟' }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors font-bold flex items-center gap-1 text-[11px]">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                <span>{{ $isEn ? 'Delete' : 'حذف' }}</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[10px] text-gray-400 font-bold">{{ $isEn ? 'Your Current Account' : 'حسابك الحالي' }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-2">
            {{ $users->links() }}
        </div>

    </div>
</x-admin-layout>
