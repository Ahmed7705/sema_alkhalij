<x-admin-layout title="معدّل CMS ونظام الإعدادات">
    <x-slot name="headerTitle">إدارة محتوى الموقع والإعدادات العامة CMS</x-slot>

    <div class="max-w-4xl mx-auto space-y-8 text-right">
        
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- SECTION 1: LOGO & BRAND IDENTITY --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
                <div class="border-b border-gray-100 pb-4 flex items-center justify-between">
                    <div>
                        <h3 class="font-black text-lg text-primary flex items-center gap-2">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>شعار الموقع والهوية البصرية</span>
                        </h3>
                        <p class="text-xs text-gray-500">معاينة واستبدال شعار الشركة المعروض في الهيدر والفوتر واللوحة الإدارية</p>
                    </div>
                    <span class="text-xs font-bold text-accent bg-accent/10 px-3 py-1 rounded-full">هوية رقمية</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 items-center">
                    {{-- Clean Light Logo Preview Box --}}
                    <div class="sm:col-span-1 flex flex-col items-center justify-center p-3.5 bg-gray-50 rounded-2xl border border-gray-200 shadow-inner">
                        <span class="text-[10px] text-gray-500 font-bold mb-2">الشعار الحالي للموقع</span>
                        <div class="bg-white p-2 rounded-xl border border-gray-100 w-full flex items-center justify-center shadow-sm">
                            <img src="{{ asset($settings['site_logo'] ?? 'images/logo.png') }}" alt="شعار الشركة" class="h-20 w-auto object-contain">
                        </div>
                    </div>

                    {{-- Upload Control --}}
                    <div class="sm:col-span-3 space-y-2">
                        <label class="block text-xs font-bold text-gray-700">تغيير واستبدال الشعار الرسمي</label>
                        <input type="file" name="logo" accept="image/*" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-700 focus:outline-none cursor-pointer">
                        <span class="text-[11px] text-gray-400 block">الصيغ الموصى بها: PNG أو WEBP أو JPG بحجم أقصى 2MB.</span>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: COMPANY CONTACT & PHONE NUMBERS --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="font-black text-lg text-primary flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>اسم الشركة وبيانات التواصل الرسمية</span>
                    </h3>
                    <p class="text-xs text-gray-500">أرقام الاتصال المباشر والواتساب والبريد الإلكتروني الظاهرة للعملاء</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">اسم الموقع الرسمي (Site Title) *</label>
                        <input type="text" name="site_title" value="{{ $settings['site_title'] ?? 'سيما الخليج للخدمات الطبية' }}" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">رقم الهاتف والتواصل الرئيسي *</label>
                        <input type="text" name="site_phone" value="{{ $settings['site_phone'] ?? '0545880082' }}" required dir="ltr" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary text-right">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">رقم الواتساب الرسمي *</label>
                        <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '966545880082' }}" required dir="ltr" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary text-right">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">البريد الإلكتروني الرسمي *</label>
                        <input type="email" name="site_email" value="{{ $settings['site_email'] ?? 'info@sema-alkhalij.sa' }}" required dir="ltr" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary text-right">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">ساعات العمل الرسمية</label>
                        <input type="text" name="working_hours" value="{{ $settings['working_hours'] ?? 'خدمة 24/7 طوال الأسبوع' }}" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary">
                    </div>
                </div>
            </div>

            {{-- SECTION 3: SEO & METADATA --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="font-black text-lg text-primary flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>إعدادات محركات البحث SEO ومتا داتا</span>
                    </h3>
                    <p class="text-xs text-gray-500">تهيئة العناوين والكلمات المفتاحية للأرشفة في قوقل</p>
                </div>

                <div class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">عنوان ميتا الصفحة SEO Title</label>
                        <input type="text" name="seo_title" value="{{ $settings['seo_title'] ?? 'سيما الخليج | أفضل خدمات الرعاية الصحية والتمريض المنزلي بالمملكة' }}" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">الوصف الميتا SEO Description</label>
                        <textarea name="seo_description" rows="2" class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 focus:outline-none focus:border-primary resize-none">{{ $settings['seo_description'] ?? 'احصل على رعاية صحية منزلية متكاملة، تمريض 24 ساعة، تحاليل مخبرية، وعلاج طبيعي في منزلك بواسطة أطباء وممرضين مرخصين من هيئة التخصصات الصحية.' }}</textarea>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">الكلمات المفتاحية Keywords</label>
                        <input type="text" name="seo_keywords" value="{{ $settings['seo_keywords'] ?? 'رعاية منزلية, تمريض منزلي, تحاليل منزلية, علاج طبيعي, طبيب منزلي, جدة, الرياض' }}" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-medium focus:outline-none focus:border-primary">
                    </div>
                </div>
            </div>

            {{-- SECTION 4: TAX, CURRENCY & PAYMENT GATEWAYS --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="font-black text-lg text-primary flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        <span>الضرائب والعملة وبوابات الدفع الإلكتروني</span>
                    </h3>
                    <p class="text-xs text-gray-500">ضبط نسبة ضريبة القيمة المضافة ومفاتيح الدفع عبر مدى وفيزا وApple Pay</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">نسبة ضريبة القيمة المضافة (VAT %)</label>
                        <input type="number" step="0.1" name="vat_percentage" value="{{ $settings['vat_percentage'] ?? '15' }}" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">رمز العملة الرسمي</label>
                        <input type="text" name="currency_code" value="{{ $settings['currency_code'] ?? 'ر.س (SAR)' }}" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">خيار الدفع كاش عند الزيارة</label>
                        <select name="enable_cod" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary">
                            <option value="1" {{ ($settings['enable_cod'] ?? '1') == '1' ? 'selected' : '' }}>مفعل ومتاح للعملاء</option>
                            <option value="0" {{ ($settings['enable_cod'] ?? '1') == '0' ? 'selected' : '' }}>معطل (دفع إلكتروني فقط)</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- SECTION 5: LANGUAGES & SECURITY --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
                <div class="border-b border-gray-100 pb-4">
                    <h3 class="font-black text-lg text-primary flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>اللغات وتتبع الأمان Audit Logging</span>
                    </h3>
                    <p class="text-xs text-gray-500">إدارة اللغات وتنشيط سجلات مراقبة الأمان للعمليات</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">اللغات المدعومة بالمنصة</label>
                        <input type="text" name="supported_languages" value="{{ $settings['supported_languages'] ?? 'العربية (الافتراضية)، الإنجليزية' }}" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">تسجيل ومراقبة سجل العمليات الأمني</label>
                        <select name="enable_audit_log" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary">
                            <option value="1" {{ ($settings['enable_audit_log'] ?? '1') == '1' ? 'selected' : '' }}>نشط (تسجيل كافة الدخول والتعديلات)</option>
                            <option value="0" {{ ($settings['enable_audit_log'] ?? '1') == '0' ? 'selected' : '' }}>غير نشط</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- SUBMIT BUTTON --}}
            <div class="pt-4">
                <button type="submit" class="w-full bg-primary hover:bg-primary-hover text-white py-4 rounded-2xl font-black text-sm shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2 cursor-pointer border-0">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>حفظ ونشر التعديلات فوراً</span>
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>
