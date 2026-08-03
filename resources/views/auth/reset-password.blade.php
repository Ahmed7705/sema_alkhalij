<x-guest-layout title="إعادة تعيين كلمة المرور | سيما الخليج">

    <div class="w-full min-h-screen p-4 sm:p-6 flex items-center justify-center relative z-10">
        
        <div class="bg-white rounded-3xl shadow-floating border border-gray-100 overflow-hidden w-full max-w-md p-6 sm:p-8 space-y-6">
            
            <div class="text-center space-y-3">
                <h1 class="text-2xl font-black text-primary">كلمة مرور جديدة</h1>
                <p class="text-xs text-gray-500">أدخل كود التحقق وكلمة المرور الجديدة لحسابك.</p>
            </div>

            @if($errors->any())
                <div class="p-3 bg-red-50 border border-red-200 text-red-600 text-xs rounded-xl text-center font-bold">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="email" value="{{ $email ?? session('reset_email') }}">

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700">كود التحقق (OTP) <span class="text-red-500">*</span></label>
                    <input type="text" name="token" required maxlength="6" placeholder="• • • • • •" class="w-full text-center tracking-[8px] text-xl font-black py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary focus:bg-white transition-all dir-ltr">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700">كلمة المرور الجديدة <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all text-right">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700">تأكيد كلمة المرور <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary focus:bg-white transition-all text-right">
                </div>

                <button type="submit" class="w-full btn-accent py-3.5 rounded-xl font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all">
                    تغيير كلمة المرور والدخول
                </button>
            </form>

        </div>

    </div>

</x-guest-layout>
