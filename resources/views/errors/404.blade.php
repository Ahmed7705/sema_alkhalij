<x-guest-layout title="404 - الصفحة غير موجودة | سيما الخليج للخدمات الطبية">

    <div class="w-full min-h-screen p-4 sm:p-6 flex items-center justify-center relative z-10 bg-[#F8FAF9] text-gray-800">
        
        {{-- Clean Light Standalone Card --}}
        <div class="bg-white rounded-3xl shadow-floating border border-gray-100 p-8 sm:p-12 w-full max-w-md text-center space-y-6 my-auto">
            
            {{-- Brand Logo --}}
            <div class="flex justify-center">
                <a href="{{ route('home') }}" title="سيما الخليج" class="hover:opacity-90 transition-opacity">
                    <img src="{{ asset('images/logo.png') }}" alt="سيما الخليج" class="h-14 w-auto">
                </a>
            </div>

            {{-- 404 Badge & Icon --}}
            <div class="space-y-2 py-2">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-medical-50 text-accent font-black text-2xl shadow-inner">
                    404
                </div>
                <h1 class="text-xl sm:text-2xl font-black text-primary">
                    عفواً، الصفحة غير موجودة
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">
                    الصفحة التي تحاول الوصول إليها غير متوفرة حالياً أو ربما تم تغيير عنوانها.
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="space-y-3 pt-2">
                {{-- Primary Action Button --}}
                <a href="{{ route('home') }}" class="w-full btn-accent py-3.5 px-6 rounded-xl font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>العودة للصفحة الرئيسية</span>
                </a>

                {{-- Secondary Action Buttons --}}
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('services') }}" class="py-3 px-4 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 hover:bg-gray-100 hover:border-gray-300 font-bold text-xs transition-all flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 00-1.18.118l-1.2.6a1 1 0 00-.42 1.34l.2.4a1 1 0 00.8.54l3.1.31a6 6 0 003.86-.52l.32-.16a6 6 0 013.86-.51l2.38.47a2 2 0 001.62-.31l1.3-.87a1 1 0 00.37-1.1z"/></svg>
                        <span>الخدمات الطبية</span>
                    </a>

                    <a href="{{ route('contact') }}" class="py-3 px-4 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 hover:bg-gray-100 hover:border-gray-300 font-bold text-xs transition-all flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>تواصل معنا</span>
                    </a>
                </div>
            </div>

            {{-- Footer Note --}}
            <div class="pt-4 border-t border-gray-100 text-center text-[11px] text-gray-400">
                © {{ date('Y') }} سيما الخليج للخدمات الطبية. جميع الحقوق محفوظة.
            </div>

        </div>

    </div>

</x-guest-layout>
