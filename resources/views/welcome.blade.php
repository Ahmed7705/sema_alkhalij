<x-app-layout>

    {{-- =================== HERO SLIDER =================== --}}
    <section class="relative h-[85vh] min-h-[550px] max-h-[800px] overflow-hidden" x-data="{ slide: 1 }" x-init="setInterval(() => slide = slide === 3 ? 1 : slide + 1, 6000)">

        {{-- Background Slides --}}
        <div class="absolute inset-0">
            <div class="absolute inset-0 transition-all duration-[1500ms] ease-in-out"
                 :class="slide === 1 ? 'opacity-100 scale-100' : 'opacity-0 scale-110'">
                <img src="{{ asset('images/hero-doctor.png') }}" alt="زيارة طبيب منزلية" class="w-full h-full object-cover" style="object-position: center 20%;">
            </div>
            <div class="absolute inset-0 transition-all duration-[1500ms] ease-in-out"
                 :class="slide === 2 ? 'opacity-100 scale-100' : 'opacity-0 scale-110'">
                <img src="{{ asset('images/nurse-care.png') }}" alt="تمريض منزلي" class="w-full h-full object-cover" style="object-position: center 20%;">
            </div>
            <div class="absolute inset-0 transition-all duration-[1500ms] ease-in-out"
                 :class="slide === 3 ? 'opacity-100 scale-100' : 'opacity-0 scale-110'">
                <img src="{{ asset('images/physio-session.png') }}" alt="علاج طبيعي" class="w-full h-full object-cover" style="object-position: center 20%;">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#071f18]/90 via-primary/50 to-primary/30"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 h-full flex flex-col justify-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-24">

                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white/[0.1] backdrop-blur-xl border border-white/[0.15] text-xs font-bold text-white/90 mb-4">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute h-full w-full rounded-full bg-accent opacity-75"></span>
                        <span class="relative rounded-full h-2 w-2 bg-accent"></span>
                    </span>
                    خدمات رعاية صحية منزلية متخصصة في المملكة العربية السعودية
                </div>

                <p class="text-medical-200 text-sm sm:text-base mb-2">رعاية طبية على مدار الساعة</p>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-black text-white leading-[1.1] tracking-tight mb-4 min-h-[70px]">
                    <span x-show="slide === 1" x-transition.duration.700ms>ملتزمون برعايتكم</span>
                    <span x-show="slide === 2" x-transition.duration.700ms>تمريض منزلي متواصل</span>
                    <span x-show="slide === 3" x-transition.duration.700ms>تأهيل طبيعي متقدم</span>
                </h1>

                <p class="text-lg sm:text-xl text-accent font-bold mb-6 min-h-[30px]">
                    <span x-show="slide === 1" x-transition.duration.700ms>رعاية طبية متميزة تمتد إلى منزلك</span>
                    <span x-show="slide === 2" x-transition.duration.700ms>فريق تمريضي متخصص على مدار 24 ساعة</span>
                    <span x-show="slide === 3" x-transition.duration.700ms>جلسات تأهيل حركي متخصصة في المنزل</span>
                </p>

                <div class="flex flex-wrap gap-3 mb-4">
                    <button @click="selectedService = ''; callbackModalOpen = true" class="inline-flex items-center gap-2 px-7 py-3.5 bg-white text-primary font-black text-sm rounded-xl shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        طلب معاودة الاتصال
                    </button>
                    <a href="{{ url('/services') }}" class="inline-flex items-center gap-2 px-7 py-3.5 bg-accent text-white font-bold text-sm rounded-xl shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                        تصفح خدماتنا
                    </a>
                    <a href="https://wa.me/966545880082" target="_blank" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl border-2 border-white/25 text-white font-bold hover:bg-white/10 transition-all duration-300 text-sm">
                        <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.157 4.228 4.305-1.129z"/></svg>
                        واتساب
                    </a>
                </div>

                <div class="flex gap-2">
                    <template x-for="i in 3" :key="i">
                        <button @click="slide = i" class="h-1 rounded-full transition-all duration-500" :class="slide === i ? 'w-8 bg-accent' : 'w-5 bg-white/30 hover:bg-white/50'"></button>
                    </template>
                </div>
            </div>
        </div>

        {{-- Search Bar --}}
        <div class="absolute bottom-4 left-0 right-0 z-20 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto bg-white/95 backdrop-blur-lg rounded-2xl p-3 sm:p-4 shadow-[0_10px_30px_rgba(0,0,0,0.18)] border border-white/80">
                <div class="flex flex-col sm:flex-row items-stretch gap-3">
                    <div class="flex-1">
                        <label class="block text-[10px] font-bold text-gray-500 mb-1 px-1">المدينة</label>
                        <select class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-700 focus:outline-none focus:border-accent transition-all cursor-pointer">
                            <option>جدة</option>
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-[10px] font-bold text-gray-500 mb-1 px-1">الخدمة المطلوبة</label>
                        <select class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-gray-700 focus:outline-none focus:border-accent transition-all cursor-pointer">
                            <option>جميع الخدمات</option>
                            <option>تمريض منزلي</option>
                            <option>زيارة طبيب</option>
                            <option>علاج طبيعي</option>
                            <option>فحوصات مخبرية</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <a href="{{ url('/services') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-2 bg-accent text-white font-bold rounded-xl hover:bg-accent-hover shadow transition-all text-xs whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            ابحث الآن
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- =================== ABOUT BRIEF =================== --}}
    <section class="py-12 lg:py-16 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-center">
                <div class="relative">
                    <div class="relative">
                        <img src="{{ asset('images/medical-team.png') }}" alt="فريق سيما الخليج الطبي" class="w-full rounded-2xl shadow-card object-cover aspect-[4/3]">
                        <div class="absolute -z-10 -top-3 -right-3 w-full h-full rounded-2xl bg-accent/10 border-2 border-accent/20"></div>
                    </div>
                    <div class="absolute -bottom-4 left-4 bg-white py-3 px-5 rounded-xl shadow-floating border border-gray-100 text-right">
                        <span class="block text-3xl font-black text-accent leading-none">+10</span>
                        <span class="text-[11px] font-bold text-gray-600 mt-0.5 block">أعوام من الخبرة والتميز</span>
                    </div>
                    <div class="absolute -top-3 left-3 bg-primary text-white py-2.5 px-4 rounded-xl shadow-floating">
                        <span class="block text-xl font-black text-accent leading-none">+15K</span>
                        <span class="text-[10px] text-medical-200 block">زيارة منزلية ناجحة</span>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="section-badge">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>من نحن</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-primary leading-tight">نعتني بصحتك وعائلتك<br>بأعلى مستويات <span class="text-accent">الاحترافية</span></h2>
                    <p class="text-gray-600 text-sm leading-[1.8]">شركة سيما الخليج للخدمات الطبية من الشركات الرائدة في تقديم خدمات الرعاية الصحية المنزلية الشاملة بالمملكة العربية السعودية. نوفّر بيئة استشفاء آمنة ومريحة للمرضى في منازلهم عبر فريق طبي متكامل بأحدث الأدوات والتقنيات.</p>
                    <div class="grid grid-cols-3 gap-3">
                        <div class="text-center p-3 rounded-xl bg-surface border border-gray-100">
                            <span class="text-xl font-black text-primary block">99.2%</span>
                            <span class="text-[10px] text-gray-400 font-bold">نسبة رضا العملاء</span>
                        </div>
                        <div class="text-center p-3 rounded-xl bg-surface border border-gray-100">
                            <span class="text-xl font-black text-accent block">+50</span>
                            <span class="text-[10px] text-gray-400 font-bold">كادر طبي متخصص</span>
                        </div>
                        <div class="text-center p-3 rounded-xl bg-surface border border-gray-100">
                            <span class="text-xl font-black text-primary block">24/7</span>
                            <span class="text-[10px] text-gray-400 font-bold">تغطية واستجابة</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3 pt-1">
                        <a href="{{ url('/about') }}" class="btn-primary py-2.5 px-6 rounded-xl text-xs">تعرّف على المزيد <svg class="w-3.5 h-3.5 mr-1 inline" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></a>
                        <a href="{{ url('/contact') }}" class="btn-outline py-2.5 px-6 rounded-xl text-xs">تواصل معنا</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- =================== 9 SERVICES =================== --}}
    <section class="py-12 lg:py-16 bg-surface">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
                <div class="section-badge mx-auto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span>خدماتنا الطبية</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-primary">حلول رعاية صحية متكاملة في منزلك</h2>
                <p class="text-xs text-gray-500">نُقدّم 9 خدمات طبية متخصصة يقوم بها كوادر مرخّصة بأعلى معايير الجودة</p>
            </div>

            @php
            $services = [
                [
                    'img' => 'service-care.png',
                    'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                    'title' => 'الرعاية الصحية المنزلية',
                    'desc' => 'برامج مخصصة لكبار السن وأصحاب الأمراض المزمنة في بيئة منزلية دافئة وآمنة.',
                    'price' => 'تبدأ من 250 ر.س',
                    'gradient' => 'from-emerald-950/85 via-primary/60 to-transparent'
                ],
                [
                    'img' => 'service-doctor.png',
                    'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                    'title' => 'الزيارات الطبية المنزلية',
                    'desc' => 'أطباء واستشاريون لمعاينة المريض، التشخيص الدقيق، ووصف العلاج في المنزل.',
                    'price' => 'تبدأ من 300 ر.س',
                    'gradient' => 'from-teal-950/85 via-primary/60 to-transparent'
                ],
                [
                    'img' => 'service-nursing.png',
                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                    'title' => 'التمريض المنزلي 24/7',
                    'desc' => 'رعاية تمريضية متواصلة، متابعة العلامات الحيوية، العناية بالجروح والمغذيات.',
                    'price' => 'تغطية 12/24 ساعة',
                    'gradient' => 'from-cyan-950/85 via-primary/60 to-transparent'
                ],
                [
                    'img' => 'service-physio.png',
                    'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                    'title' => 'العلاج الطبيعي والتأهيل',
                    'desc' => 'جلسات تأهيلية مخصصة لما بعد العمليات والجلطات وإصابات العظام والعضلات.',
                    'price' => 'جلسات فردية وباقات',
                    'gradient' => 'from-green-950/85 via-primary/60 to-transparent'
                ],
                [
                    'img' => 'service-sampling.png',
                    'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                    'title' => 'سحب العينات المنزلي',
                    'desc' => 'أخصائي سحب عينات يحضر لمنزلك بأدوات معقمة مع نتائج إلكترونية سريعة.',
                    'price' => 'نتائج سريعة',
                    'gradient' => 'from-emerald-950/85 via-primary/60 to-transparent'
                ],
                [
                    'img' => 'service-lab.png',
                    'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                    'title' => 'الفحوصات المخبرية الشاملة',
                    'desc' => 'باقات فحوصات وقائية شاملة: الوظائف، الفيتامينات، الدهون، والسكر بنسب دقيقة.',
                    'price' => 'باقات بخصم 30%',
                    'gradient' => 'from-teal-950/85 via-primary/60 to-transparent'
                ],
                [
                    'img' => 'service-dna.png',
                    'icon' => 'M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457-.39-2.823-1.07-4',
                    'title' => 'الفحوصات الجينية والوراثية',
                    'desc' => 'تحاليل DNA وبصمة جينية وكشف مبكر عن الأمراض الوراثية بأعلى سرية.',
                    'price' => 'دقة فائقة وسرية',
                    'gradient' => 'from-slate-950/85 via-primary/60 to-transparent'
                ],
                [
                    'img' => 'service-telehealth.png',
                    'icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
                    'title' => 'الاستشارات الطبية',
                    'desc' => 'استشارات طارئة ومرئية هاتفية مع استشاريين متميزين لمتابعة حالتك الصحّية.',
                    'price' => 'مواعيد مرنة',
                    'gradient' => 'from-cyan-950/80 via-primary/60 to-transparent'
                ],
                [
                    'img' => 'medical-team.png',
                    'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                    'title' => 'خدمات الرعاية للشركات', 'desc' => 'تجهيز عيادات موقعية، فحوصات دورية للموظفين، وتغطية الفعاليات والمؤتمرات.',
                    'price' => 'عقود خاصة',
                    'gradient' => 'from-emerald-900/80 via-primary/60 to-transparent'
                ],
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                <div class="medical-card group border border-gray-100 hover:border-accent/40 shadow-soft hover:shadow-card transition-all duration-300 rounded-2xl overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="relative h-44 overflow-hidden">
                            <img src="{{ asset('images/' . $service['img']) }}" alt="{{ $service['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" style="object-position: center 25%;">
                            <div class="absolute inset-0 bg-gradient-to-t {{ $service['gradient'] }}"></div>
                            <span class="absolute bottom-3 right-3 px-3 py-1 bg-accent text-white text-[11px] font-bold rounded-lg shadow-md border border-white/20">{{ $service['price'] }}</span>
                            <div class="absolute top-3 left-3 w-9 h-9 rounded-xl bg-white/90 backdrop-blur-md text-primary flex items-center justify-center shadow-sm">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $service['icon'] }}"/></svg>
                            </div>
                        </div>
                        <div class="p-5 space-y-2.5">
                            <h3 class="font-black text-primary text-base group-hover:text-accent transition-colors">{{ $service['title'] }}</h3>
                            <p class="text-xs text-gray-500 leading-relaxed">{{ $service['desc'] }}</p>
                        </div>
                    </div>
                    <div class="px-5 pb-5 pt-2 flex items-center justify-between border-t border-gray-50 mt-2">
                        <a href="{{ url('/services') }}" class="text-xs font-bold text-primary hover:text-accent transition-colors flex items-center gap-1">
                            <span>التفاصيل</span>
                            <svg class="w-3 h-3 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                        <button @click="selectedService = '{{ $service['title'] }}'; callbackModalOpen = true" class="btn-accent text-xs py-2 px-4 rounded-xl shadow-md hover:shadow-lg transition-all font-bold">احجز الآن</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- =================== WHY CHOOSE US =================== --}}
    <section class="py-12 lg:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
                <div class="section-badge mx-auto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>لماذا سيما الخليج</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-primary">مزايا تجعلنا الخيار الأول في الرعاية المنزلية</h2>
            </div>

            @php
            $advantages = [
                ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'فريق مؤهل ومرخّص', 'desc' => 'جميع أطبائنا وممرضينا بتراخيص سارية من الهيئة السعودية للتخصصات الصحية.'],
                ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'سرعة الاستجابة', 'desc' => 'نصلك وفق الموعد المحدد بانضباط تام ونوفر خدمة طوارئ على مدار الساعة.'],
                ['icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'title' => 'أحدث المعدات الطبية', 'desc' => 'أجهزة حديثة ومختبرات متنقلة تضمن دقة التشخيص والعلاج.'],
                ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'title' => 'خصوصية وسرية تامة', 'desc' => 'نحافظ على سجلاتك الطبية وبياناتك الشخصية بسرية مطلقة.'],
                ['icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'شراكات دولية معتمدة', 'desc' => 'تعاون مع كبرى المراكز الطبية والمختبرات العالمية.'],
                ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'أسعار شفافة وتنافسية', 'desc' => 'تسعير واضح بدون رسوم مخفية مع خيارات دفع متعددة.'],
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($advantages as $adv)
                <div class="p-5 rounded-2xl bg-surface border border-gray-100 hover:shadow-card hover:border-accent/30 transition-all duration-300 group">
                    <div class="w-11 h-11 rounded-xl bg-accent/10 text-accent flex items-center justify-center mb-3 group-hover:bg-accent group-hover:text-white transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $adv['icon'] }}"/></svg>
                    </div>
                    <h3 class="font-bold text-base text-primary mb-1">{{ $adv['title'] }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $adv['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- =================== STATS =================== --}}
    <section class="relative py-12 overflow-hidden">
        <img src="{{ asset('images/hero-doctor.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover" style="object-position: center 25%;">
        <div class="absolute inset-0 bg-primary/85"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 text-center">
                @foreach([
                    ['+15,000', 'زيارة منزلية ناجحة'],
                    ['99.2%', 'نسبة رضا المرضى'],
                    ['+50', 'طبيب وممرض'],
                    ['24/7', 'تغطية فورية'],
                    ['+120', 'فحص مخبري وجيني'],
                    ['100%', 'معتمدون ومرخّصون'],
                ] as $stat)
                <div class="space-y-1">
                    <span class="text-2xl sm:text-3xl font-black text-accent block">{{ $stat[0] }}</span>
                    <span class="text-[11px] text-medical-200 block">{{ $stat[1] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- =================== TESTIMONIALS =================== --}}
    <section class="py-12 lg:py-16 bg-surface">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
                <div class="section-badge mx-auto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <span>شهادات العملاء</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-primary">ماذا يقول عملاؤنا عن خدماتنا؟</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach([
                    ['text' => 'خدمة ممتازة جداً! تم طلب زيارة تمريضية لوالدي بعد العملية، وصل الممرض في الوقت المحدد وكان على قدر كبير من الاحترافية.', 'name' => 'أحمد الغامدي', 'loc' => 'جدة - حي الشاطئ', 'avatar' => 'أ'],
                    ['text' => 'تجربة سحب عينات الدم في المنزل كانت مريحة للغاية. نتائج التحاليل أُرسلت بسرعة فائقة ودقة عالية.', 'name' => 'سارة الشهري', 'loc' => 'جدة - حي الرويس', 'avatar' => 'س'],
                    ['text' => 'جلسات العلاج الطبيعي أحدثت فرقاً كبيراً في تحسن حركة والدي. التزام بالمواعيد ومعاملة راقية.', 'name' => 'د. خالد المطيري', 'loc' => 'جدة - حي النعيم', 'avatar' => 'خ'],
                ] as $t)
                <div class="p-5 rounded-2xl bg-white border border-gray-100 shadow-soft space-y-4 hover:shadow-card transition-all duration-300">
                    <div class="flex text-amber-400 gap-0.5 text-sm">★★★★★</div>
                    <p class="text-xs text-gray-600 leading-[1.8]">"{{ $t['text'] }}"</p>
                    <div class="pt-3 border-t border-gray-100 flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xs">{{ $t['avatar'] }}</div>
                        <div>
                            <span class="block font-bold text-primary text-xs">{{ $t['name'] }}</span>
                            <span class="text-[10px] text-gray-400">{{ $t['loc'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- =================== FAQ =================== --}}
    <section class="py-12 lg:py-16 bg-white border-t border-gray-100" x-data="{ active: 1 }">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-2 mb-10">
                <div class="section-badge mx-auto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>أسئلة شائعة</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-primary">إجابات على أبرز تساؤلاتكم</h2>
            </div>

            @php
            $faqs = [
                ['q' => 'كيف يمكنني حجز زيارة طبية منزلية؟', 'a' => 'اختر الخدمة المطلوبة من موقعنا، حدد التاريخ والوقت والمدينة، أو اضغط "اطلب معاودة اتصال" وسيتواصل فريقنا معك فوراً لتأكيد الحجز.'],
                ['q' => 'هل الكادر الطبي مرخّص ومعتمد رسمياً؟', 'a' => 'نعم، جميع أطبائنا وممرضينا وأخصائيينا يحملون تراخيص سارية من الهيئة السعودية للتخصصات الصحية.'],
                ['q' => 'ما هي المدن التي تغطيها خدماتكم؟', 'a' => 'نغطي حالياً مدينة جدة بكافة أحيائها بالكامل، ونعمل على التوسع قريباً.'],
                ['q' => 'كيف أستلم نتائج الفحوصات المخبرية؟', 'a' => 'تُرسل النتائج إلكترونياً بصيغة PDF مشفرة على حسابك وبريدك والواتساب فور صدورها.'],
            ];
            @endphp

            <div class="space-y-3">
                @foreach($faqs as $i => $faq)
                <div class="bg-surface rounded-xl border border-gray-100 overflow-hidden hover:border-accent/30 transition-colors">
                    <button @click="active = active === {{ $i+1 }} ? null : {{ $i+1 }}" class="w-full p-4 text-right font-bold text-primary flex items-center justify-between gap-3 text-xs sm:text-sm hover:text-accent transition-colors">
                        <span>{{ $faq['q'] }}</span>
                        <div class="w-7 h-7 rounded-lg shrink-0 flex items-center justify-center transition-all duration-300" :class="active === {{ $i+1 }} ? 'bg-accent text-white rotate-45' : 'bg-medical-50 text-accent'">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </div>
                    </button>
                    <div x-show="active === {{ $i+1 }}" x-collapse class="px-4 pb-4 text-xs text-gray-600 leading-[1.8] border-t border-gray-100 pt-2.5">{{ $faq['a'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- =================== FINAL CTA =================== --}}
    <section class="relative py-16 overflow-hidden">
        <img src="{{ asset('images/nurse-care.png') }}" alt="" class="absolute inset-0 w-full h-full object-cover" style="object-position: center 25%;">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/95 via-primary/85 to-primary/95"></div>
        <div class="max-w-4xl mx-auto px-4 text-center space-y-5 relative z-10">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-tight">جاهز للحصول على<br>أفضل رعاية صحية في منزلك؟</h2>
            <p class="text-medical-200 text-sm max-w-xl mx-auto">فريقنا الطبي مستعد لخدمتك ورعاية أحبابك بأعلى درجات الاهتمام والاحترافية.</p>
            <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                <button @click="selectedService = ''; callbackModalOpen = true" class="inline-flex items-center gap-2 px-8 py-3.5 bg-accent text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    احجز خدمتك الآن
                </button>
                <a href="tel:+966545880082" class="inline-flex items-center gap-2 px-7 py-3.5 bg-white text-primary font-bold rounded-xl shadow hover:shadow-md transition-all text-sm">
                    <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span class="dir-ltr">+966 54 588 0082</span>
                </a>
            </div>
        </div>
    </section>

</x-app-layout>
