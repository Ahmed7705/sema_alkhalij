<x-app-layout title="تواصل معنا | سيما الخليج">
    <section class="bg-gradient-to-br from-primary to-primary-dark text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="max-w-7xl mx-auto px-4 text-center relative z-10 space-y-4">
            <h1 class="text-4xl sm:text-5xl font-black">تواصل معنا</h1>
            <p class="text-medical-200 max-w-xl mx-auto">نسعد بتواصلكم ونرحب باستفساراتكم في أي وقت</p>
        </div>
    </section>
    <section class="py-16 bg-surface">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                {{-- Contact Form --}}
                <div class="bg-white p-8 rounded-3xl shadow-soft border border-gray-100 space-y-6">
                    <h2 class="text-2xl font-black text-primary">أرسل لنا رسالة</h2>
                    <form @submit.prevent class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5">الاسم الكامل <span class="text-red-500">*</span></label>
                                <input type="text" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:bg-white transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5">البريد الإلكتروني <span class="text-red-500">*</span></label>
                                <input type="email" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:bg-white transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">رقم الجوال</label>
                            <input type="tel" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:bg-white transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">الموضوع</label>
                            <input type="text" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:bg-white transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5">الرسالة <span class="text-red-500">*</span></label>
                            <textarea rows="5" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:bg-white transition-all resize-none"></textarea>
                        </div>
                        <button type="submit" class="w-full btn-accent py-3.5 rounded-xl font-bold text-sm">إرسال الرسالة</button>
                    </form>
                </div>

                {{-- Contact Info --}}
                <div class="space-y-6">
                    <div class="bg-white p-7 rounded-2xl shadow-soft border border-gray-100 space-y-5">
                        <h3 class="font-bold text-lg text-primary">معلومات التواصل الرسمية</h3>
                        <div class="space-y-4">
                            <a href="tel:+966545880082" class="flex items-center gap-4 text-sm text-gray-700 hover:text-primary transition-colors">
                                <div class="w-10 h-10 rounded-xl bg-medical-50 text-accent flex items-center justify-center shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></div>
                                <div>
                                    <span class="block font-bold text-primary">+966 54 588 0082</span>
                                    <span class="text-xs text-gray-400">متاح على مدار الساعة</span>
                                </div>
                            </a>
                            <a href="mailto:c.care@s-sema.com" class="flex items-center gap-4 text-sm text-gray-700 hover:text-primary transition-colors">
                                <div class="w-10 h-10 rounded-xl bg-medical-50 text-accent flex items-center justify-center shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                                <div>
                                    <span class="block font-bold text-primary">c.care@s-sema.com</span>
                                    <span class="text-xs text-gray-400">البريد الإلكتروني الرسمي</span>
                                </div>
                            </a>
                            <div class="flex items-center gap-4 text-sm text-gray-700">
                                <div class="w-10 h-10 rounded-xl bg-medical-50 text-accent flex items-center justify-center shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg></div>
                                <div>
                                    <span class="block font-bold text-primary">جدة، حي الرويس</span>
                                    <span class="text-xs text-gray-400">طريق المدينة المنورة، المملكة العربية السعودية</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Google Maps Embed --}}
                    <div class="bg-white rounded-2xl shadow-soft border border-gray-100 overflow-hidden h-72">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3711.2!2d39.18!3d21.53!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDMxJzQ4LjAiTiAzOcKwMTAnNDguMCJF!5e0!3m2!1sar!2ssa!4v1" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-full h-full"></iframe>
                    </div>

                    {{-- WhatsApp CTA --}}
                    <a href="https://wa.me/966545880082" target="_blank" class="flex items-center justify-center gap-3 w-full py-4 bg-[#25D366] text-white font-bold rounded-2xl shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.157 4.228 4.305-1.129z"/></svg>
                        تواصل مباشر عبر الواتساب
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
