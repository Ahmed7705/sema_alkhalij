@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Add New Corporate Account' : 'تسجيل شركة جديدة' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Register New Corporate Client & Contract Entity' : 'إضافة وتسجيل شركة وجديدة بالمنظومة' }}</x-slot>

    <div class="max-w-3xl mx-auto space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
            <div class="border-b border-gray-100 pb-4 flex items-center justify-between">
                <div>
                    <h3 class="font-black text-lg text-primary">{{ $isEn ? 'Corporate Account Registration Details' : 'بيانات تسجيل الشركة والسجل التجاري' }}</h3>
                    <p class="text-xs text-gray-500">{{ $isEn ? 'Enter CR number, contact info, city, and operational status' : 'أدخل اسم الشركة، السجل التجاري، بيانات التواصل والمدينة والوضع الساري' }}</p>
                </div>
                <a href="{{ route('admin.companies.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-200 transition-colors">
                    {{ $isEn ? '← Back to Directory' : 'العودة للسجل ←' }}
                </a>
            </div>

            <form action="{{ route('admin.companies.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Company Name *' : 'اسم الشركة / الجهة المتعاقدة *' }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="{{ $isEn ? 'e.g. Aramco Health Solutions' : 'مثال: شركة أرامكو للتطوير الصحي' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                        @error('name') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Commercial Registration (CR) Number' : 'رقم السجل التجاري (CR)' }}</label>
                        <input type="text" name="cr_number" value="{{ old('cr_number') }}" placeholder="1010999888" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                        @error('cr_number') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Contact Person Name' : 'اسم مسؤول التواصل والمتابعة' }}</label>
                        <input type="text" name="contact_person" value="{{ old('contact_person') }}" placeholder="{{ $isEn ? 'e.g. Ahmed Al-Ghamdi' : 'مثال: أ. أحمد الغامدي (مدير الموارد البشرية)' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                        @error('contact_person') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Official Phone Number' : 'رقم جوال/هاتف الشركة' }}</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="0500000000" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                        @error('phone') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Corporate Email' : 'البريد الإلكتروني للشركة' }}</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="contact@company.com" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                        @error('email') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'City' : 'المدينة / الفرع الرئيسي' }}</label>
                        <input type="text" name="city" value="{{ old('city') }}" placeholder="{{ $isEn ? 'e.g. Riyadh' : 'الرياض، جدة، الدمام...' }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                        @error('city') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Company Account Status *' : 'حالة الحساب والتفعيل *' }}</label>
                        <select name="status" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>{{ $isEn ? 'Active' : 'نشط' }}</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ $isEn ? 'Inactive' : 'معطل' }}</option>
                            <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>{{ $isEn ? 'Suspended' : 'موقوف مؤقتاً' }}</option>
                        </select>
                        @error('status') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Full Headquarters Address' : 'العنوان التفصيلي وملاحظات التعاقد' }}</label>
                        <textarea name="address" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">{{ old('address') }}</textarea>
                        @error('address') <span class="text-rose-600 text-[11px] font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                    <a href="{{ route('admin.companies.index') }}" class="px-5 py-3 rounded-xl text-xs font-bold text-gray-500 hover:bg-gray-100">{{ $isEn ? 'Cancel' : 'إلغاء' }}</a>
                    <button type="submit" class="px-8 py-3 bg-[#006C35] hover:bg-[#00572B] text-white rounded-xl font-black text-xs shadow-lg transition-all border-0 cursor-pointer">
                        {{ $isEn ? 'Save & Create Company' : 'حفظ وتسجيل الشركة' }}
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-admin-layout>
