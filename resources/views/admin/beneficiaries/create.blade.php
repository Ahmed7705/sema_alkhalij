@php
    $isEn = app()->getLocale() == 'en';
@endphp

<x-admin-layout title="{{ $isEn ? 'Add Beneficiary' : 'إضافة مستفيد جديد' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Enroll Corporate Beneficiary' : 'إضافة وتسجيل مستفيد جديد تحت عقد شركة' }}</x-slot>

    <div class="max-w-2xl mx-auto space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold rounded-2xl">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
            <div class="border-b border-gray-100 pb-4">
                <h3 class="text-lg font-black text-primary">{{ $isEn ? 'Beneficiary Information' : 'بيانات المستفيد والهوية' }}</h3>
                <p class="text-xs text-gray-500 mt-1">{{ $isEn ? 'System automatically searches for existing patient accounts matching identification number.' : 'سيقوم النظام تلقائياً بالبحث عن أي حساب مريض مسجل مسبقاً بنفس رقم الهوية لربطه به دون تكرار.' }}</p>
            </div>

            <form action="{{ route('admin.beneficiaries.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Company *' : 'الشركة *' }}</label>
                        <select name="company_id" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            @foreach($companies as $comp)
                                <option value="{{ $comp->id }}" {{ old('company_id', $selectedCompanyId) == $comp->id ? 'selected' : '' }}>{{ $comp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Contract *' : 'العقد النشط *' }}</label>
                        <select name="contract_id" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            @foreach($contracts as $cnt)
                                <option value="{{ $cnt->id }}" {{ old('contract_id') == $cnt->id ? 'selected' : '' }}>{{ $cnt->contract_number }} ({{ $cnt->status }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Full Name *' : 'اسم المستفيد بالكامل *' }}</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="أدخل اسم المستفيد رباعي" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Identification Type *' : 'نوع الهوية *' }}</label>
                        <select name="identification_type" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            <option value="saudi_id" {{ old('identification_type') == 'saudi_id' ? 'selected' : '' }}>هوية وطنية سعودية (Saudi ID)</option>
                            <option value="iqama" {{ old('identification_type') == 'iqama' ? 'selected' : '' }}>إقامة مقيم (Iqama)</option>
                            <option value="border_number" {{ old('identification_type') == 'border_number' ? 'selected' : '' }}>رقم الحدود (Border Number)</option>
                            <option value="gcc_id" {{ old('identification_type') == 'gcc_id' ? 'selected' : '' }}>هوية مواطن خليجي (GCC ID)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Identification Number *' : 'رقم الهوية / الإقامة *' }}</label>
                        <input type="text" name="identification_number" value="{{ old('identification_number') }}" required placeholder="10XXXXXXX" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Employee ID Number (Optional)' : 'الرقم الوظيفي (اختياري)' }}</label>
                        <input type="text" name="employee_id_number" value="{{ old('employee_id_number') }}" placeholder="EMP-9081" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Phone Number (Optional)' : 'رقم الجوال (اختياري)' }}</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="05XXXXXXXX" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Status *' : 'حالة المستفيد *' }}</label>
                        <select name="status" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>{{ $isEn ? 'Active' : 'نشط ومستحق' }}</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>{{ $isEn ? 'Inactive' : 'معطل' }}</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                    <a href="{{ route('admin.beneficiaries.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-xs transition-all">
                        {{ $isEn ? 'Cancel' : 'إلغاء' }}
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-hover text-white font-extrabold rounded-xl text-xs shadow transition-all">
                        {{ $isEn ? 'Save & Auto Link' : 'حفظ المستفيد والربط التلقائي' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
