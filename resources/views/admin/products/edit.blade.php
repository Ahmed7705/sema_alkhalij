<x-admin-layout title="تعديل المنتج الطبي">
    <x-slot name="headerTitle">تعديل بيانات المنتج #{{ $product->id }}</x-slot>

    @php
        $imgPath = $product->image;
        if (!empty($imgPath) && file_exists(public_path($imgPath))) {
            $currentImgUrl = asset($imgPath);
            $hasCustomImage = true;
        } elseif (!empty($imgPath) && file_exists(public_path('images/' . $imgPath))) {
            $currentImgUrl = asset('images/' . $imgPath);
            $hasCustomImage = true;
        } else {
            $imgMap = [
                'smart-blood-pressure-monitor' => 'prod-bp.png',
                'glucometer-kit' => 'prod-glucometer.png',
                'foldable-wheelchair' => 'prod-wheelchair.png',
                'pulse-oximeter' => 'prod-oximeter.png',
                'nebulizer-compressor' => 'prod-nebulizer.png',
                'infrared-thermometer' => 'prod-supplies.png',
                'sterile-wound-dressing-kit' => 'prod-firstaid.png',
                'electric-medical-bed' => 'prod-bed.png',
            ];
            $defaultImg = $imgMap[$product->slug] ?? 'hero-doctor.png';
            $currentImgUrl = asset('images/' . $defaultImg);
            $hasCustomImage = false;
        }
    @endphp

    <div class="max-w-4xl mx-auto bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6 text-right">
        
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <div>
                <h3 class="font-black text-lg text-primary">تعديل: {{ $product->title }}</h3>
                <p class="text-xs text-gray-500">قم بتحديث الكميات والمتوفر ومعاينة أو استبدال أو حذف صورة المنتج</p>
            </div>
            
            <a href="{{ route('admin.products.index') }}" class="py-2 px-4 rounded-xl text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                إلغاء والعودة
            </a>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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

            {{-- PROMINENT IMAGE MANAGEMENT BLOCK WITH PREVIEW & DELETE OPTION --}}
            <div class="p-5 bg-surface rounded-2xl border border-gray-200 space-y-4">
                <div class="flex items-center justify-between border-b border-gray-200/60 pb-3">
                    <label class="font-black text-xs text-primary flex items-center gap-2">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>إدارة ومعاينة صورة المنتج الطبي</span>
                    </label>
                    <span class="text-[11px] font-bold text-gray-500">
                        {{ $hasCustomImage ? 'مرفوع صورة مخصصة' : 'يتم استخدام الصورة الافتراضية للمنتج' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-center">
                    
                    {{-- Image Preview Thumbnail --}}
                    <div class="sm:col-span-1 flex flex-col items-center justify-center p-2 bg-white rounded-2xl border border-gray-200 shadow-sm relative group">
                        <img src="{{ $currentImgUrl }}" alt="{{ $product->title }}" class="w-28 h-28 object-contain rounded-xl">
                        <a href="{{ $currentImgUrl }}" target="_blank" class="mt-2 text-[10px] font-bold text-accent hover:underline flex items-center gap-1">
                            <span>معاينة بحجم كامل</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </div>

                    {{-- Action Controls: Change / Upload / Keep / Remove --}}
                    <div class="sm:col-span-3 space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1">استبدال أو رفع صورة جديدة للمنتج</label>
                            <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs text-gray-600 focus:outline-none cursor-pointer">
                            <span class="text-[10px] text-gray-400 block mt-1">إذا تركت هذا الحقل فارغاً، سيتم الاحتفاظ بالصورة الحالية بدون أي تغيير.</span>
                        </div>

                        @if($hasCustomImage)
                            <div class="pt-2 border-t border-gray-200/60">
                                <label class="flex items-center gap-2 cursor-pointer text-xs font-bold text-red-600 hover:text-red-700">
                                    <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                                    <span>حذف الصورة المخصصة الحالية والعودة للصورة الافتراضية</span>
                                </label>
                            </div>
                        @endif
                    </div>

                </div>
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
                <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white py-3.5 sm:py-4 rounded-2xl font-black text-sm shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2 cursor-pointer border-0">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>حفظ التعديلات</span>
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>
