<x-guest-layout title="تفعيل الحساب | سيما الخليج للخدمات الطبية">

    <div class="w-full min-h-screen p-4 sm:p-6 flex items-center justify-center relative z-10">
        
        <div class="bg-white rounded-3xl shadow-floating border border-gray-100 overflow-hidden w-full max-w-md p-6 sm:p-8 space-y-6">
            
            {{-- Header --}}
            <div class="text-center space-y-3">
                <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-medical-50 text-accent mb-2">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h1 class="text-2xl font-black text-primary">تأكيد البريد الإلكتروني</h1>
                <p class="text-xs text-gray-500 leading-relaxed">
                    أدخل كود التفعيل المكون من 6 أرقام المرسل إلى:<br>
                    <strong class="text-primary font-bold dir-ltr dir-left inline-block mt-1">{{ $email ?? session('verify_email') }}</strong>
                </p>
            </div>

            {{-- Alerts --}}
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

            {{-- OTP Form --}}
            <form action="{{ route('verify.otp') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="email" value="{{ $email ?? session('verify_email') }}">

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-700 text-center">كود التفعيل (OTP)</label>
                    <input type="text" name="code" required maxlength="6" autofocus placeholder="• • • • • •" class="w-full text-center tracking-[10px] text-2xl font-black py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:bg-white transition-all dir-ltr">
                </div>

                <button type="submit" class="w-full btn-accent py-3.5 rounded-xl font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                    <span>تفعيل الحساب والبدء</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </button>
            </form>

            {{-- Resend Section --}}
            <div class="pt-4 border-t border-gray-100 text-center text-xs text-gray-500 space-y-2">
                <p>لم يصلك الكود؟</p>
                <form action="{{ route('verify.otp.resend') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email ?? session('verify_email') }}">
                    <button type="submit" class="font-bold text-accent hover:underline bg-transparent border-0 cursor-pointer">إعادة إرسال كود جديد</button>
                </form>
            </div>

            <div class="text-center pt-2">
                <a href="{{ route('login') }}" class="text-xs text-gray-400 hover:text-gray-600">العودة لتسجيل الدخول</a>
            </div>

        </div>

    </div>

</x-guest-layout>
