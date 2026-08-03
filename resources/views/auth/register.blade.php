<x-guest-layout title="إنشاء حساب جديد | سيما الخليج للخدمات الطبية">

    <div class="w-full min-h-screen p-4 sm:p-6 flex items-center justify-center relative z-10">
        
        {{-- Main Register Card with Side Banner --}}
        <div class="bg-white rounded-3xl shadow-floating border border-gray-100 overflow-hidden w-full max-w-4xl grid grid-cols-1 lg:grid-cols-12 gap-0">
            
            {{-- Right Side Form Column (7 cols) --}}
            <div class="lg:col-span-7 p-6 sm:p-10 flex flex-col justify-center space-y-6">
                
                {{-- Header with Logo --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-medical-50 text-accent text-[11px] font-bold">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            <span>حساب جديد في ثوانٍ</span>
                        </div>

                        <a href="{{ route('home') }}" title="الرئيسية">
                            <img src="{{ asset('images/logo.png') }}" alt="سيما الخليج" class="h-9 w-auto">
                        </a>
                    </div>

                    <h1 class="text-2xl font-black text-primary">إنشاء حساب جديد</h1>
                    <p class="text-xs text-gray-500">أدخل بياناتك للاستفادة من كامل خدماتنا الطبية.</p>
                </div>

                {{-- Form --}}
                <form action="{{ route('profile') }}" method="GET" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">الاسم الكامل <span class="text-red-500">*</span></label>
                        <input type="text" required placeholder="مثال: عبد الله أحمد" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all text-right">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">رقم الجوال <span class="text-red-500">*</span></label>
                            <input type="tel" required placeholder="05xxxxxxxx" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all dir-ltr text-right">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">المدينة <span class="text-red-500">*</span></label>
                            <select class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all cursor-pointer text-right">
                                <option>جدة</option>
                                <option>الرياض</option>
                                <option>مكة المكرمة</option>
                                <option>الدمام</option>
                                <option>المدينة المنورة</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">البريد الإلكتروني <span class="text-red-500">*</span></label>
                        <input type="email" required placeholder="name@example.com" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all text-right">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">كلمة المرور <span class="text-red-500">*</span></label>
                            <input type="password" required placeholder="••••••••" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all text-right">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">تأكيد كلمة المرور <span class="text-red-500">*</span></label>
                            <input type="password" required placeholder="••••••••" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all text-right">
                        </div>
                    </div>

                    <div class="flex items-center text-xs pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" required class="rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="text-gray-600">أوافق على <a href="{{ route('terms') }}" class="text-accent underline font-bold">الشروط والأحكام</a> و <a href="{{ route('privacy') }}" class="text-accent underline font-bold">سياسة الخصوصية</a></span>
                        </label>
                    </div>

                    <button type="submit" class="w-full btn-accent py-3.5 rounded-xl font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <span>إنشاء الحساب الآن</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </form>

                <div class="pt-4 border-t border-gray-100 text-center text-xs text-gray-500">
                    لديك حساب بالفعل؟ <a href="{{ route('login') }}" class="font-bold text-accent hover:underline">تسجيل الدخول</a>
                </div>

            </div>

            {{-- Left Side Medical Banner (Desktop 5 cols) --}}
            <div class="lg:col-span-5 relative hidden lg:flex flex-col justify-between p-8 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden">
                <div class="absolute inset-0 opacity-20 pointer-events-none">
                    <img src="{{ asset('images/nurse-care.png') }}" alt="سيما الخليج" class="w-full h-full object-cover">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/85 to-transparent"></div>

                <div class="relative z-10 space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 p-2.5 flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" alt="سيما الخليج" class="max-h-full max-w-full object-contain">
                    </div>
                    <h2 class="text-xl font-black text-white">انضم لعائلة سيما الخليج</h2>
                    <p class="text-xs text-medical-200 leading-relaxed">خدمات طبية متكاملة بلمسة زر في منزلك باحترافية وأمان.</p>
                </div>

                <div class="relative z-10 space-y-3 pt-10">
                    <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 space-y-2 text-xs">
                        <div class="flex items-center gap-2 text-accent font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>مميزات الحساب الطبي:</span>
                        </div>
                        <ul class="space-y-1.5 text-[11px] text-medical-100">
                            <li class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> سرعة حجز وتأكيد الزيارات المنزلية</li>
                            <li class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> حفظ سجل الفحوصات والتقارير الطبية</li>
                            <li class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> متابعة شحنات الأجهزة الطبية وتتبعها</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>

</x-guest-layout>
