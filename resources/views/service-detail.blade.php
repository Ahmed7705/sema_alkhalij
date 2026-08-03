<x-app-layout title="{{ $service->title }} | سيما الخليج">

    {{-- =================== HERO BANNER =================== --}}
    <section
        class="relative py-16 sm:py-20 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/3 -translate-y-1/2 w-96 h-96 bg-accent/10 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.03]"
                style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 32px 32px;">
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4 text-right">

            {{-- Breadcrumb Navigation --}}
            <nav class="flex items-center gap-2 text-xs text-medical-200">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">الرئيسية</a>
                <span>/</span>
                <a href="{{ route('services') }}" class="hover:text-white transition-colors">الخدمات الطبية</a>
                <span>/</span>
                <span class="text-white font-bold">{{ $service->title }}</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pt-2">
                <div class="space-y-3">
                    <span
                        class="inline-block px-4 py-1.5 rounded-full bg-white/10 border border-white/15 text-xs font-bold text-accent">
                        {{ $service->category->name ?? 'خدمة منزلية' }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-tight">
                        {{ $service->title }}
                    </h1>
                </div>

                {{-- Price Callout Header Card --}}
                <div
                    class="bg-white/10 backdrop-blur-md border border-white/15 p-5 rounded-2xl shrink-0 text-right space-y-1">
                    <div class="text-xs text-medical-200 font-medium">تكلفة الخدمة شاملة الزيارة:</div>
                    @if($service->discount_price && $service->discount_price < $service->price)
                        <div class="text-xs text-medical-200 line-through font-bold dir-ltr text-right">
                            {{ number_format($service->price, 2) }} ر.س
                        </div>
                        <div class="text-3xl font-black text-accent dir-ltr text-right">
                            {{ number_format($service->discount_price, 2) }} <span
                                class="text-xs font-normal text-white">ر.س</span>
                        </div>
                    @else
                        <div class="text-3xl font-black text-white dir-ltr text-right">
                            {{ number_format($service->price, 2) }} <span
                                class="text-xs font-normal text-medical-200">ر.س</span>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>

    {{-- Main Service Details & Sidebar --}}
    <section class="py-12 bg-surface min-h-[60vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flexible Two-Column Layout --}}
            <div class="flex flex-col lg:flex-row gap-8 items-start w-full">

                {{-- Main Left Area (65% Width) --}}
                <div class="w-full lg:w-[65%] space-y-8 shrink-0">

                    {{-- Service Description Card --}}
                    <div
                        class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-soft space-y-4 text-right">
                        <h2
                            class="text-xl font-black text-primary border-b border-gray-100 pb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>تفاصيل الخدمة الطبية</span>
                        </h2>

                        <div class="text-xs sm:text-sm text-gray-700 leading-relaxed space-y-3 font-normal">
                            <p>{{ $service->description ?? $service->short_description }}</p>
                        </div>
                    </div>

                    {{-- Service Features & Includes Card --}}
                    <div
                        class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-soft space-y-4 text-right">
                        <h2
                            class="text-xl font-black text-primary border-b border-gray-100 pb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>ماذا تشمل هذه الخدمة؟</span>
                        </h2>

                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm text-gray-700">
                            <li class="p-4 bg-surface rounded-xl border border-gray-100 flex items-center gap-3">
                                <div
                                    class="w-7 h-7 rounded-xl bg-accent/10 text-accent flex items-center justify-center font-bold shrink-0">
                                    ✓</div>
                                <span class="font-medium">فحص سريري كامل وتقييم العلامات الحيوية</span>
                            </li>
                            <li class="p-4 bg-surface rounded-xl border border-gray-100 flex items-center gap-3">
                                <div
                                    class="w-7 h-7 rounded-xl bg-accent/10 text-accent flex items-center justify-center font-bold shrink-0">
                                    ✓</div>
                                <span class="font-medium">كوادر مرخصة من الهيئة السعودية للتخصصات</span>
                            </li>
                            <li class="p-4 bg-surface rounded-xl border border-gray-100 flex items-center gap-3">
                                <div
                                    class="w-7 h-7 rounded-xl bg-accent/10 text-accent flex items-center justify-center font-bold shrink-0">
                                    ✓</div>
                                <span class="font-medium">تقرير طبي معتمد ومتابعة الحالة بالكامل</span>
                            </li>
                            <li class="p-4 bg-surface rounded-xl border border-gray-100 flex items-center gap-3">
                                <div
                                    class="w-7 h-7 rounded-xl bg-accent/10 text-accent flex items-center justify-center font-bold shrink-0">
                                    ✓</div>
                                <span class="font-medium">معدات وتعقيم طبي على أعلى معايير الأمان</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Related Services Section --}}
                    @if(isset($relatedServices) && $relatedServices->count() > 0)
                        <div class="space-y-4 pt-4 text-right">
                            <h3 class="text-lg font-black text-primary">خدمات طبية ذات صلة</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($relatedServices as $rel)
                                    <div
                                        class="bg-white rounded-2xl p-5 border border-gray-100 shadow-soft hover:shadow-card transition-all space-y-3">
                                        <h4 class="font-bold text-sm text-primary">
                                            <a href="{{ route('services.show', $rel->slug) }}"
                                                class="hover:text-accent transition-colors">
                                                {{ $rel->title }}
                                            </a>
                                        </h4>
                                        <div class="flex items-center justify-between text-xs pt-2 border-t border-gray-50">
                                            <span class="font-bold text-accent dir-ltr">{{ number_format($rel->price, 2) }}
                                                ر.س</span>
                                            <a href="{{ route('services.show', $rel->slug) }}"
                                                class="text-primary hover:text-accent font-bold">عرض التفاصيل &rarr;</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

                {{-- Right Booking Sidebar (32% Width) --}}
                <div class="w-full lg:w-[32%] space-y-6 shrink-0">

                    {{-- Sticky Booking Card --}}
                    <div
                        class="bg-white rounded-2xl p-6 border border-gray-100 shadow-card space-y-5 text-right sticky top-24">
                        <div class="text-center space-y-1">
                            <span class="text-xs text-gray-400 font-bold">احجز مواعيدك الطبية بسهولة</span>
                            <h3 class="text-xl font-black text-primary">حجز زيارة منزلية</h3>
                        </div>

                        <div class="p-4 bg-surface rounded-xl border border-gray-100 space-y-3 text-xs">
                            <div class="flex items-center justify-between text-gray-600">
                                <span>مدة الزيارة التقريبية:</span>
                                <strong
                                    class="text-primary font-bold">{{ $service->duration_minutes ? intval($service->duration_minutes) . ' دقيقة' : 'حسب الحالة' }}</strong>
                            </div>
                            <div class="flex items-center justify-between text-gray-600">
                                <span>نطاق الخدمة:</span>
                                <strong class="text-primary font-bold">الزيارات المنزلية بالمملكة</strong>
                            </div>
                            <div class="flex items-center justify-between text-gray-600">
                                <span>حالة التوفر:</span>
                                <strong class="text-accent font-bold">متاح اليوم</strong>
                            </div>
                        </div>

                        <button type="button" onclick="Livewire.emit('openBookingModal', {{ $service->id }})"
                            class="w-full btn-accent py-3.5 rounded-xl font-black text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <span>طلب الحجز الآن</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>

                        <a href="https://wa.me/966545880082?text={{ urlencode('مرحباً، أود الاستفسار عن خدمة: ' . $service->title) }}"
                            target="_blank"
                            class="w-full py-3.5 rounded-xl bg-[#25D366]/10 text-[#128C7E] hover:bg-[#25D366]/20 font-bold text-xs transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.157 4.228 4.305-1.129z" />
                            </svg>
                            <span>استفسار سريـع عبر الواتساب</span>
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </section>

</x-app-layout>