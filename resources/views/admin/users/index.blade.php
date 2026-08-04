<x-admin-layout title="إدارة المستخدمين والصلاحيات">
    <x-slot name="headerTitle">إدارة سجل المستخدمين والصلاحيات RBAC</x-slot>

    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-5 text-right">
        
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
                <h3 class="font-black text-base text-primary">المستخدمين والأدوار المسجلة للنظام ({{ $users->total() }})</h3>
                <p class="text-xs text-gray-500">تغيير الصلاحيات، تفعيل/تعطيل الحسابات، أو حذف المسجلين</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-right border-collapse">
                <thead>
                    <tr class="bg-surface text-gray-700 font-bold border-b border-gray-200">
                        <th class="p-3">#</th>
                        <th class="p-3">اسم المستخدم</th>
                        <th class="p-3">البريد الإلكتروني</th>
                        <th class="p-3">الجوال</th>
                        <th class="p-3">تاريخ التسجيل</th>
                        <th class="p-3">الدور والصلاحية</th>
                        <th class="p-3">حالة الحساب</th>
                        <th class="p-3 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-bold text-gray-400">{{ $u->id }}</td>
                            <td class="p-3 font-black text-primary">{{ $u->name }}</td>
                            <td class="p-3 font-bold text-gray-700 dir-ltr text-right">{{ $u->email }}</td>
                            <td class="p-3 font-bold text-gray-600 dir-ltr text-right">{{ $u->phone ?? '-' }}</td>
                            <td class="p-3 font-bold text-gray-500">{{ $u->created_at->format('Y/m/d') }}</td>
                            <td class="p-3">
                                <form action="{{ route('admin.users.role', $u->id) }}" method="POST">
                                    @csrf
                                    <select name="role" onchange="this.form.submit()" class="px-2 py-1 bg-gray-50 border border-gray-200 rounded-lg text-[11px] font-bold text-gray-800">
                                        <option value="customer" {{ $u->role === 'customer' ? 'selected' : '' }}>عميل / مريض</option>
                                        <option value="doctor" {{ $u->role === 'doctor' ? 'selected' : '' }}>طبيب زائر (Doctor)</option>
                                        <option value="nurse" {{ $u->role === 'nurse' ? 'selected' : '' }}>ممرض منزلي (Nurse)</option>
                                        <option value="physio" {{ $u->role === 'physio' ? 'selected' : '' }}>أخصائي علاج طبيعي (Physio)</option>
                                        <option value="lab_tech" {{ $u->role === 'lab_tech' ? 'selected' : '' }}>فني مختبر وعينات (Lab Tech)</option>
                                        <option value="customer_service" {{ $u->role === 'customer_service' ? 'selected' : '' }}>خدمة العملاء (CS)</option>
                                        <option value="manager" {{ $u->role === 'manager' ? 'selected' : '' }}>مدير تشغيلي (Manager)</option>
                                        <option value="company_admin" {{ $u->role === 'company_admin' ? 'selected' : '' }}>مدير شركة متعاقدة (Company Admin)</option>
                                        <option value="editor" {{ $u->role === 'editor' ? 'selected' : '' }}>محرر محتوى</option>
                                        <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>مدير نظام (Admin)</option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-3">
                                <form action="{{ route('admin.users.toggle', $u->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $u->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $u->is_active ? 'نشط' : 'معطل' }}
                                    </button>
                                </form>
                            </td>
                            <td class="p-3">
                                <div class="flex items-center justify-center gap-2">
                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('هل أنت تأكد من رغبتك في حذف هذا الحساب نهائياً؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors font-bold flex items-center gap-1 text-[11px]">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                <span>حذف</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[10px] text-gray-400 font-bold">حسابك الحالي</span>
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
