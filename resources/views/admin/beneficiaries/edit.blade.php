@php
    $isEn = app()->getLocale() == 'en';
@endphp

<x-admin-layout title="{{ $isEn ? 'Edit Beneficiary' : 'تعديل بيانات المستفيد' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Edit Beneficiary Details' : 'تعديل وتحديث بيانات المستفيد' }}</x-slot>

    <div class="max-w-2xl mx-auto space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        <div class="bg-white p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
            <div class="border-b border-gray-100 pb-4">
                <h3 class="text-lg font-black text-primary">{{ $isEn ? 'Edit Beneficiary' : 'تعديل بيانات' }}: {{ $beneficiary->name }}</h3>
            </div>

            <form action="{{ route('admin.beneficiaries.update', $beneficiary->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Company *' : 'الشركة *' }}</label>
                        <select name="company_id" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            @foreach($companies as $comp)
                                <option value="{{ $comp->id }}" {{ old('company_id', $beneficiary->company_id) == $comp->id ? 'selected' : '' }}>{{ $comp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Contract *' : 'العقد *' }}</label>
                        <select name="contract_id" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            @foreach($contracts as $cnt)
                                <option value="{{ $cnt->id }}" {{ old('contract_id', $beneficiary->contract_id) == $cnt->id ? 'selected' : '' }}>{{ $cnt->contract_number }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Full Name *' : 'اسم المستفيد *' }}</label>
                        <input type="text" name="name" value="{{ old('name', $beneficiary->name) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Identification Type *' : 'نوع الهوية *' }}</label>
                        <select name="identification_type" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            <option value="saudi_id" {{ old('identification_type', $beneficiary->identification_type) == 'saudi_id' ? 'selected' : '' }}>هوية وطنية سعودية (Saudi ID)</option>
                            <option value="iqama" {{ old('identification_type', $beneficiary->identification_type) == 'iqama' ? 'selected' : '' }}>إقامة مقيم (Iqama)</option>
                            <option value="border_number" {{ old('identification_type', $beneficiary->identification_type) == 'border_number' ? 'selected' : '' }}>رقم الحدود (Border Number)</option>
                            <option value="gcc_id" {{ old('identification_type', $beneficiary->identification_type) == 'gcc_id' ? 'selected' : '' }}>هوية مواطن خليجي (GCC ID)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Identification Number *' : 'رقم الهوية / الإقامة *' }}</label>
                        <input type="text" name="identification_number" value="{{ old('identification_number', $beneficiary->identification_number) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Employee ID Number' : 'الرقم الوظيفي' }}</label>
                        <input type="text" name="employee_id_number" value="{{ old('employee_id_number', $beneficiary->employee_id_number) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Phone Number' : 'رقم الجوال' }}</label>
                        <input type="text" name="phone" value="{{ old('phone', $beneficiary->phone) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Status *' : 'حالة المستفيد *' }}</label>
                        <select name="status" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            <option value="active" {{ old('status', $beneficiary->status) == 'active' ? 'selected' : '' }}>{{ $isEn ? 'Active' : 'نشط' }}</option>
                            <option value="inactive" {{ old('status', $beneficiary->status) == 'inactive' ? 'selected' : '' }}>{{ $isEn ? 'Inactive' : 'معطل' }}</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                    <a href="{{ route('admin.beneficiaries.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-xs transition-all">
                        {{ $isEn ? 'Cancel' : 'إلغاء' }}
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-hover text-white font-extrabold rounded-xl text-xs shadow transition-all">
                        {{ $isEn ? 'Update Beneficiary' : 'تحديث المستفيد' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
