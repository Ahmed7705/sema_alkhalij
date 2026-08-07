@php
    $isEn = app()->getLocale() == 'en';
@endphp

<x-admin-layout title="{{ $isEn ? 'Edit Contract' : 'تعديل بيانات العقد' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Edit Contract Specifications' : 'تعديل الشروط والبيانات التعاقدية' }}</x-slot>

    <div class="max-w-3xl mx-auto space-y-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        <div class="bg-white p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
            <div class="border-b border-gray-100 pb-4">
                <h3 class="text-lg font-black text-primary">{{ $isEn ? 'Edit Contract' : 'تعديل العقد' }}: {{ $contract->contract_number }}</h3>
            </div>

            <form action="{{ route('admin.contracts.update', $contract->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Contracted Company *' : 'الشركة المتعاقدة *' }}</label>
                        <select name="company_id" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            @foreach($companies as $comp)
                                <option value="{{ $comp->id }}" {{ old('company_id', $contract->company_id) == $comp->id ? 'selected' : '' }}>{{ $comp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Contract Number *' : 'رقم العقد *' }}</label>
                        <input type="text" name="contract_number" value="{{ old('contract_number', $contract->contract_number) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Start Date *' : 'تاريخ بداية العقد *' }}</label>
                        <input type="date" name="start_date" value="{{ old('start_date', $contract->start_date) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'End Date *' : 'تاريخ نهاية العقد *' }}</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $contract->end_date) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Payment Terms *' : 'شروط الدفع والتسوية *' }}</label>
                        <input type="text" name="payment_terms" value="{{ old('payment_terms', $contract->payment_terms) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Contract Status *' : 'حالة العقد *' }}</label>
                        <select name="status" required class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                            <option value="active" {{ old('status', $contract->status) == 'active' ? 'selected' : '' }}>{{ $isEn ? 'Active' : 'نشط' }}</option>
                            <option value="pending" {{ old('status', $contract->status) == 'pending' ? 'selected' : '' }}>{{ $isEn ? 'Pending Review' : 'قيد التدقيق' }}</option>
                            <option value="draft" {{ old('status', $contract->status) == 'draft' ? 'selected' : '' }}>{{ $isEn ? 'Draft' : 'مسودة' }}</option>
                            <option value="expired" {{ old('status', $contract->status) == 'expired' ? 'selected' : '' }}>{{ $isEn ? 'Expired' : 'منتهي' }}</option>
                            <option value="suspended" {{ old('status', $contract->status) == 'suspended' ? 'selected' : '' }}>{{ $isEn ? 'Suspended' : 'موقوف مؤقتاً' }}</option>
                            <option value="cancelled" {{ old('status', $contract->status) == 'cancelled' ? 'selected' : '' }}>{{ $isEn ? 'Cancelled' : 'ملغى' }}</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Discount Percentage Override (%)' : 'نسبة الخصم التعاقدي المباشر (%)' }}</label>
                    <input type="number" step="0.01" min="0" max="100" name="discount_percentage" value="{{ old('discount_percentage', $contract->discount_percentage) }}" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Notes' : 'ملاحظات' }}</label>
                    <textarea name="notes" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-bold focus:outline-none focus:border-primary">{{ old('notes', $contract->notes) }}</textarea>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100">
                    <a href="{{ route('admin.contracts.show', $contract->id) }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-xs transition-all">
                        {{ $isEn ? 'Cancel' : 'إلغاء' }}
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary-hover text-white font-extrabold rounded-xl text-xs shadow transition-all">
                        {{ $isEn ? 'Update Contract' : 'تحديث العقد' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
