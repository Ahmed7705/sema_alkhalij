<x-app-layout>

    {{-- ============= HERO SECTION ============= --}}
    <section class="relative min-h-[90vh] bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden flex items-center">
        {{-- Animated background elements --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 right-10 w-[500px] h-[500px] bg-accent/10 rounded-full blur-[120px] animate-pulse"></div>
            <div class="absolute bottom-10 left-20 w-[400px] h-[400px] bg-medical-400/8 rounded-full blur-[100px]"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-accent/5 rounded-full blur-[150px]"></div>
            {{-- Subtle grid overlay --}}
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, rgba(255,255,255,0.3) 1px, transparent 1px); background-size: 40px 40px;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-16 lg:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 items-center">

                {{-- Right Side: Text & CTA --}}
                <div class="lg:col-span-7 space-y-8 text-center lg:text-right">

                    {{-- Trust Badge --}}
                    <div class="inline-flex items-center gap-2.5 px-5 py-2.5 rounded-full bg-white/[0.08] backdrop-blur-xl border border-white/[0.12] text-sm font-bold" x-data="{ show: false }" x-init="setTimeout(() => show = true, 200)" x-show="show" x-transition.duration.700ms>
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-accent"></span>
                        </span>
                        <span class="text-medical-100">الرعاية الصحية المنزلية الأكثر موثوقية في المملكة</span>
                    </div>

                    {{-- Main Headline --}}
                    <h1 class="text-4xl sm:text-5xl lg:text-[3.5rem] xl:text-6xl font-black leading-[1.15] tracking-tight" x-data="{ show: false }" x-init="setTimeout(() => show = true, 400)" x-show="show" x-transition.duration.700ms>
                        صحتك وعائلتك في أمان...
                        <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-l from-[#6ee7b7] via-accent to-[#34d399]">
                            رعاية طبية متكاملة
                        </span>
                        <br>
                        <span class="text-medical-100 text-3xl sm:text-4xl lg:text-[2.5rem]">تصلك حتى باب بيتك</span>
                    </h1>

                    {{-- Description --}}
                    <p class="text-base sm:text-lg text-medical-200/90 leading-relaxed max-w-2xl mx-auto lg:mx-0" x-data="{ show: false }" x-init="setTimeout(() => show = true, 600)" x-show="show" x-transition.duration.700ms>
                        نُقدّم في سيما الخليج منظومة رعاية صحية منزلية شاملة: أطباء واستشاريون، تمريض متخصص 24/7، علاج طبيعي، سحب عينات، فحوصات مخبرية وجينية، ومستلزمات طبية — بأعلى معايير الجودة والخصوصية.
                    </p>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4" x-data="{ show: false }" x-init="setTimeout(() => show = true, 800)" x-show="show" x-transition.duration.700ms>
                        <a href="{{ url('/services') }}" class="group relative inline-flex items-center gap-2.5 px-8 py-4 bg-accent text-white font-black text-base rounded-2xl shadow-[0_8px_30px_rgba(60,169,107,0.35)] hover:shadow-[0_12px_40px_rgba(60,169,107,0.5)] hover:scale-[1.03] transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            احجز خدمة الآن
                        </a>
                        <button @click="callbackModalOpen = true" class="inline-flex items-center gap-2.5 px-7 py-4 bg-white text-primary font-bold text-base rounded-2xl shadow-lg hover:shadow-xl hover:scale-[1.03] transition-all duration-300">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            اطلب زيارة منزلية
                        </button>
                        <a href="https://wa.me/966545880082" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-6 py-4 rounded-2xl border-2 border-white/20 text-white font-bold hover:bg-white/10 hover:border-white/30 transition-all duration-300">
                            <svg class="w-5 h-5 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.157 4.228 4.305-1.129z"/></svg>
                            واتساب
                        </a>
                    </div>

                    {{-- Trust Points Bar --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-x-6 gap-y-4 pt-8 border-t border-white/10">
                        <div class="flex items-center gap-2 text-xs sm:text-sm text-medical-200">
                            <div class="w-8 h-8 rounded-lg bg-accent/15 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span>كادر طبي مرخّص</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs sm:text-sm text-medical-200">
                            <div class="w-8 h-8 rounded-lg bg-accent/15 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <span>تغطية 24/7</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs sm:text-sm text-medical-200">
                            <div class="w-8 h-8 rounded-lg bg-accent/15 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <span>معايير جودة عالمية</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs sm:text-sm text-medical-200">
                            <div class="w-8 h-8 rounded-lg bg-accent/15 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <span>خصوصية تامة</span>
                        </div>
                    </div>
                </div>

                {{-- Left Side: Hero Visual Card --}}
                <div class="lg:col-span-5 relative" x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)" x-show="show" x-transition.duration.1000ms>
                    <div class="relative">
                        {{-- Main Glass Card --}}
                        <div class="w-full max-w-md mx-auto bg-white/[0.07] backdrop-blur-2xl border border-white/[0.12] rounded-3xl p-7 shadow-[0_20px_60px_rgba(0,0,0,0.3)] space-y-5">

                            {{-- Card Header --}}
                            <div class="flex items-center justify-between border-b border-white/10 pb-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('images/logo.png') }}" class="h-11 w-auto bg-white/90 rounded-xl p-1.5 shadow-sm object-contain" alt="سيما الخليج" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                                    <div class="hidden items-center gap-2">
                                        <div class="w-9 h-9 rounded-lg bg-accent text-white flex items-center justify-center font-black text-sm">S</div>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-white text-sm">حجز سريع</h4>
                                        <p class="text-[11px] text-medical-300">اختر خدمتك الآن</p>
                                    </div>
                                </div>
                                <span class="px-2.5 py-1 bg-accent/20 text-accent font-bold text-[11px] rounded-full border border-accent/20">متاح الآن</span>
                            </div>

                            {{-- Quick Select --}}
                            <div class="space-y-3.5">
                                <div>
                                    <label class="block text-xs font-bold text-medical-200 mb-1.5">الخدمة الطبية</label>
                                    <select class="w-full bg-white/10 border border-white/15 rounded-xl py-3 px-4 text-sm text-white focus:outline-none focus:border-accent/50 transition-colors appearance-none cursor-pointer">
                                        <option value="" class="text-gray-900">اختر الخدمة...</option>
                                        <option value="nursing" class="text-gray-900">تمريض منزلي</option>
                                        <option value="doctor" class="text-gray-900">زيارة طبيب</option>
                                        <option value="physio" class="text-gray-900">علاج طبيعي</option>
                                        <option value="lab" class="text-gray-900">سحب عينات وفحوصات</option>
                                        <option value="genetics" class="text-gray-900">فحوصات جينية</option>
                                        <option value="consult" class="text-gray-900">استشارة طبية</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-medical-200 mb-1.5">المدينة</label>
                                    <div class="w-full bg-white/10 border border-white/15 rounded-xl py-3 px-4 text-sm text-medical-100 flex items-center justify-between">
                                        <span>جدة</span>
                                        <span class="text-[10px] bg-accent/20 text-accent px-2 py-0.5 rounded-full font-bold">مغطاة</span>
                                    </div>
                                </div>
                                <a href="{{ url('/services') }}" class="block w-full text-center py-3.5 bg-accent text-white font-bold rounded-xl text-sm shadow-lg hover:shadow-xl hover:bg-accent-hover transition-all duration-300">
                                    متابعة الحجز
                                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>
                        </div>

                        {{-- Floating Review Badge --}}
                        <div class="absolute -bottom-6 -right-4 sm:right-0 bg-white text-gray-900 p-4 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.15)] flex items-center gap-3 border border-gray-100 max-w-[260px]">
                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-amber-400 to-amber-500 text-white flex items-center justify-center font-black text-xs shrink-0 shadow-md">
                                4.9 ★
                            </div>
                            <div>
                                <p class="font-bold text-primary text-xs">+1,500 عائلة تثق بنا</p>
                                <p class="text-[10px] text-gray-400 mt-0.5 leading-relaxed">"احترافية عالية وسرعة استجابة"</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Curved bottom edge --}}
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-white" style="clip-path: ellipse(55% 100% at 50% 100%);"></div>
    </section>

    {{-- ============= ABOUT BRIEF SECTION ============= --}}
    <section class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-14 items-center">

                {{-- Image Side --}}
                <div class="lg:col-span-5">
                    <div class="relative">
                        <div class="w-full aspect-[4/5] bg-gradient-to-br from-medical-50 via-medical-100 to-medical-200 rounded-3xl shadow-card border border-medical-200/40 flex items-center justify-center relative overflow-hidden group">
                            {{-- Abstract medical visual --}}
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_70%,rgba(60,169,107,0.1)_0%,transparent_60%)]"></div>
                            <div class="relative z-10 text-center space-y-5 p-8">
                                <div class="w-24 h-24 mx-auto rounded-3xl bg-primary text-accent flex items-center justify-center shadow-floating group-hover:scale-110 transition-transform duration-500">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                </div>
                                <h3 class="font-black text-2xl text-primary">سيما الخليج</h3>
                                <p class="text-sm text-gray-500 max-w-xs mx-auto">رعاية منزلية بمعايير المستشفيات</p>
                            </div>
                        </div>
                        {{-- Experience badge --}}
                        <div class="absolute -bottom-5 -left-5 sm:left-4 bg-white py-4 px-6 rounded-2xl shadow-floating border border-gray-100 text-right">
                            <span class="block text-3xl font-black text-accent leading-none">+10</span>
                            <span class="text-xs font-bold text-gray-600">أعوام خبرة وتميز</span>
                        </div>
                    </div>
                </div>

                {{-- Text Side --}}
                <div class="lg:col-span-7 space-y-6">
                    <div class="section-badge">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>من نحن</span>
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-black text-primary leading-tight">
                        نعتني بصحتك وعائلتك<br>بأعلى مستويات <span class="text-accent">الاحترافية والخصوصية</span>
                    </h2>
                    <p class="text-gray-600 text-base leading-[1.9]">
                        شركة سيما الخليج للخدمات الطبية من الشركات الرائدة في تقديم خدمات الرعاية الصحية المنزلية الشاملة بالمملكة العربية السعودية. نوفّر بيئة استشفاء آمنة ومريحة للمرضى في منازلهم عبر فريق طبي متكامل مؤهل بأحدث الأدوات والتقنيات.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-surface border border-gray-100 flex items-start gap-3 hover:shadow-soft transition-shadow">
                            <div class="w-10 h-10 rounded-xl bg-accent/10 text-accent flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-primary text-sm">رؤيتنا</h4>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">أن نكون الخيار الأول للرعاية الصحية المنزلية الموثوقة في الخليج.</p>
                            </div>
                        </div>
                        <div class="p-4 rounded-2xl bg-surface border border-gray-100 flex items-start gap-3 hover:shadow-soft transition-shadow">
                            <div class="w-10 h-10 rounded-xl bg-accent/10 text-accent flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-primary text-sm">الجودة والسلامة</h4>
                                <p class="text-xs text-gray-500 mt-1 leading-relaxed">التزام تام بالمعايير الصحية والوقائية لوزارة الصحة السعودية.</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ url('/about') }}" class="btn-primary py-3.5 px-8 rounded-xl text-sm inline-flex">
                        تعرّف على المزيد عنا
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============= SERVICES (9) ============= --}}
    <section class="py-24 bg-surface relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                <div class="section-badge mx-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span>خدماتنا الطبية</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-black text-primary">حلول رعاية صحية متكاملة في منزلك</h2>
                <p class="text-gray-500">اختر الخدمة واحجز زيارتك المنزلية بكل سهولة</p>
            </div>

            @php
            $services = [
                ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'title' => 'الرعاية الصحية المنزلية', 'desc' => 'برامج مخصصة لكبار السن وأصحاب الأمراض المزمنة في بيئة أسرية مريحة.', 'price' => 'تبدأ من 250 ر.س', 'slug' => 'home-healthcare'],
                ['icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'title' => 'الزيارات الطبية المنزلية', 'desc' => 'أطباء ممارسون واستشاريون لمعاينة المريض وتشخيص الحالة ووصف العلاج.', 'price' => 'تبدأ من 300 ر.س', 'slug' => 'doctor-visit'],
                ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'title' => 'التمريض المنزلي 24/7', 'desc' => 'رعاية تمريضية متواصلة، مؤشرات حيوية، عناية بالجروح، ومغذيات وريدية.', 'price' => 'تغطية 12/24 ساعة', 'slug' => 'home-nursing'],
                ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'العلاج الطبيعي والتأهيل', 'desc' => 'جلسات تأهيلية لحالات ما بعد العمليات والجلطات وآلام المفاصل.', 'price' => 'جلسات فردية وباقات', 'slug' => 'physical-therapy'],
                ['icon' => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z', 'title' => 'سحب العينات المنزلي', 'desc' => 'أخصائيون يسحبون عينات الدم في منزلك بدون ألم مع نتائج إلكترونية.', 'price' => 'نتائج سريعة وموثوقة', 'slug' => 'blood-sampling'],
                ['icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => 'الفحوصات المخبرية الشاملة', 'desc' => 'باقات فحوصات وقائية شاملة: كلى، كبد، سكر، فيتامينات، دهون، وهرمونات.', 'price' => 'باقات شاملة بخصم 30%', 'slug' => 'lab-tests'],
                ['icon' => 'M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457-.39-2.823-1.07-4', 'title' => 'الفحوصات الجينية والوراثية', 'desc' => 'تحاليل DNA وفحوصات أمراض وراثية وبصمة جينية بأحدث التقنيات.', 'price' => 'دقة ع فائقة وسرية', 'slug' => 'genetic-tests'],
                ['icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z', 'title' => 'الاستشارات الطبية', 'desc' => 'استشارات مرئية وهاتفية مع استشاريين متميزين لمتابعة حالتك الصحية.', 'price' => 'مواعيد مرنة فورية', 'slug' => 'medical-consultations'],
                ['icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'title' => 'خدمات الرعاية للشركات', 'desc' => 'عيادات موقعية، فحوصات دورية للموظفين، وتغطية فعاليات طبية.', 'price' => 'عقود وباقات خاصة', 'slug' => 'corporate-services'],
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                @foreach($services as $i => $service)
                <div class="medical-card p-6 flex flex-col justify-between group" x-data="{ show: false }" x-intersect.once="setTimeout(() => show = true, {{ $i * 100 }})" x-show="show" x-transition.duration.500ms>
                    <div class="space-y-4">
                        <div class="w-14 h-14 rounded-2xl bg-medical-50 text-accent flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-all duration-500">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $service['icon'] }}"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-primary group-hover:text-accent transition-colors duration-300">{{ $service['title'] }}</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $service['desc'] }}</p>
                        <div class="text-xs font-bold text-accent">{{ $service['price'] }}</div>
                    </div>
                    <div class="pt-5 border-t border-gray-100 flex items-center justify-between mt-4">
                        <a href="{{ url('/services/' . $service['slug']) }}" class="text-xs font-bold text-primary hover:text-accent transition-colors">تفاصيل الخدمة</a>
                        <a href="{{ url('/services/' . $service['slug'] . '#book') }}" class="btn-accent text-xs py-2 px-4 rounded-xl">احجز الآن</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============= WHY CHOOSE US (6 ADVANTAGES) ============= --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <div class="section-badge mx-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>مزايانا</span>
                </div>
                <h2 class="text-3xl font-black text-primary mt-3">لماذا تختار سيما الخليج؟</h2>
            </div>

            @php
            $advantages = [
                ['num' => '01', 'title' => 'فريق مؤهل ومرخّص', 'desc' => 'أطباء وممرضون بتراخيص من الهيئة السعودية للتخصصات الصحية وخبرة واسعة.'],
                ['num' => '02', 'title' => 'سرعة الاستجابة والوصول', 'desc' => 'نصلك وفق الموعد المحدد بانضباط تام دون أي تأخير.'],
                ['num' => '03', 'title' => 'أعلى معايير الجودة والسلامة', 'desc' => 'بروتوكولات تعقيم شامل ومكافحة عدوى أثناء كل زيارة منزلية.'],
                ['num' => '04', 'title' => 'أحدث المعدات والتقنيات', 'desc' => 'أجهزة طبية حديثة ومختبرات متنقلة تضمن دقة التشخيص.'],
                ['num' => '05', 'title' => 'شراكات دولية معتمدة', 'desc' => 'تعاون مع كبرى المراكز الطبية والمختبرات المعتمدة عالمياً.'],
                ['num' => '06', 'title' => 'سرية وخصوصية تامة', 'desc' => 'نحافظ على سجلك الطبي وبياناتك الشخصية بسرية مطلقة.'],
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                @foreach($advantages as $adv)
                <div class="p-7 rounded-2xl bg-surface border border-gray-100 hover:shadow-card hover:border-medical-200/60 transition-all duration-300 space-y-4 group">
                    <span class="text-3xl font-black text-medical-100 group-hover:text-accent transition-colors duration-300">{{ $adv['num'] }}</span>
                    <h3 class="font-bold text-lg text-primary">{{ $adv['title'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $adv['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============= STATS SECTION ============= --}}
    <section class="py-20 bg-gradient-to-r from-primary via-[#0d4435] to-primary-dark text-white relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-8 text-center">
                @php
                $stats = [
                    ['+15,000', 'زيارة منزلية ناجحة'],
                    ['99.2%', 'نسبة رضا المرضى'],
                    ['+50', 'طبيب وممرض متخصص'],
                    ['24/7', 'تغطية واستجابة فورية'],
                    ['+120', 'فحص مخبري وجيني'],
                    ['100%', 'معتمدون ومرخّصون'],
                ];
                @endphp
                @foreach($stats as $stat)
                <div class="space-y-2" x-data="{ show: false }" x-intersect.once="show = true" x-show="show" x-transition.duration.700ms>
                    <span class="text-3xl sm:text-4xl font-black text-accent block">{{ $stat[0] }}</span>
                    <span class="text-xs text-medical-200 block">{{ $stat[1] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============= TESTIMONIALS ============= --}}
    <section class="py-24 bg-surface">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <div class="section-badge mx-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <span>آراء العملاء</span>
                </div>
                <h2 class="text-3xl font-black text-primary mt-3">ماذا يقول عملاؤنا عن خدماتنا؟</h2>
            </div>

            @php
            $testimonials = [
                ['text' => 'خدمة ممتازة جداً! تم طلب زيارة تمريضية لوالدي بعد العملية، وصل الممرض في الوقت المحدد وكان على قدر كبير من الاحترافية والاهتمام. شكراً سيما الخليج.', 'name' => 'أحمد الغامدي', 'loc' => 'جدة - حي الشاطئ'],
                ['text' => 'تجربة سحب عينات الدم في المنزل كانت مريحة للغاية خصوصاً لوالدتي. نتائج التحاليل أُرسلت على الواتساب والبريد بسرعة فائقة ودقة عالية.', 'name' => 'سارة الشهري', 'loc' => 'جدة - حي الرويس'],
                ['text' => 'جلسات العلاج الطبيعي مع الأخصائي أحدثت فرقاً كبيراً في تحسن حركة والدي. التزام بالمواعيد ومعاملة راقية ومستوى عالٍ من المهنية.', 'name' => 'د. خالد المطيري', 'loc' => 'جدة - حي النعيم'],
            ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($testimonials as $t)
                <div class="p-7 rounded-2xl bg-white border border-gray-100 shadow-soft space-y-5 hover:shadow-card transition-shadow duration-300">
                    <div class="flex text-amber-400 gap-0.5 text-lg">★★★★★</div>
                    <p class="text-sm text-gray-600 leading-[1.9]">"{{ $t['text'] }}"</p>
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs">
                        <span class="font-bold text-primary">{{ $t['name'] }}</span>
                        <span class="text-gray-400">{{ $t['loc'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============= FAQ ============= --}}
    <section class="py-24 bg-white border-t border-gray-100">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center space-y-3 mb-14">
                <div class="section-badge mx-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>الأسئلة الشائعة</span>
                </div>
                <h2 class="text-3xl font-black text-primary">إجابات على أبرز تساؤلاتكم</h2>
            </div>

            <div class="space-y-4" x-data="{ active: 1 }">
                @php
                $faqs = [
                    ['q' => 'كيف يمكنني حجز زيارة طبية منزلية؟', 'a' => 'اختر الخدمة المطلوبة من موقعنا، حدد التاريخ والوقت والمدينة، أو اضغط "اطلب معاودة اتصال" وسيتواصل فريقنا معك فوراً لتأكيد الحجز.'],
                    ['q' => 'هل الكادر الطبي مرخّص ومعتمد رسمياً؟', 'a' => 'نعم، جميع أطبائنا وممرضينا وأخصائيينا يحملون تراخيص سارية من الهيئة السعودية للتخصصات الصحية مع خبرة واسعة في الرعاية المنزلية.'],
                    ['q' => 'ما هي المدن التي تغطيها خدماتكم؟', 'a' => 'نغطي حالياً مدينة جدة بكافة أحيائها بالكامل، ونعمل على التوسع قريباً لباقي مدن المملكة العربية السعودية.'],
                    ['q' => 'كيف أستلم نتائج الفحوصات المخبرية؟', 'a' => 'تُرسل النتائج إلكترونياً بصيغة PDF مشفرة على حسابك بالمنصة وعلى بريدك الإلكتروني والواتساب فور صدورها من المختبر.'],
                ];
                @endphp

                @foreach($faqs as $i => $faq)
                <div class="bg-surface rounded-2xl border border-gray-100 overflow-hidden hover:border-medical-200/60 transition-colors">
                    <button @click="active = active === {{ $i+1 }} ? null : {{ $i+1 }}" class="w-full p-5 text-right font-bold text-primary flex items-center justify-between gap-3 text-sm sm:text-base hover:text-accent transition-colors">
                        <span>{{ $faq['q'] }}</span>
                        <div class="w-8 h-8 rounded-lg shrink-0 flex items-center justify-center transition-all duration-300" :class="active === {{ $i+1 }} ? 'bg-accent text-white rotate-45' : 'bg-medical-50 text-accent'">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </div>
                    </button>
                    <div x-show="active === {{ $i+1 }}" x-collapse class="px-5 pb-5 text-sm text-gray-600 leading-[1.9] border-t border-gray-100 pt-3">
                        {{ $faq['a'] }}
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center pt-10">
                <a href="{{ url('/faq') }}" class="btn-outline py-3 px-8 rounded-xl text-sm inline-flex">عرض جميع الأسئلة الشائعة</a>
            </div>
        </div>
    </section>

    {{-- ============= FINAL CTA ============= --}}
    <section class="py-20 bg-gradient-to-br from-primary via-[#0d4435] to-primary-dark text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_50%,rgba(60,169,107,0.15)_0%,transparent_50%)]"></div>
        <div class="max-w-4xl mx-auto px-4 text-center space-y-7 relative z-10">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight">جاهز للحصول على<br>أفضل رعاية صحية في منزلك؟</h2>
            <p class="text-medical-200 text-base sm:text-lg max-w-2xl mx-auto">فريقنا الطبي مستعد لخدمتك ورعاية أحبابك بأعلى درجات الاهتمام والاحترافية.</p>
            <div class="flex flex-wrap items-center justify-center gap-4 pt-3">
                <a href="{{ url('/services') }}" class="inline-flex items-center gap-2.5 px-9 py-4 bg-accent text-white font-bold rounded-2xl shadow-[0_8px_30px_rgba(60,169,107,0.4)] hover:shadow-[0_12px_40px_rgba(60,169,107,0.6)] hover:scale-[1.03] transition-all text-base">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    احجز خدمتك الآن
                </a>
                <a href="tel:+966545880082" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-primary font-bold rounded-2xl shadow-lg hover:shadow-xl transition-all text-base">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span class="dir-ltr">+966 54 588 0082</span>
                </a>
            </div>
        </div>
    </section>

</x-app-layout>
