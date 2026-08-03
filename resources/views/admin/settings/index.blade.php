<x-admin-layout title="معدّل CMS ونظام الإعدادات">
    <x-slot name="headerTitle">إدارة محتوى الموقع والإعدادات العامة CMS</x-slot>

    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6 text-right">
        
        <div class="border-b border-gray-100 pb-4">
            <h3 class="font-black text-lg text-primary">إعدادات الهوية العامة وبيانات التواصل</h3>
            <p class="text-xs text-gray-500">تعديل نصوص الصفحة الرئيسية ومعلومات التواصل والشعار ديناميكياً 100%.</p>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700">اسم الموقع الرسمي (Site Title)</label>
                    <input type="text" name="site_title" value="{{ $settings['site_title'] ?? 'سيما الخليج للخدمات الطبية' }}" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700">رقم الهاتف والتواصل الرئيسي</label>
                    <input type="text" name="site_phone" value="{{ $settings['site_phone'] ?? '0545880082' }}" dir="ltr" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary text-right">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700">رقم الواتساب الرسمي</label>
                    <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '966545880082' }}" dir="ltr" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary text-right">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700">البريد الإلكتروني الرسمي</label>
                    <input type="email" name="site_email" value="{{ $settings['site_email'] ?? 'info@sema-alkhalij.sa' }}" dir="ltr" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary text-right">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700">عنوان الترويسة الرئيسية في الهيرو (Hero Title)</label>
                <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? 'رعاية صحية منزلية متكاملة بأعلى معايير الجودة' }}" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700">الوصف الفرعي للهيرو (Hero Subtitle)</label>
                <textarea name="hero_subtitle" rows="3" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 focus:outline-none focus:border-primary">{{ $settings['hero_subtitle'] ?? 'نقدم خدمات الطب العام، التمريض المنزلي، التحاليل المخبرية، والعلاج الطبيعي في جميع أنحاء المملكة بواسطة كوادر مرخصة.' }}</textarea>
            </div>

            <div class="pt-2">
                <button type="submit" class="btn-accent px-8 py-3 rounded-xl font-black text-xs shadow-lg hover:shadow-xl transition-all">
                    حفظ ونشر التعديلات فوراً
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>
