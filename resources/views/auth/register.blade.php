<x-guest-layout title="إنشاء حساب جديد | سيما الخليج للخدمات الطبية">

    <div class="w-full min-h-screen p-4 sm:p-6 flex items-center justify-center relative z-10">
        
        {{-- Main Register Card with Side Banner --}}
        <div class="bg-white rounded-3xl shadow-floating border border-gray-100 overflow-hidden w-full max-w-4xl grid grid-cols-1 lg:grid-cols-12 gap-0">
            
            {{-- Right Side Form Column (7 cols) --}}
            <div class="lg:col-span-7 p-6 sm:p-10 flex flex-col justify-center space-y-6">
                
                {{-- Form Header --}}
                <div class="space-y-1.5 text-right">
                    <h1 class="text-2xl font-black text-primary">إنشاء حساب جديد</h1>
                    <p class="text-xs text-gray-500">أدخل بياناتك للاستفادة من كامل خدماتنا الطبية.</p>
                </div>

                @if($errors->any())
                    <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl flex items-center gap-2.5 font-bold shadow-sm">
                        <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                {{-- Form --}}
                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="text-right">
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">الاسم الكامل <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="مثال: عبد الله أحمد" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all text-right">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-right">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">رقم الجوال <span class="text-red-500">*</span></label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="05xxxxxxxx" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all dir-ltr text-right">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">البريد الإلكتروني <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all text-right">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-right">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">كلمة المرور <span class="text-red-500">*</span></label>
                            <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all text-right">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">تأكيد كلمة المرور <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" required placeholder="••••••••" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all text-right">
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

                {{-- Right-aligned Divider Text with Line --}}
                <div class="flex items-center gap-3 pt-2">
                    <span class="text-[11px] font-bold text-gray-500 shrink-0">أو التسجيل السريع عبر:</span>
                    <div class="border-t border-gray-200 w-full"></div>
                </div>

                {{-- Social Register Buttons (Google & Apple) --}}
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('social.redirect', 'google') }}" style="background-color: #ffffff; border: 1px solid #e5e7eb; color: #374151;" class="flex items-center justify-center gap-2.5 py-2.5 px-4 rounded-xl hover:bg-gray-50 transition-all text-xs font-bold shadow-sm">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                        <span>Google</span>
                    </a>
                    <a href="{{ route('social.redirect', 'apple') }}" style="background-color: #000000; border: 1px solid #000000; color: #ffffff;" class="flex items-center justify-center gap-2.5 py-2.5 px-4 rounded-xl hover:opacity-90 transition-all text-xs font-bold shadow-sm">
                        <svg class="w-4 h-4 shrink-0" style="fill: #ffffff;" viewBox="0 0 170 170"><path fill="#ffffff" d="M150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.34-3.17-4.58 0-9.49 1.05-14.75 3.17-5.26 2.13-9.5 3.24-12.74 3.35-4.34.13-9.13-1.9-14.37-6.08-3.38-2.73-7.29-7.38-11.73-13.95-6.06-8.91-10.88-18.73-14.44-29.47-3.56-10.74-5.34-21.2-5.34-31.38 0-14.54 3.73-26.68 11.2-36.42 7.47-9.74 16.92-14.67 28.36-14.79 4.34 0 9.29 1.15 14.86 3.44 5.57 2.29 9.38 3.44 11.43 3.44 1.8 0 5.72-1.22 11.77-3.67 6.06-2.45 11.13-3.55 15.22-3.31 9.49.65 17.51 4.1 24.08 10.35 4.3 4.14 7.6 9.07 9.89 14.79-8.48 5.12-12.65 12.38-12.51 21.78.14 7.23 2.82 13.41 8.04 18.54 5.22 5.13 11.59 8.05 19.11 8.76-1.74 5.12-3.77 10.15-6.09 15.09zM119.22 31.07c0-6.72 2.37-13.06 7.12-19.03 4.74-5.97 10.75-9.67 18.01-11.1 0.22 1.31 0.33 2.45 0.33 3.43 0 6.6-2.43 13-7.29 19.19-4.85 6.19-10.8 9.94-17.84 11.24-.07-.98-.11-1.89-.11-2.73z"/></svg>
                        <span style="color: #ffffff;">Apple</span>
                    </a>
                </div>

                <div class="pt-4 border-t border-gray-100 text-center text-xs text-gray-500">
                    لديك حساب بالفعل؟ <a href="{{ route('login') }}" class="font-bold text-accent hover:underline">تسجيل الدخول</a>
                </div>

            </div>

            {{-- Left Side Medical Banner (Desktop 5 cols) --}}
            <div class="lg:col-span-5 relative hidden lg:flex flex-col justify-between p-8 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden">
                <div class="absolute inset-0 opacity-20 pointer-events-none">
                    <img src="{{ asset('images/hero-doctor.png') }}" alt="سيما الخليج" class="w-full h-full object-cover">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-primary via-primary/85 to-transparent"></div>

                <div class="relative z-10 space-y-4">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 p-2 flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" alt="سيما الخليج" class="max-h-full max-w-full object-contain">
                    </div>
                    <h2 class="text-xl font-black text-white">سيما الخليج للخدمات الطبية</h2>
                    <p class="text-xs text-medical-200 leading-relaxed">رعاية صحية منزلية متخصصة ومستلزمات طبية معتمدة تمتد إلى منزلك.</p>
                </div>

                <div class="relative z-10 space-y-3 pt-10">
                    <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 space-y-2 text-xs">
                        <div class="flex items-center gap-2 text-accent font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>ضمان الجودة والأمان:</span>
                        </div>
                        <ul class="space-y-1.5 text-[11px] text-medical-100">
                            <li class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> كوادر مرخّصة رسمياً من الهيئة السعودية</li>
                            <li class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> خدمة استجابة فورية 24 ساعة طوال الأسبوع</li>
                            <li class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg> سرية تامة وحماية شاملة لسجلات المرضى</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </div>

</x-guest-layout>
