<div x-data="{ cookieConsentAccepted: localStorage.getItem('cookieConsentAccepted') === 'true' }" x-show="!cookieConsentAccepted" x-cloak class="fixed bottom-0 inset-x-0 z-50 p-4 sm:p-6 pointer-events-none">
    <div class="max-w-4xl mx-auto bg-gray-900/95 text-white backdrop-blur-md p-5 rounded-2xl shadow-floating border border-gray-800 pointer-events-auto flex flex-col sm:flex-row items-center justify-between gap-4">
        
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-accent/20 text-accent flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <div>
                <h4 class="font-bold text-sm text-white">الملفات والكوكيز والخصوصية</h4>
                <p class="text-xs text-gray-300 leading-relaxed mt-1">
                    نستخدم ملفات تعريف الارتباط (Cookies) لتحسين تجربة تصفحك وتخصيص الخدمات والتحليلات وفقًا لـ <a href="{{ url('/cookies-policy') }}" class="text-accent underline font-bold">سياسة ملفات الكوكيز</a> و<a href="{{ url('/privacy-policy') }}" class="text-accent underline font-bold">سياسة الخصوصية</a>.
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3 shrink-0 w-full sm:w-auto">
            <button @click="localStorage.setItem('cookieConsentAccepted', 'true'); cookieConsentAccepted = true;" class="flex-1 sm:flex-none btn-accent text-xs py-2.5 px-5 rounded-xl font-bold">
                موافق وقبول
            </button>
            <button @click="cookieConsentAccepted = true;" class="flex-1 sm:flex-none px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-bold transition-colors">
                رفض الفرعي
            </button>
        </div>

    </div>
</div>
