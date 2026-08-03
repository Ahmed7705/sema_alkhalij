<x-guest-layout title="تسجيل الدخول | سيما الخليج للخدمات الطبية">

    <div class="w-full min-h-screen p-4 sm:p-6 flex items-center justify-center relative z-10">
        
        {{-- Single Elegant Centered Card --}}
        <div class="bg-white rounded-3xl shadow-floating border border-gray-100 p-8 sm:p-10 w-full max-w-md space-y-6">
            
            {{-- Header with Logo --}}
            <div class="text-center space-y-3">
                <a href="{{ route('home') }}" class="inline-block" title="الرئيسية">
                    <img src="{{ asset('images/logo.png') }}" alt="سيما الخليج" class="h-14 w-auto mx-auto drop-shadow-sm">
                </a>

                <div class="space-y-1">
                    <h1 class="text-2xl font-black text-primary">تسجيل الدخول</h1>
                    <p class="text-xs text-gray-500">أدخل بيانات حسابك للوصول إلى الخدمات والملف الطبي</p>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('profile') }}" method="GET" class="space-y-4">
                
                {{-- Email / Phone --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700">البريد الإلكتروني أو رقم الجوال <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        </div>
                        <input type="text" required placeholder="05xxxxxxxx أو name@example.com" class="w-full pr-10 pl-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all text-right">
                    </div>
                </div>

                {{-- Password --}}
                <div class="space-y-1.5" x-data="{ showPass: false }">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-bold text-gray-700">كلمة المرور <span class="text-red-500">*</span></label>
                        <a href="#" class="text-[11px] font-bold text-accent hover:underline">نسيت كلمة المرور؟</a>
                    </div>
                    <div class="relative">
                        <div class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input :type="showPass ? 'text' : 'password'" required placeholder="••••••••" class="w-full pr-10 pl-10 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all text-right">
                        <button type="button" @click="showPass = !showPass" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg x-show="!showPass" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPass" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a8.962 8.962 0 012.122-.063c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-4.225-4.225L3 3"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary">
                        <span class="text-gray-600 font-medium">تذكر تسجيل دخولي</span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full btn-accent py-3.5 rounded-xl font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                    <span>تسجيل الدخول</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            {{-- Footer Link --}}
            <div class="pt-4 border-t border-gray-100 text-center text-xs text-gray-500">
                ليس لديك حساب بعد؟ <a href="{{ route('register') }}" class="font-bold text-accent hover:underline">إنشاء حساب جديد</a>
            </div>

        </div>

    </div>

</x-guest-layout>
