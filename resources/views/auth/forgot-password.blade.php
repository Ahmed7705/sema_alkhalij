<x-guest-layout title="نسيت كلمة المرور | سيما الخليج للخدمات الطبية">

    <div class="w-full min-h-screen p-4 sm:p-6 flex items-center justify-center relative z-10">
        
        <div class="bg-white rounded-3xl shadow-floating border border-gray-100 overflow-hidden w-full max-w-md p-6 sm:p-8 space-y-6">
            
            <div class="text-center space-y-3">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-medical-50 text-accent mb-2">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                </div>
                <h1 class="text-2xl font-black text-primary">نسيت كلمة المرور؟</h1>
                <p class="text-xs text-gray-500 leading-relaxed">
                    أدخل بريدك الإلكتروني المسجل وسنرسل لك كود تحقق لإعادة تعيين كلمة المرور.
                </p>
            </div>

            @if(session('success'))
                <div class="p-3 bg-green-50 border border-green-200 text-green-700 text-xs rounded-xl text-center font-bold">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl text-center font-bold">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                @csrf
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700">البريد الإلكتروني <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@example.com" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all text-right">
                </div>

                <button type="submit" class="w-full btn-accent py-3.5 rounded-xl font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                    <span>إرسال كود الإعادة</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <div class="text-center pt-2">
                <a href="{{ route('login') }}" class="text-xs text-gray-400 hover:text-gray-600 font-bold">العودة لتسجيل الدخول</a>
            </div>

        </div>

    </div>

</x-guest-layout>
