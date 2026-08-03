<x-guest-layout title="إنشاء حساب جديد | سيما الخليج للخدمات الطبية">

    <div class="w-full min-h-screen p-4 sm:p-6 flex items-center justify-center relative z-10">
        
        {{-- Single Elegant Centered Card --}}
        <div class="bg-white rounded-3xl shadow-floating border border-gray-100 p-8 sm:p-10 w-full max-w-lg space-y-6">
            
            {{-- Header with Logo --}}
            <div class="text-center space-y-3">
                <a href="{{ route('home') }}" class="inline-block" title="الرئيسية">
                    <img src="{{ asset('images/logo.png') }}" alt="سيما الخليج" class="h-14 w-auto mx-auto drop-shadow-sm">
                </a>

                <div class="space-y-1">
                    <h1 class="text-2xl font-black text-primary">إنشاء حساب جديد</h1>
                    <p class="text-xs text-gray-500">أدخل بياناتك للانضمام والاستفادة من خدماتنا الطبية</p>
                </div>
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

    </div>

</x-guest-layout>
