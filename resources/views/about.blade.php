<x-app-layout title="من نحن | سيما الخليج للخدمات الطبية">

    {{-- =================== HERO BANNER =================== --}}
    <section class="relative py-16 sm:py-20 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden">
        {{-- Background glow & pattern --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/4 -translate-y-1/2 w-96 h-96 bg-accent/10 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 32px 32px;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-4">
            {{-- Badge with Official Logo Icon --}}
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-bold text-medical-100">
                <img src="{{ asset('images/logo.png') }}" alt="" class="h-5 w-auto object-contain" onerror="this.style.display='none'">
                <span>عن شركة سيما الخليج للخدمات الطبية</span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                رعايتكم مسؤوليتنا... <span class="text-accent">وصحتكم أمانة نعتز بها</span>
            </h1>

            <p class="text-medical-200 text-sm sm:text-base max-w-3xl mx-auto leading-relaxed">
                المنظومة الأولى والرائدة في تقديم خدمات الرعاية الصحية المنزلية الشاملة بالمملكة العربية السعودية وفق أرفع معايير الجودة والوقاية الطبية.
            </p>
        </div>
    </section>

    {{-- =================== ABOUT BIO & TEAM IMAGE =================== --}}
    <section class="py-12 lg:py-16 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-center">
                
                {{-- Left Column: Medical Team Image & Badges --}}
                <div class="lg:col-span-5 relative">
                    <div class="relative">
                        <img src="{{ asset('images/medical-team.png') }}" alt="فريق سيما الخليج الطبي" class="w-full rounded-2xl shadow-card object-cover aspect-[4/3]">
                        <div class="absolute -z-10 -top-3 -right-3 w-full h-full rounded-2xl bg-accent/10 border-2 border-accent/20"></div>
                    </div>

                    {{-- Floating Experience Badge --}}
                    <div class="absolute -bottom-4 left-4 bg-white py-3 px-5 rounded-xl shadow-floating border border-gray-100 text-right">
                        <span class="block text-3xl font-black text-accent leading-none">+10</span>
                        <span class="text-[11px] font-bold text-gray-600 mt-0.5 block">سنوات من الخبرة والتميز</span>
                    </div>

                    {{-- Floating Visits Badge --}}
                    <div class="absolute -top-3 left-3 bg-primary text-white py-2.5 px-4 rounded-xl shadow-floating">
                        <span class="block text-xl font-black text-accent leading-none">+15,000</span>
                        <span class="text-[10px] text-medical-200 block">زيارة منزلية ناجحة</span>
                    </div>
                </div>

                {{-- Right Column: Company Story & Bio --}}
                <div class="lg:col-span-7 space-y-5">
                    <div class="section-badge">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>قصتنا ونشأتنا</span>
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-black text-primary leading-tight">
                        الرواد في تقديم الرعاية الطبية المنزلية المتكاملة
                    </h2>

                    <p class="text-gray-600 text-sm leading-[1.9]">
                        تأسست <strong>شركة سيما الخليج للخدمات الطبية</strong> لتكون الرفيق الموثوق لكل أسرة تبحث عن رعاية صحية منزلية متميزة في المملكة العربية السعودية. نحن نؤمن بأن البيت هو المكان الأكثر أماناً وراحة لاستشفاء المريض ورعايته بين أهله وذويه.
                    </p>

                    <p class="text-gray-600 text-sm leading-[1.9]">
                        نعمل بتراخيص رسمية سارية معتمدة من <strong>وزارة الصحة السعودية</strong> و<strong>الهيئة السعودية للتخصصات الصحية</strong>، وبإشراف نخبة من الأطباء الاستشاريين والممرضين وأخصائيي العلاج الطبيعي والمختبرات المتميزين.
                    </p>

                    {{-- Quick Highlights Grid --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2">
                        <div class="p-3 rounded-xl bg-surface border border-gray-100 flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-accent/10 text-accent flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="text-xs font-bold text-primary">كوادر مرخصة رسمياً</span>
                        </div>
                        <div class="p-3 rounded-xl bg-surface border border-gray-100 flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-accent/10 text-accent flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="text-xs font-bold text-primary">استجابة وتغطية 24/7</span>
                        </div>
                        <div class="p-3 rounded-xl bg-surface border border-gray-100 flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-lg bg-accent/10 text-accent flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <span class="text-xs font-bold text-primary">سرية وأمان PDPL</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- =================== VISION, MISSION, VALUES =================== --}}
    <section class="py-12 lg:py-16 bg-surface">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
                <div class="section-badge mx-auto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>ركائزنا الأساسية</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-primary">رؤيتنا ورسالتنا وقيمنا الجوهرية</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Vision Card --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-soft hover:shadow-card hover:border-accent/30 transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 rounded-xl bg-accent/10 text-accent flex items-center justify-center group-hover:bg-accent group-hover:text-white transition-all duration-300">
                        {{-- Eye Vision SVG Icon --}}
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-black text-lg text-primary">رؤيتنا</h3>
                    <p class="text-xs text-gray-600 leading-[1.9]">
                        أن نكون النموذج الأول والمفضل في قطاع الرعاية الصحية المنزلية بالخليج العربي بحلول عام 2030.
                    </p>
                </div>

                {{-- Mission Card --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-soft hover:shadow-card hover:border-accent/30 transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 rounded-xl bg-accent/10 text-accent flex items-center justify-center group-hover:bg-accent group-hover:text-white transition-all duration-300">
                        {{-- Target Mission SVG Icon --}}
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9"/>
                            <circle cx="12" cy="12" r="5"/>
                            <circle cx="12" cy="12" r="1" fill="currentColor"/>
                        </svg>
                    </div>
                    <h3 class="font-black text-lg text-primary">رسالتنا</h3>
                    <p class="text-xs text-gray-600 leading-[1.9]">
                        توفير رعاية صحية منزلية فائقة الجودة تضمن راحة المريض وكرامته واستقلاليته بأعلى معايير السلامة.
                    </p>
                </div>

                {{-- Values Card --}}
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-soft hover:shadow-card hover:border-accent/30 transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 rounded-xl bg-accent/10 text-accent flex items-center justify-center group-hover:bg-accent group-hover:text-white transition-all duration-300">
                        {{-- Star Values SVG Icon --}}
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </div>
                    <h3 class="font-black text-lg text-primary">قيمنا الجوهرية</h3>
                    <p class="text-xs text-gray-600 leading-[1.9]">
                        الرحمة، الأمانة، الاحترافية، السرية التامة، والتحديث المستمر لأحدث البروتوكولات العلاجية.
                    </p>
                </div>

            </div>
        </div>
    </section>

    {{-- =================== STRATEGIC OBJECTIVES =================== --}}
    <section class="py-12 lg:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
                <div class="section-badge mx-auto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>أهدافنا الاستراتيجية</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-primary">معايير التميز الطبي في سيما الخليج</h2>
            </div>

            @php
            $objectives = [
                [
                    'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                    'title' => 'اعتماد وتدريب مستمر',
                    'desc' => 'تأهيل الكوادر الطبية والتمريضية وتحديث معرفتهم ببروتوكولات وزارة الصحة بشكل دوري.'
                ],
                [
                    'icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                    'title' => 'تقنيات تشخيص متطورة',
                    'desc' => 'استخدام أحدث أجهزة الفحص والسحب المخبري المتنقلة لضمان سرعة ودقة نتائج التحاليل.'
                ],
                [
                    'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
                    'title' => 'أمان الخصوصية والبيانات',
                    'desc' => 'حماية السجلات الطبية والشخصية للمرضى وفق نظام حماية البيانات الشخصية PDPL.'
                ],
                [
                    'icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                    'title' => 'رضا وراحة المريض',
                    'desc' => 'توفير تجربة استشفاء منزلية مريحة تحافظ على كرامة المريض وتلبي احتياجات أسرته.'
                ]
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($objectives as $obj)
                <div class="p-5 rounded-2xl bg-surface border border-gray-100 hover:shadow-card transition-all duration-300 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-primary text-accent flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $obj['icon'] }}"/></svg>
                    </div>
                    <h3 class="font-bold text-base text-primary">{{ $obj['title'] }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ $obj['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- =================== FINAL CTA =================== --}}
    <section class="relative py-16 bg-gradient-to-r from-primary via-[#0d4435] to-primary text-white text-center overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 space-y-5 relative z-10">
            <h2 class="text-2xl sm:text-3xl font-black">جاهزون لتقديم أفضل خدمة رعاية صحية لمنزلك</h2>
            <p class="text-medical-200 text-xs sm:text-sm max-w-xl mx-auto">تواصل معنا اليوم لحجز زيارة منزلية أو الاستفسار عن باقات الخدمات الطبية.</p>
            <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                <button @click="selectedService = ''; callbackModalOpen = true" class="btn-accent py-3 px-7 rounded-xl text-xs font-bold shadow-md hover:shadow-lg">طلب معاودة اتصال</button>
                <a href="https://wa.me/966545880082" target="_blank" class="inline-flex items-center gap-2 py-3 px-6 bg-[#25D366] text-white rounded-xl text-xs font-bold hover:opacity-90 transition-all">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.157 4.228 4.305-1.129z"/></svg>
                    تواصل عبر الواتساب
                </a>
            </div>
        </div>
    </section>

</x-app-layout>
