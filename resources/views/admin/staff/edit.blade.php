@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Edit Staff Member' : 'تعديل بيانات الموظف والممارس' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Edit Staff Profile & Credentials: ' . $staff->name : 'تعديل بيانات الحساب والترخيص المهني: ' . $staff->name }}</x-slot>

    <div class="max-w-3xl mx-auto space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
            <div class="border-b border-gray-100 pb-4 flex items-center justify-between">
                <div>
                    <h3 class="font-black text-lg text-primary">{{ $isEn ? 'Update Staff Member Information' : 'تحديث ملف الموظف والمعلومات' }}</h3>
                    <p class="text-xs text-gray-500">{{ $isEn ? 'Modify credentials, license number, and operational availability status' : 'تحديث رقم الترخيص، المسمى الوظيفي، وتعديل حالة الجاهزية والتفعيل' }}</p>
                </div>
                <a href="{{ route('admin.staff.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-200 transition-colors">
                    {{ $isEn ? '← Back to Directory' : 'العودة للسجل ←' }}
                </a>
            </div>

            <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Full Name *' : 'الاسم الكامل *' }}</label>
                        <input type="text" name="name" value="{{ old('name', $staff->name) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                        @error('name') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Email Address *' : 'البريد الإلكتروني *' }}</label>
                        <input type="email" name="email" value="{{ old('email', $staff->email) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                        @error('email') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Phone Number *' : 'رقم الجوال *' }}</label>
                        <input type="text" name="phone" value="{{ old('phone', $staff->phone) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                        @error('phone') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'New Password (Optional)' : 'كلمة مرور جديدة (اختياري)' }}</label>
                        <input type="password" name="password" placeholder="{{ $isEn ? 'Leave blank to keep unchanged' : 'اتركه فارغاً للإبقاء على الحالية' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary dir-ltr">
                        @error('password') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Staff Role / Function *' : 'الدور والمهنة التشغيلية *' }}</label>
                        <select name="role" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            <option value="doctor" {{ old('role', $staff->role) == 'doctor' ? 'selected' : '' }}>{{ $isEn ? 'Doctor' : 'طبيب' }}</option>
                            <option value="nurse" {{ old('role', $staff->role) == 'nurse' ? 'selected' : '' }}>{{ $isEn ? 'Nurse' : 'تمريض' }}</option>
                            <option value="physio" {{ old('role', $staff->role) == 'physio' ? 'selected' : '' }}>{{ $isEn ? 'Physiotherapist' : 'أخصائي علاج طبيعي' }}</option>
                            <option value="lab_tech" {{ old('role', $staff->role) == 'lab_tech' ? 'selected' : '' }}>{{ $isEn ? 'Lab Technician' : 'فني مختبر وسحب عينات' }}</option>
                            <option value="customer_service" {{ old('role', $staff->role) == 'customer_service' ? 'selected' : '' }}>{{ $isEn ? 'Customer Service / Ops' : 'خدمة عملاء ومشرف تشغيل' }}</option>
                            <option value="manager" {{ old('role', $staff->role) == 'manager' ? 'selected' : '' }}>{{ $isEn ? 'Operational Manager' : 'مدير تشغيلي' }}</option>
                        </select>
                        @error('role') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Medical Specialty' : 'التخصص الطبي الدقيق' }}</label>
                        <input type="text" name="specialty" value="{{ old('specialty', $staff->staffProfile->specialty ?? '') }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                        @error('specialty') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Professional License Number' : 'رقم الترخيص المهني' }}</label>
                        <input type="text" name="license_number" value="{{ old('license_number', $staff->staffProfile->license_number ?? '') }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                        @error('license_number') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Job Title' : 'المسمى الوظيفي' }}</label>
                        <input type="text" name="job_title" value="{{ old('job_title', $staff->staffProfile->job_title ?? '') }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                        @error('job_title') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Account Active Status *' : 'حالة تفعيل الحساب والإسناد *' }}</label>
                    <select name="is_active" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                        <option value="1" {{ old('is_active', $staff->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>{{ $isEn ? 'Active & Eligible for Visit Assignments' : 'نشط ومتاح لإسناد المهام والزيارات' }}</option>
                        <option value="0" {{ old('is_active', $staff->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>{{ $isEn ? 'Inactive (Cannot be Assigned Visits)' : 'معطل (محظور من إسناد المهام)' }}</option>
                    </select>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                    <a href="{{ route('admin.staff.index') }}" class="px-5 py-3 rounded-xl text-xs font-bold text-gray-500 hover:bg-gray-100">{{ $isEn ? 'Cancel' : 'إلغاء' }}</a>
                    <button type="submit" class="px-8 py-3 bg-[#006C35] hover:bg-[#00572B] text-white rounded-xl font-black text-xs shadow-lg transition-all border-0 cursor-pointer">
                        {{ $isEn ? 'Update Changes' : 'حفظ التعديلات' }}
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-admin-layout>
