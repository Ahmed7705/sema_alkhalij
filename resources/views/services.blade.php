<x-app-layout title="الخدمات الطبية | سيما الخليج">
    {{-- Hero --}}
    <section class="bg-gradient-to-br from-primary to-primary-dark text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="max-w-7xl mx-auto px-4 text-center relative z-10 space-y-4">
            <div class="section-badge mx-auto bg-white/10 border-white/20 text-medical-100">
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span>كتالوج الخدمات الطبية</span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-black">الخدمات الطبية المنزلية</h1>
            <p class="text-medical-200 max-w-xl mx-auto">تصفح كافة خدماتنا المتاحة للحجز المباشر في راحة منزلك</p>
        </div>
    </section>

    <section class="py-16 bg-surface">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            {{-- Filters --}}
            <div class="bg-white p-4 rounded-2xl shadow-soft flex flex-wrap items-center justify-between gap-4 border border-gray-100">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs font-bold text-gray-400">التصنيف:</span>
                    @foreach(['الكل', 'تمريض', 'زيارات أطباء', 'علاج طبيعي', 'فحوصات'] as $i => $cat)
                    <button class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ $i === 0 ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600' }}">{{ $cat }}</button>
                    @endforeach
                </div>
                <div class="relative w-full sm:w-72">
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" placeholder="ابحث عن خدمة..." class="w-full pr-10 pl-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary focus:bg-white transition-all">
                </div>
            </div>

            @php
            $servicesList = [
                ['cat' => 'تمريض ورعاية', 'title' => 'التمريض المنزلي الشامل (24/7)', 'desc' => 'رعاية تمريضية مستمرة يومية أو بالساعة للحالات الحرجة وكبار السن وما بعد العمليات.', 'price' => '250 ر.س / الزيارة'],
                ['cat' => 'أطباء واستشاريون', 'title' => 'زيارة طبيب عام / استشاري', 'desc' => 'فحص وتشخيص طبي شامل في المنزل مع وصف الأدوية وطلب الفحوصات اللازمة.', 'price' => '300 ر.س / الزيارة'],
                ['cat' => 'تأهيل طبيعي', 'title' => 'جلسات العلاج الطبيعي والتأهيل', 'desc' => 'برامج مخصصة لحالات التأهيل الحركي والجلطات وآلام العظام بمعدات حديثة.', 'price' => '280 ر.س / الجلسة'],
                ['cat' => 'مختبر منزلي', 'title' => 'سحب عينات الدم والتحاليل', 'desc' => 'سحب عينات منزلي مريح مع إرسال النتائج إلكترونياً باحترافية وسرعة.', 'price' => '120 ر.س / الخدمة'],
                ['cat' => 'جينات ووراثة', 'title' => 'الفحوصات الجينية والوراثية', 'desc' => 'تحاليل البصمة الجينية والأمراض الوراثية بأحدث تقنيات التسلسل الجيني.', 'price' => 'حسب الباقة'],
                ['cat' => 'شركات ومؤسسات', 'title' => 'خدمات الرعاية الطبية للشركات', 'desc' => 'عيادات مجهزة ومسح صحي دوري للموظفين وتغطية الفعاليات والمؤتمرات.', 'price' => 'عقود خاصة'],
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($servicesList as $s)
                <div class="medical-card p-6 flex flex-col justify-between space-y-5 group">
                    <div class="space-y-3">
                        <span class="text-[11px] font-bold text-accent bg-medical-50 px-3 py-1 rounded-full">{{ $s['cat'] }}</span>
                        <h3 class="font-bold text-lg text-primary group-hover:text-accent transition-colors">{{ $s['title'] }}</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $s['desc'] }}</p>
                        <div class="text-sm font-black text-primary">{{ $s['price'] }}</div>
                    </div>
                    <button @click="callbackModalOpen = true" class="w-full btn-accent py-3 rounded-xl text-xs font-bold">احجز هذه الخدمة</button>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>
