<x-app-layout title="الخدمات الطبية المنزلية | سيما الخليج">

    {{-- =================== HERO BANNER =================== --}}
    <section class="relative py-16 sm:py-20 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/3 -translate-y-1/2 w-96 h-96 bg-accent/10 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 32px 32px;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-4">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-bold text-medical-100">
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 01-2-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span>كتالوج الخدمات الطبية الشاملة</span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                الخدمات الطبية المنزلية <span class="text-accent">في راحة منزلك</span>
            </h1>

            <p class="text-medical-200 text-sm sm:text-base max-w-3xl mx-auto leading-relaxed">
                تصفح كافة خدماتنا الطبية المتخصصة المتاحة للحجز المباشر بالمنزل بإشراف كوادر طبية مرخّصة رسمياً من الهيئة السعودية للتخصصات الصحية.
            </p>
        </div>
    </section>

    {{-- =================== SERVICES CATALOG =================== --}}
    <section class="py-12 lg:py-16 bg-surface" x-data="{ activeTab: 'all', search: '' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Category Filter Tabs & Search Bar --}}
            <div class="bg-white p-4 rounded-2xl shadow-soft border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
                
                {{-- Category Buttons --}}
                <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                    <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">الكل (9)</button>
                    <button @click="activeTab = 'nursing'" :class="activeTab === 'nursing' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">تمريض ورعاية</button>
                    <button @click="activeTab = 'doctors'" :class="activeTab === 'doctors' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">أطباء واستشاريون</button>
                    <button @click="activeTab = 'physio'" :class="activeTab === 'physio' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">علاج طبيعي</button>
                    <button @click="activeTab = 'labs'" :class="activeTab === 'labs' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">فحوصات ومختبر</button>
                    <button @click="activeTab = 'corporate'" :class="activeTab === 'corporate' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">شركات</button>
                </div>

                {{-- Search Box --}}
                <div class="relative w-full md:w-64">
                    <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" x-model="search" placeholder="ابحث عن خدمة..." class="w-full pr-10 pl-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary focus:bg-white transition-all">
                </div>

            </div>

            @php
            $allServices = [
                [
                    'id' => 'care',
                    'cat' => 'nursing',
                    'cat_label' => 'تمريض ورعاية',
                    'img' => 'service-care.png',
                    'title' => 'الرعاية الصحية المنزلية',
                    'modal_title' => 'الرعاية الصحية المنزلية',
                    'desc' => 'برامج مخصصة ومستمرة لكبار السن والمرضى ذوي الأمراض المزمنة في بيئة أسرية دافئة.',
                    'price' => 'تبدأ من 250 ر.س',
                    'benefits' => ['متابعة يومية كاملة', 'تغذية وعناية بالأدوية', 'دعم نفسي وتأهيلي']
                ],
                [
                    'id' => 'doctors',
                    'cat' => 'doctors',
                    'cat_label' => 'أطباء واستشاريون',
                    'img' => 'service-doctor.png',
                    'title' => 'الزيارات الطبية المنزلية',
                    'modal_title' => 'الزيارات الطبية المنزلية',
                    'desc' => 'أطباء واستشاريون يصلون لمنزلك لمعاينة المريض وتشخيص الحالة ووصف العلاجات الخطية والالكترونية.',
                    'price' => 'تبدأ من 300 ر.س',
                    'benefits' => ['فحص سريري كامل', 'الوصفات والتقارير الطبية', 'خطة علاجية مخصصة']
                ],
                [
                    'id' => 'nursing',
                    'cat' => 'nursing',
                    'cat_label' => 'تمريض ورعاية',
                    'img' => 'service-nursing.png',
                    'title' => 'التمريض المنزلي 24/7',
                    'modal_title' => 'التمريض المنزلي 24/7',
                    'desc' => 'خدمات تمريضية متواصلة (12 أو 24 ساعة) للعناية بالجروح، تركيب المحاليل، والمؤشرات الحيوية.',
                    'price' => 'تغطية 12/24 ساعة',
                    'benefits' => ['عناية تمريضية مستمرة', 'غيار الجروح والحروق', 'تركيب القساطر والمغذيات']
                ],
                [
                    'id' => 'physio',
                    'cat' => 'physio',
                    'cat_label' => 'علاج طبيعي',
                    'img' => 'service-physio.png',
                    'title' => 'العلاج الطبيعي والتأهيل',
                    'modal_title' => 'العلاج الطبيعي والتأهيل',
                    'desc' => 'جلسات تأهيل حركي وتطوير القدرات الجسدية لما بعد العمليات الجراحية والجلطات وإصابات العظام.',
                    'price' => 'جلسات فردية وباقات',
                    'benefits' => ['تأهيل حركي مخصص', 'أحدث الأجهزة المتنقلة', 'برنامج متابعة دوري']
                ],
                [
                    'id' => 'sampling',
                    'cat' => 'labs',
                    'cat_label' => 'فحوصات ومختبر',
                    'img' => 'service-sampling.png',
                    'title' => 'سحب العينات المنزلي',
                    'modal_title' => 'سحب العينات المنزلي',
                    'desc' => 'أخصائي سحب عينات يحضر لمنزلك بآلية سحب مريحة وبدون ألم مع إرسال النتائج إلكترونياً.',
                    'price' => 'نتائج سريعة',
                    'benefits' => ['سحب آمن ومعقم', 'حفظ العينات بمعايير عالمية', 'نتائج PDF مشفرة']
                ],
                [
                    'id' => 'labs',
                    'cat' => 'labs',
                    'cat_label' => 'فحوصات ومختبر',
                    'img' => 'service-lab.png',
                    'title' => 'الفحوصات المخبرية الشاملة',
                    'modal_title' => 'الفحوصات المخبرية الشاملة',
                    'desc' => 'باقات تحاليل وقائية شاملة: الكلى، الكبد، السكر، الفيتامينات، الهرمونات، والدهون الثلاثية.',
                    'price' => 'باقات بخصم 30%',
                    'benefits' => ['باقات صحية متكاملة', 'مختبرات مرخصة ومعتمدة', 'استشارة مجانية مع النتائج']
                ],
                [
                    'id' => 'genetics',
                    'cat' => 'labs',
                    'cat_label' => 'فحوصات ومختبر',
                    'img' => 'service-dna.png',
                    'title' => 'الفحوصات الجينية والوراثية',
                    'modal_title' => 'الفحوصات الجينية والوراثية',
                    'desc' => 'تحاليل البصمة الجينية وDNA للكشف المبكر عن الأمراض الوراثية بأحدث تقنيات التسلسل الجيني.',
                    'price' => 'دقة فائقة وسرية',
                    'benefits' => ['دقة عالية جداً', 'سرية تامة للبيانات', 'تقرير وراثي طبي مفصل']
                ],
                [
                    'id' => 'consultation',
                    'cat' => 'doctors',
                    'cat_label' => 'أطباء واستشاريون',
                    'img' => 'service-telehealth.png',
                    'title' => 'الاستشارات الطبية',
                    'modal_title' => 'الاستشارات الطبية',
                    'desc' => 'استشارات مرئية وهاتفية فورية مع استشاريين متميزين لمتابعة حالتك الصحية وتعديل خطتك العلاجية.',
                    'price' => 'مواعيد مرنة',
                    'benefits' => ['استشارة مرئية مباشرة', 'مواعيد فورية وبدون انتظار', 'متابعة ما بعد الاستشارة']
                ],
                [
                    'id' => 'corporate',
                    'cat' => 'corporate',
                    'cat_label' => 'شركات',
                    'img' => 'service-corporate.png',
                    'title' => 'خدمات الرعاية للشركات',
                    'modal_title' => 'خدمات الرعاية للشركات',
                    'desc' => 'تجهيز عيادات موقعية بالشركات، فحوصات دورية للموظفين، وتغطية طبية شاملة للفعاليات والمؤتمرات.',
                    'price' => 'عقود خاصة',
                    'benefits' => ['عيادات داخل مقر العمل', 'فحوصات الموظفين الدورية', 'تغطية الفعاليات والمؤتمرات']
                ],
            ];
            @endphp

            {{-- Grid of 9 Services --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($allServices as $s)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-soft hover:shadow-card transition-all duration-300 overflow-hidden flex flex-col justify-between group"
                     x-show="(activeTab === 'all' || activeTab === '{{ $s['cat'] }}') && (search.trim() === '' || '{{ $s['title'] }} {{ $s['desc'] }}'.includes(search.trim()))">
                    
                    <div>
                        {{-- Image Banner with Overlay --}}
                        <div class="relative h-44 overflow-hidden">
                            <img src="{{ asset('images/' . $s['img']) }}" alt="{{ $s['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" style="object-position: center 25%;">
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/85 via-primary/40 to-transparent"></div>
                            
                            <span class="absolute top-3 right-3 px-3 py-1 bg-white/90 backdrop-blur-md text-primary font-bold text-[10px] rounded-lg shadow-sm">
                                {{ $s['cat_label'] }}
                            </span>

                            <span class="absolute bottom-3 right-3 px-3 py-1 bg-accent text-white font-bold text-[11px] rounded-lg shadow-md border border-white/20">
                                {{ $s['price'] }}
                            </span>
                        </div>

                        {{-- Card Content --}}
                        <div class="p-5 space-y-3">
                            <h3 class="font-black text-primary text-base group-hover:text-accent transition-colors">{{ $s['title'] }}</h3>
                            <p class="text-xs text-gray-500 leading-relaxed">{{ $s['desc'] }}</p>

                            {{-- Benefits Checklist --}}
                            <div class="pt-1 space-y-1.5">
                                @foreach($s['benefits'] as $b)
                                <div class="flex items-center gap-2 text-[11px] text-gray-600 font-medium">
                                    <svg class="w-3.5 h-3.5 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    <span>{{ $b }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="px-5 pb-5 pt-2 border-t border-gray-50">
                        <button @click="selectedService = '{{ $s['modal_title'] }}'; callbackModalOpen = true" class="w-full btn-accent py-2.5 rounded-xl font-bold text-xs shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <span>احجز هذه الخدمة الآن</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>

                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- =================== WHY CHOOSE US =================== --}}
    <section class="py-12 lg:py-16 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
                <div class="section-badge mx-auto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>معايير الجودة</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-primary">لماذا تختار خدمات سيما الخليج الطبية؟</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 rounded-2xl bg-surface border border-gray-100 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-accent/10 text-accent flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-bold text-base text-primary">كوادر مرخّصة رسمياً</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">جميع أطبائنا وممرضينا يحملون تراخيص سارية من الهيئة السعودية للتخصصات الصحية.</p>
                </div>

                <div class="p-6 rounded-2xl bg-surface border border-gray-100 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-accent/10 text-accent flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-base text-primary">سرعة وانضباط في المواعيد</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">نلتزم بالوصول لمنزلك في الوقت المحدد مع خدمات استجابة فورية 24/7.</p>
                </div>

                <div class="p-6 rounded-2xl bg-surface border border-gray-100 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-accent/10 text-accent flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="font-bold text-base text-primary">خصوصية وأمان تام</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">حماية كاملة لسجلاتك الطبية وبياناتك الشخصية وفق أعلى المعايير القانونية.</p>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
