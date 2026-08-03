<x-app-layout title="الأسئلة الشائعة | سيما الخليج">
    <section class="bg-gradient-to-br from-primary to-primary-dark text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="max-w-7xl mx-auto px-4 text-center relative z-10 space-y-4">
            <h1 class="text-4xl sm:text-5xl font-black">الأسئلة الشائعة</h1>
            <p class="text-medical-200 max-w-xl mx-auto">إجابات مفصلة على كافة استفساراتكم حول خدماتنا الطبية المنزلية</p>
        </div>
    </section>
    <section class="py-16 bg-surface">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
            $allFaqs = [
                ['q' => 'كيف يمكنني حجز زيارة طبية منزلية من سيما الخليج؟', 'a' => 'اختر الخدمة المطلوبة من موقعنا الإلكتروني، حدد التاريخ والوقت المناسب والمدينة، أو يمكنك الضغط على زر "طلب خدمة" وسيتواصل معك فريق خدمة العملاء فوراً لتأكيد الحجز ومساعدتك.'],
                ['q' => 'هل الكادر الطبي مرخص ومعتمد رسمياً؟', 'a' => 'نعم بالتأكيد. جميع الأطباء والممرضين والأخصائيين العاملين في سيما الخليج يحملون تراخيص سارية المفعول من الهيئة السعودية للتخصصات الصحية، مع خبرة واسعة في مجال الرعاية الصحية المنزلية.'],
                ['q' => 'ما هي المدن التي تغطيها خدماتكم حالياً؟', 'a' => 'نغطي حالياً مدينة جدة بكافة أحيائها بالكامل، ونعمل على التوسع القريب في مكة المكرمة والرياض والدمام وباقي مدن المملكة العربية السعودية.'],
                ['q' => 'كيف يتم استلام نتائج الفحوصات المخبرية؟', 'a' => 'تُرسل النتائج إلكترونياً بصيغة PDF مشفرة على حسابك في المنصة وعلى بريدك الإلكتروني والواتساب فور صدورها من المختبر المعتمد.'],
                ['q' => 'ما هي طرق الدفع المتاحة؟', 'a' => 'ندعم الدفع عبر مدى، فيزا، ماستركارد، Apple Pay، بالإضافة إلى خيارات الدفع الآجل عبر تابي وتمارا. جميع المعاملات مشفرة وآمنة بالكامل.'],
                ['q' => 'هل يمكنني إلغاء أو تعديل موعد الحجز؟', 'a' => 'نعم، يمكنك إلغاء أو إعادة جدولة موعد حجزك من حسابك الشخصي على الموقع أو بالتواصل مع خدمة العملاء قبل 24 ساعة من الموعد المحدد دون أي رسوم إضافية.'],
            ];
            @endphp
            <div class="space-y-4" x-data="{ active: 1 }">
                @foreach($allFaqs as $i => $faq)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-soft overflow-hidden hover:border-medical-200/60 transition-colors">
                    <button @click="active = active === {{ $i+1 }} ? null : {{ $i+1 }}" class="w-full p-5 text-right font-bold text-primary flex items-center justify-between gap-3 text-sm sm:text-base hover:text-accent transition-colors">
                        <span>{{ $faq['q'] }}</span>
                        <div class="w-8 h-8 rounded-lg shrink-0 flex items-center justify-center transition-all duration-300" :class="active === {{ $i+1 }} ? 'bg-accent text-white rotate-45' : 'bg-medical-50 text-accent'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </div>
                    </button>
                    <div x-show="active === {{ $i+1 }}" x-collapse class="px-5 pb-5 text-sm text-gray-600 leading-[1.9] border-t border-gray-100 pt-3">{{ $faq['a'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>
