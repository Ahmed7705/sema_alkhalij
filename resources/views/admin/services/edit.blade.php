<x-admin-layout title="تعديل الخدمة الطبية">
    <x-slot name="headerTitle">تعديل بيانات الخدمة الطبية #{{ $service->id }}</x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6 text-right">
        
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <div>
                <h3 class="font-black text-lg text-primary">تعديل: {{ $service->title }}</h3>
                <p class="text-xs text-gray-500">قم بتحديث الأسعار أو الوصف أو حالة العرض</p>
            </div>
            
            <a href="{{ route('admin.services.index') }}" class="btn-outline py-2 px-4 rounded-xl text-xs font-bold">
                إلغاء والعودة
            </a>
        </div>

        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">عنوان الخدمة الطبية <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $service->title) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">التصنيف <span class="text-red-500">*</span></label>
                    <select name="category_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $service->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">السعر الأساسي (ر.س) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $service->price) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">السعر بعد الخصم (اختياري)</label>
                    <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price', $service->discount_price) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">المدة المتوقعة (بالدقائق) <span class="text-red-500">*</span></label>
                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $service->duration_minutes) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">الوصف المختصر <span class="text-red-500">*</span></label>
                <input type="text" name="short_description" value="{{ old('short_description', $service->short_description) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">الوصف التفصيلي الشامل <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary resize-none">{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="flex items-center gap-6 pt-2 text-xs">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ $service->is_featured ? 'checked' : '' }} class="rounded border-gray-300 text-primary">
                    <span class="font-bold text-gray-700">عرض في الخدمات المميزة</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ $service->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-primary">
                    <span class="font-bold text-gray-700">تفعيل وتنشيط الخدمة للعملاء</span>
                </label>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <button type="submit" class="w-full btn-accent py-3.5 rounded-xl font-bold text-xs sm:text-sm shadow-md hover:shadow-lg">
                    حفظ التغييرات الآن
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>
