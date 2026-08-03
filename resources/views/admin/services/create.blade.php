<x-admin-layout title="إضافة خدمة طبية جديدة">
    <x-slot name="headerTitle">إضافة برنامج رعاية صحية أو خدمة منزلي جديدة</x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6 text-right">
        
        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
            <div>
                <h3 class="font-black text-lg text-primary">نموذج إضافة خدمة جديدة</h3>
                <p class="text-xs text-gray-500">أدخل بيانات وتفاصيل وصورة الخدمة الطبية لتظهر في الواجهة والحجوزات</p>
            </div>
            
            <a href="{{ route('admin.services.index') }}" class="btn-outline py-2 px-4 rounded-xl text-xs font-bold">
                العودة للقائمة
            </a>
        </div>

        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">عنوان الخدمة الطبية <span class="text-red-500">*</span></label>
                    <input type="text" name="title" required placeholder="مثال: فحص صحي شامل بالمنزل" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">التصنيف <span class="text-red-500">*</span></label>
                    <select name="category_id" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
                        <option value="">اختر التصنيف</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">السعر الأساسي (ر.س) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="price" required placeholder="250.00" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">السعر بعد الخصم (اختياري)</label>
                    <input type="number" step="0.01" name="discount_price" placeholder="200.00" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">المدة المتوقعة (بالدقائق) <span class="text-red-500">*</span></label>
                    <input type="number" name="duration_minutes" value="60" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
                </div>
            </div>

            {{-- Image File Input --}}
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">صورة الخدمة الطبية</label>
                <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-600 focus:outline-none cursor-pointer">
                <span class="text-[10px] text-gray-400 block mt-1">أنواع الملفات المسموحة: PNG, JPG, WEBP (حجم أقصى 4MB)</span>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">الوصف المختصر <span class="text-red-500">*</span></label>
                <input type="text" name="short_description" required placeholder="وصف مقتضب يظهر في بطاقات الخدمات والصفحة الرئيسية..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1.5">الوصف التفصيلي الشامل <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" required placeholder="تفاصيل الخدمة، الفحوصات المشمولة، والشروط الطبيّة..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary resize-none"></textarea>
            </div>

            <div class="flex items-center gap-6 pt-2 text-xs">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" checked class="rounded border-gray-300 text-primary">
                    <span class="font-bold text-gray-700">عرض في الخدمات المميزة</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300 text-primary">
                    <span class="font-bold text-gray-700">تفعيل وتنشيط الخدمة للعملاء</span>
                </label>
            </div>

            <div class="pt-4 border-t border-gray-100">
                <button type="submit" class="w-full btn-accent py-3.5 rounded-xl font-bold text-xs sm:text-sm shadow-md hover:shadow-lg">
                    حفظ ونشر الخدمة الطبية الآن
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>
