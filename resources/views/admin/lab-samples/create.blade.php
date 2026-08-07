@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Register Lab Sample' : 'تسجيل عينة مختبر جديدة' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'New Laboratory Sample Registration' : 'تسجيل وتوثيق عينة فحص طبية جديدة' }}</x-slot>

    <div class="max-w-4xl mx-auto space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        <div class="flex items-center justify-between">
            <div>
                <h3 class="font-black text-lg text-primary">{{ $isEn ? 'Sample Registration Form' : 'نموذج تسجيل العينات المختبرية' }}</h3>
                <p class="text-xs text-gray-500">{{ $isEn ? 'Select patient, booking reference, company, and assign lab technician' : 'اختر المريض والمرجع وتعيين الفني المختص بالمختبر' }}</p>
            </div>
            <a href="{{ route('admin.lab-samples.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-xl text-xs font-bold hover:bg-gray-200 transition-colors">
                {{ $isEn ? 'Back to Samples List' : 'العودة لسجل العينات' }}
            </a>
        </div>

        <form method="POST" action="{{ route('admin.lab-samples.store') }}" class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Patient --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">
                        {{ $isEn ? 'Patient' : 'المريض صاحب العينة' }} <span class="text-red-500">*</span>
                    </label>
                    <select name="patient_id" required class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-1 focus:ring-primary">
                        <option value="">{{ $isEn ? '-- Select Patient --' : '-- اختر المريض --' }}</option>
                        @foreach($patients as $p)
                        <option value="{{ $p->id }}" {{ old('patient_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->name }} ({{ $p->phone ?? $p->identification_number ?? $p->email }})
                        </option>
                        @endforeach
                    </select>
                    @error('patient_id') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                </div>

                {{-- Booking (Optional) --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">
                        {{ $isEn ? 'Associated Booking (Optional)' : 'الحجز المرتبط (اختياري)' }}
                    </label>
                    <select name="booking_id" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-1 focus:ring-primary">
                        <option value="">{{ $isEn ? '-- Direct Sample (No Booking) --' : '-- عينة مباشرة (بدون حجز سابق) --' }}</option>
                        @foreach($bookings as $b)
                        <option value="{{ $b->id }}" {{ old('booking_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->booking_number }} - {{ $b->user->name ?? 'N/A' }} ({{ $b->service->title_ar ?? $b->service->title ?? 'خدمة' }})
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Company (Optional) --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">
                        {{ $isEn ? 'Corporate Client (Optional)' : 'الشركة التابع لها العميل (اختياري)' }}
                    </label>
                    <select name="company_id" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-1 focus:ring-primary">
                        <option value="">{{ $isEn ? '-- Individual Patient --' : '-- عميل أفراد (مستقل) --' }}</option>
                        @foreach($companies as $c)
                        <option value="{{ $c->id }}" {{ old('company_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->name }} ({{ $c->company_code }})
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Assigned Lab Staff --}}
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">
                        {{ $isEn ? 'Assign Lab Technician' : 'إسناد لفني المختبر' }}
                    </label>
                    <select name="assigned_staff_id" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-1 focus:ring-primary">
                        <option value="">{{ $isEn ? '-- Unassigned (Assign Later) --' : '-- غير مسند حالياً (إسناد لاحقاً) --' }}</option>
                        @foreach($labTechs as $t)
                        <option value="{{ $t->id }}" {{ old('assigned_staff_id') == $t->id ? 'selected' : '' }}>
                            {{ $t->name }} ({{ $t->email }})
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">
                    {{ $isEn ? 'Sample Notes / Medical Instructions' : 'ملاحظات العينة / تعليمات المختبر' }}
                </label>
                <textarea name="notes" rows="3" placeholder="{{ $isEn ? 'Enter sample collection requirements or notes...' : 'أدخل شروط الفحص أو ملاحظات تجميع العينة...' }}" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-xs focus:ring-1 focus:ring-primary">{{ old('notes') }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-4">
                <a href="{{ route('admin.lab-samples.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl text-xs font-bold hover:bg-gray-200">
                    {{ $isEn ? 'Cancel' : 'إلغاء' }}
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-hover text-white rounded-xl text-xs font-bold transition-colors">
                    {{ $isEn ? 'Save & Register Sample' : 'حفظ وتأكيد تسجيل العينة' }}
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
