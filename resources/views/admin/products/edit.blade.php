<x-admin-layout title="تعديل المنتج الطبي">
    <x-slot name="headerTitle">تعديل بيانات المنتج #{{ $product->id }}</x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6 text-right">
        
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <div>
                <h3 class="font-black text-lg text-primary">تعديل: {{ $product->title }}</h3>
                <p class="text-xs text-gray-500">قم بتحديث الكميات المتوفرة والصورة أو السعر أو حالة العرض</p>
            </div>
            
            <a href="{{ route('admin.products.index') }}" class="btn-outline py-2 px-4 rounded-xl text-xs font-bold">
                إلغاء والعودة
            </a>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">اسم المنتج الطبي <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $product->title) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">رمز SKU <span class="text-red-500">*</span></label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary dir-ltr text-right">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">التصنيف <span class="text-red-500">*</span></label>
                    <select name="category_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">السعر الأساسي (ر.س) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">السعر المخصوم (اختياري)</label>
                    <input type="number" step="0.01" name="discount_price" value="{{ old('discount_price', $product->discount_price) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">المخزون بالمستودع <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
                </div>
            </div>

            {{-- Image File Input & Preview --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-700">صورة المنتج الطبي</label>
                @if($product->image)
                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200 w-fit">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->title }}" class="w-12 h-12 object-contain rounded-lg">
                        <span class="text-xs font-bold text-gray-600">الصورة الحالية للمنتج</span>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-600 focus:outline-none cursor-pointer">
                <span class="text-[10px] text-gray-400 block">اختر صورة جديدة إذا كنت ترغب في استبدال الصورة الحالية</span>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">الوصف المختصر <span class="text-red-500">*</span></label>
                <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">المواصفات والوصف الكامل <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary resize-none">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="flex items-center gap-6 pt-2 text-xs">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="rounded border-gray-300 text-primary">
                    <span class="font-bold text-gray-700">عرض في كروت المتجر المميزة</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-primary">
                    <span class="font-bold text-gray-700">عرض وإتاحة المنتج للشراء</span>
                </label>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <button type="submit" class="w-full btn-accent py-3.5 rounded-xl font-bold text-xs sm:text-sm shadow-md hover:shadow-lg">
                    حفظ التعديلات والصورة الآن
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>
