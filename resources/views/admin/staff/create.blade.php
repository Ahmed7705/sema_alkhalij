@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Add New Staff Member' : 'إضافة ممارس طبي جديد' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Create New Medical Staff Profile' : 'تسجيل موظف وكادر طبي جديد بالنظام' }}</x-slot>

    <div class="max-w-3xl mx-auto space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
            <div class="border-b border-gray-100 pb-4 flex items-center justify-between">
                <div>
                    <h3 class="font-black text-lg text-primary">{{ $isEn ? 'Practitioner Account & Medical Profile Details' : 'بيانات الحساب الشخصي والملف المهني' }}</h3>
                    <p class="text-xs text-gray-500">{{ $isEn ? 'Fill in account credentials and medical license details' : 'أدخل بيانات تسجيل الدخول والمعلومات المهنية والتراخيص الصحية' }}</p>
                </div>
                <a href="{{ route('admin.staff.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-200 transition-colors">
                    {{ $isEn ? '← Back to Directory' : 'العودة للسجل ←' }}
                </a>
            </div>

            <form action="{{ route('admin.staff.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Full Name *' : 'الاسم الكامل *' }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                        @error('name') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Email Address *' : 'البريد الإلكتروني *' }}</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                        @error('email') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Phone Number *' : 'رقم الجوال *' }}</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                        @error('phone') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Account Password *' : 'كلمة المرور *' }}</label>
                        <input type="password" name="password" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary dir-ltr">
                        @error('password') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Staff Role / Function *' : 'الدور والمهنة التشغيلية *' }}</label>
                        <select name="role" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            <option value="doctor" {{ old('role') == 'doctor' ? 'selected' : '' }}>{{ $isEn ? 'Doctor' : 'طبيب' }}</option>
                            <option value="nurse" {{ old('role') == 'nurse' ? 'selected' : '' }}>{{ $isEn ? 'Nurse' : 'تمريض' }}</option>
                            <option value="physio" {{ old('role') == 'physio' ? 'selected' : '' }}>{{ $isEn ? 'Physiotherapist' : 'أخصائي علاج طبيعي' }}</option>
                            <option value="lab_tech" {{ old('role') == 'lab_tech' ? 'selected' : '' }}>{{ $isEn ? 'Lab Technician' : 'فني مختبر وسحب عينات' }}</option>
                            <option value="customer_service" {{ old('role') == 'customer_service' ? 'selected' : '' }}>{{ $isEn ? 'Customer Service / Ops' : 'خدمة عملاء ومشرف تشغيل' }}</option>
                            <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>{{ $isEn ? 'Operational Manager' : 'مدير تشغيلي' }}</option>
                        </select>
                        @error('role') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Medical Specialty' : 'التخصص الطبي الدقيق' }}</label>
                        <input type="text" name="specialty" value="{{ old('specialty') }}" placeholder="{{ $isEn ? 'e.g. Internal Medicine, ICU Nursing' : 'مثال: طب عام، تمريض عناية مركزة، علاج طبيعي عظام' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                        @error('specialty') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Professional License Number (SCFHS)' : 'رقم الترخيص المهني (الهيئة السعودية)' }}</label>
                        <input type="text" name="license_number" value="{{ old('license_number') }}" placeholder="{{ $isEn ? 'e.g. SCFHS-19-20984' : 'مثال: 19-20984-SCFHS' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                        @error('license_number') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Job Title' : 'المسمى الوظيفي الرسمية' }}</label>
                        <input type="text" name="job_title" value="{{ old('job_title') }}" placeholder="{{ $isEn ? 'e.g. Senior Home Care Specialist' : 'مثال: أخصائي رعاية منزلية أول' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                        @error('job_title') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Account Active Status *' : 'حالة تفعيل الحساب والإسناد *' }}</label>
                    <select name="is_active" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>{{ $isEn ? 'Active & Eligible for Visit Assignments' : 'نشط ومتاح لإسناد المهام والزيارات' }}</option>
                        <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>{{ $isEn ? 'Inactive (Cannot be Assigned Visits)' : 'معطل (محظور من إسناد المهام)' }}</option>
                    </select>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                    <a href="{{ route('admin.staff.index') }}" class="px-5 py-3 rounded-xl text-xs font-bold text-gray-500 hover:bg-gray-100">{{ $isEn ? 'Cancel' : 'إلغاء' }}</a>
                    <button type="submit" class="px-8 py-3 bg-[#006C35] hover:bg-[#00572B] text-white rounded-xl font-black text-xs shadow-lg transition-all border-0 cursor-pointer">
                        {{ $isEn ? 'Save & Register Staff Member' : 'حفظ وتسجيل الموظف' }}
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-admin-layout>
