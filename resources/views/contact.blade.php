<x-app-layout title="تواصل معنا | سيما الخليج للخدمات الطبية">

    {{-- =================== HERO BANNER =================== --}}
    <section class="relative py-16 sm:py-20 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/3 -translate-y-1/2 w-96 h-96 bg-accent/10 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 32px 32px;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-4">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-bold text-medical-100">
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                <span>تواصل معنا على مدار 24 ساعة</span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                سعداء بتواصلكم <span class="text-accent">ونرحب باستفساراتكم</span>
            </h1>

            <p class="text-medical-200 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                فريقنا الطبي والإداري جاهز لخدمتكم والرد على كافة تساؤلاتكم بشأن برامج الرعاية الصحية المنزلية وحجوزات الزيارات.
            </p>
        </div>
    </section>

    {{-- =================== QUICK CONTACT CARDS =================== --}}
    <section class="py-10 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Card 1: Phone --}}
                <a href="tel:+966545880082" class="p-6 rounded-2xl bg-surface border border-gray-100 shadow-soft hover:shadow-card hover:border-accent/30 transition-all duration-300 flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-xl bg-accent/10 text-accent flex items-center justify-center shrink-0 group-hover:bg-accent group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400">رقم الهاتف والخط الساخن</span>
                        <span dir="ltr" class="inline-block text-base font-black text-primary group-hover:text-accent transition-colors">+966 54 588 0082</span>
                        <span class="block text-[11px] text-accent font-bold">متاح 24/7 طوال الأسبوع</span>
                    </div>
                </a>

                {{-- Card 2: Email --}}
                <a href="mailto:c.care@s-sema.com" class="p-6 rounded-2xl bg-surface border border-gray-100 shadow-soft hover:shadow-card hover:border-accent/30 transition-all duration-300 flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-xl bg-accent/10 text-accent flex items-center justify-center shrink-0 group-hover:bg-accent group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400">البريد الإلكتروني الرسمي</span>
                        <span class="block text-base font-black text-primary group-hover:text-accent transition-colors">c.care@s-sema.com</span>
                        <span class="text-[11px] text-gray-500">استجابة خلال وقت قياسي</span>
                    </div>
                </a>

                {{-- Card 3: Address --}}
                <div class="p-6 rounded-2xl bg-surface border border-gray-100 shadow-soft flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-accent/10 text-accent flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400">العنوان والمقر الرئيسي</span>
                        <span class="block text-base font-black text-primary">جدة، حي الرويس</span>
                        <span class="text-[11px] text-gray-500">طريق المدينة المنورة</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- =================== CONTACT FORM & MAP SECTION =================== --}}
    <section class="py-12 lg:py-16 bg-surface">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                {{-- Contact Form (7 cols) --}}
                <div class="lg:col-span-7 bg-white p-6 sm:p-8 rounded-3xl shadow-soft border border-gray-100 space-y-6">
                    <div class="space-y-2">
                        <div class="section-badge">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                            <span>تواصل مباشر</span>
                        </div>
                        <h2 class="text-2xl font-black text-primary">أرسل لنا استفسارك أو رسالتك</h2>
                        <p class="text-xs text-gray-500">قم بتعبئة النموذج أدناه وسيقوم ممثل خدمة العملاء بالتواصل معك فوراً.</p>
                    </div>

                    <form @submit.prevent="alert('تم استلام رسالتك بنجاح! سيتواصل معك الفريق الطبي فوراً.');" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">الاسم الكريم <span class="text-red-500">*</span></label>
                                <input type="text" required placeholder="مثال: عبد الله أحمد" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">رقم الجوال <span class="text-red-500">*</span></label>
                                <input type="tel" required placeholder="05xxxxxxxx" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all dir-ltr text-right">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">البريد الإلكتروني <span class="text-red-500">*</span></label>
                                <input type="email" required placeholder="name@example.com" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1.5">الخدمة المطلوبة</label>
                                <select class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all cursor-pointer">
                                    <option value="">اختر الخدمة (اختياري)</option>
                                    <option value="nursing">التمريض المنزلي</option>
                                    <option value="doctor">زيارات الأطباء</option>
                                    <option value="physio">العلاج الطبيعي والتأهيل</option>
                                    <option value="labs">سحب عينات وفحوصات مخبرية</option>
                                    <option value="genetics">الفحوصات الجينية والوراثية</option>
                                    <option value="corporate">خدمات الشركات</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">الرسالة أو تفاصيل الاستفسار <span class="text-red-500">*</span></label>
                            <textarea rows="4" required placeholder="اكتب تفاصيل رسالتك أو استفسارك هنا..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all resize-none"></textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full btn-accent py-3.5 rounded-xl font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                <span>إرسال الرسالة الآن</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </div>

                        <p class="text-[11px] text-gray-400 text-center">
                            نلتزم بحماية سرية وخصوصية بياناتكم وفقاً لنظام حماية البيانات الشخصية بالمملكة (PDPL).
                        </p>
                    </form>
                </div>

                {{-- Right Info & Map (5 cols) --}}
                <div class="lg:col-span-5 space-y-6">
                    
                    {{-- Direct WhatsApp CTA Card --}}
                    <div class="bg-gradient-to-br from-primary to-[#0c4031] text-white p-6 rounded-3xl shadow-soft space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#25D366] text-white flex items-center justify-center shrink-0 shadow-md">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.157 4.228 4.305-1.129z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-base">محادثة واتساب فورية</h3>
                                <p class="text-[11px] text-medical-200">تحدث مع موظف الاستقبال الطبي فوراً</p>
                            </div>
                        </div>
                        <a href="https://wa.me/966545880082?text={{ urlencode('السلام عليكم، أود الاستفسار عن خدمات سيما الخليج الطبية المنزلية') }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-3 bg-[#25D366] text-white font-bold rounded-xl text-xs hover:opacity-90 transition-all shadow-md">
                            <span>افتح المحادثة على الواتساب</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>

                    {{-- Google Maps Embed --}}
                    <div class="bg-white rounded-3xl shadow-soft border border-gray-100 overflow-hidden h-72 relative">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3711.2!2d39.18!3d21.53!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDMxJzQ4LjAiTiAzOcKwMTAnNDguMCJF!5e0!3m2!1sar!2ssa!4v1" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-full h-full"></iframe>
                    </div>

                </div>

            </div>
        </div>
    </section>

</x-app-layout>
