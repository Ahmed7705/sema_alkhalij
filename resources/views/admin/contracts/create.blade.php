@php
    $isEn = app()->getLocale() == 'en';
@endphp

<x-admin-layout title="{{ $isEn ? 'Create Corporate Contract' : 'إنشاء عقد اتفاقية شركة جديدة' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'New Corporate Contract Setup' : 'إعداد وإنشاء عقد جديد لشركة متعاقدة' }}</x-slot>

    <div class="max-w-3xl mx-auto space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        {{-- Flash errors --}}
        @if(session('error'))
            <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold rounded-2xl">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
            <div class="border-b border-gray-100 pb-4">
                <h3 class="text-lg font-black text-primary">{{ $isEn ? 'Contract Details & Terms' : 'بيانات وشروط الاتفاقية التعاقدية' }}</h3>
                <p class="text-xs text-gray-500 mt-1">{{ $isEn ? 'Fill in contract terms, company association, and duration dates.' : 'أدخل بيانات وشروط العقد والشركة المرتبطة وفترة الصلاحية.' }}</p>
            </div>

            <form action="{{ route('admin.contracts.store') }}" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Contracted Company *' : 'الشركة المتعاقدة *' }}</label>
                        <select name="company_id" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            <option value="">{{ $isEn ? 'Select Company' : 'اختر الشركة...' }}</option>
                            @foreach($companies as $comp)
                                <option value="{{ $comp->id }}" {{ old('company_id') == $comp->id ? 'selected' : '' }}>{{ $comp->name }} (CR: {{ $comp->cr_number ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Contract Number (Optional - Auto Generated if blank)' : 'رقم العقد (اختياري - يولد تلقائياً)' }}</label>
                        <input type="text" name="contract_number" value="{{ old('contract_number') }}" placeholder="e.g. CNT-2026-1005" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Start Date *' : 'تاريخ بداية العقد *' }}</label>
                        <input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'End Date *' : 'تاريخ نهاية العقد *' }}</label>
                        <input type="date" name="end_date" value="{{ old('end_date', date('Y-12-31')) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Payment Terms *' : 'شروط الدفع والتسوية *' }}</label>
                        <select name="payment_terms" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            <option value="Immediate (دفع فوري)" {{ old('payment_terms') == 'Immediate (دفع فوري)' ? 'selected' : '' }}>Immediate (دفع فوري)</option>
                            <option value="Net 30 Days (آجل 30 يوم)" {{ old('payment_terms', 'Net 30 Days (آجل 30 يوم)') == 'Net 30 Days (آجل 30 يوم)' ? 'selected' : '' }}>Net 30 Days (آجل 30 يوم)</option>
                            <option value="Net 60 Days (آجل 60 يوم)" {{ old('payment_terms') == 'Net 60 Days (آجل 60 يوم)' ? 'selected' : '' }}>Net 60 Days (آجل 60 يوم)</option>
                            <option value="Monthly Invoice (فاتورة شهرية)" {{ old('payment_terms') == 'Monthly Invoice (فاتورة شهرية)' ? 'selected' : '' }}>Monthly Invoice (فاتورة شهرية)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Contract Status *' : 'حالة العقد *' }}</label>
                        <select name="status" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>{{ $isEn ? 'Active' : 'نشط' }}</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{ $isEn ? 'Pending Review' : 'قيد التدقيق' }}</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>{{ $isEn ? 'Draft' : 'مسودة' }}</option>
                            <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>{{ $isEn ? 'Suspended' : 'موقوف مؤقتاً' }}</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Discount Percentage Override (%)' : 'نسبة الخصم التعاقدي المباشر (%)' }}</label>
                    <input type="number" step="0.01" min="0" max="100" name="discount_percentage" value="{{ old('discount_percentage', 0) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Notes & Terms' : 'ملاحظات وشروط إضافية' }}</label>
                    <textarea name="notes" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">{{ old('notes') }}</textarea>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                    <a href="{{ route('admin.contracts.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-xs transition-all">
                        {{ $isEn ? 'Cancel' : 'إلغاء' }}
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-hover text-white font-extrabold rounded-xl text-xs shadow transition-all">
                        {{ $isEn ? 'Save & Set Services Pricing' : 'حفظ والانتقال لتسعير الخدمات' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
