<x-app-layout :title="$service->title . ' | ' . (app()->getLocale()=='en' ? 'Sema Al-Khalij Medical Services' : 'سيما الخليج للخدمات الطبية')">

    @php
        $isEn = app()->getLocale() == 'en';

        $srvCatMap = [
            'doctor-visits' => $isEn ? 'Doctor Visits' : 'الزيارات الطبية',
            'home-nursing' => $isEn ? 'Home Nursing' : 'التمريض المنزلي',
            'lab-tests' => $isEn ? 'Lab & Diagnostics' : 'الفحوصات والمختبر',
            'physiotherapy' => $isEn ? 'Physiotherapy' : 'العلاج الطبيعي',
        ];

        $serviceTrans = [
            'home-health-care' => [
                'title' => 'Home Health Care Services',
                'desc' => 'Tailored medical and nursing care programs for the elderly and chronically ill patients in a warm, safe, and comfortable home environment.',
            ],
            'home-doctor-visits' => [
                'title' => 'Home Doctor Visits',
                'desc' => 'Specialized physicians and consultant doctors visiting your residence for comprehensive clinical examination, diagnosis, and treatment plans.',
            ],
            'home-nursing-247' => [
                'title' => '24/7 Continuous Home Nursing',
                'desc' => 'Round-the-clock professional nursing care, vital signs monitoring, wound dressing, catheter management, and IV therapy.',
            ],
            'physiotherapy-rehab' => [
                'title' => 'Physical Therapy & Rehabilitation',
                'desc' => 'Customized physical rehabilitation sessions for post-surgery recovery, stroke rehab, joint pain, and mobility restoration at home.',
            ],
            'home-blood-sampling' => [
                'title' => 'Home Blood Sample Collection',
                'desc' => 'Certified lab technicians visiting your home with sterile collection kits for fast, accurate electronic lab test results.',
            ],
            'comprehensive-lab-tests' => [
                'title' => 'Comprehensive Home Lab Packages',
                'desc' => 'Full preventive screening panels including liver/kidney functions, lipid panel, blood sugar, complete blood count, and vitamins.',
            ],
            'genetic-dna-tests' => [
                'title' => 'Genetic & DNA Testing',
                'desc' => 'Advanced DNA profiling and hereditary disease screening with complete confidentiality and specialized medical reporting.',
            ],
            'medical-teleconsultation' => [
                'title' => 'Medical Tele-consultations',
                'desc' => 'Direct video and phone consultations with top certified consultants for medical guidance and follow-ups.',
            ],
            'corporate-medical-solutions' => [
                'title' => 'Corporate Medical Care Solutions',
                'desc' => 'Customized corporate healthcare packages, occupational health clinics, employee periodic wellness checkups, and event coverage.',
            ],
        ];

        $displayTitle = ($isEn && isset($serviceTrans[$service->slug])) ? $serviceTrans[$service->slug]['title'] : $service->title;
        $displayDesc = ($isEn && isset($serviceTrans[$service->slug])) ? $serviceTrans[$service->slug]['desc'] : ($service->description ?? $service->short_description);
        $displayCat = isset($srvCatMap[$service->category->slug ?? '']) ? $srvCatMap[$service->category->slug] : ($service->category->name ?? ($isEn ? 'Home Medical Service' : 'خدمة طبية منزلية'));
    @endphp

    {{-- =================== HERO BANNER =================== --}}
    <section class="relative py-16 sm:py-20 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/3 -translate-y-1/2 w-96 h-96 bg-accent/10 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 32px 32px;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-4 {{ $isEn ? 'text-left' : 'text-right' }}">

            {{-- Breadcrumb Navigation --}}
            <nav class="flex items-center gap-2 text-xs text-medical-200">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">{{ $isEn ? 'Home' : 'الرئيسية' }}</a>
                <span>/</span>
                <a href="{{ route('services') }}" class="hover:text-white transition-colors">{{ $isEn ? 'Medical Services' : 'الخدمات الطبية' }}</a>
                <span>/</span>
                <span class="text-white font-bold">{{ $displayTitle }}</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pt-2">
                <div class="space-y-3">
                    <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 border border-white/15 text-xs font-bold text-accent">
                        {{ $displayCat }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-tight">
                        {{ $displayTitle }}
                    </h1>
                </div>

                {{-- Price Callout Header Card --}}
                <div class="bg-white/10 backdrop-blur-md border border-white/15 p-5 rounded-2xl shrink-0 {{ $isEn ? 'text-left' : 'text-right' }} space-y-1">
                    <div class="text-xs text-medical-200 font-medium">{{ $isEn ? 'Service Fee (Includes Home Visit):' : 'تكلفة الخدمة شاملة الزيارة:' }}</div>
                    @if($service->discount_price && $service->discount_price < $service->price)
                        <div class="text-xs text-medical-200 line-through font-bold dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                            {{ number_format($service->price, 2) }} {{ __('products.sar') }}
                        </div>
                        <div class="text-3xl font-black text-accent dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                            {{ number_format($service->discount_price, 2) }} <span class="text-xs font-normal text-white">{{ __('products.sar') }}</span>
                        </div>
                    @else
                        <div class="text-3xl font-black text-white dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                            {{ number_format($service->price, 2) }} <span class="text-xs font-normal text-medical-200">{{ __('products.sar') }}</span>
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

                {{-- Main Content Area (65% Width) --}}
                <div class="w-full lg:w-[65%] space-y-8 shrink-0">

                    {{-- Service Description Card --}}
                    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-soft space-y-4 {{ $isEn ? 'text-left' : 'text-right' }}">
                        <h2 class="text-xl font-black text-primary border-b border-gray-100 pb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            <span>{{ $isEn ? 'Medical Service Overview' : 'تفاصيل الخدمة الطبية' }}</span>
                        </h2>

                        <div class="text-xs sm:text-sm text-gray-700 leading-relaxed space-y-3 font-normal">
                            <p>{{ $displayDesc }}</p>
                        </div>
                    </div>

                    {{-- Service Features & Includes Card --}}
                    <div class="bg-white rounded-2xl p-6 sm:p-8 border border-gray-100 shadow-soft space-y-4 {{ $isEn ? 'text-left' : 'text-right' }}">
                        <h2 class="text-xl font-black text-primary border-b border-gray-100 pb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <span>{{ $isEn ? 'What Does This Service Include?' : 'ماذا تشمل هذه الخدمة؟' }}</span>
                        </h2>

                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm text-gray-700">
                            <li class="p-4 bg-surface rounded-xl border border-gray-100 flex items-center gap-3">
                                <div class="w-7 h-7 rounded-xl bg-accent/10 text-accent flex items-center justify-center font-bold shrink-0">✓</div>
                                <span class="font-medium">{{ $isEn ? 'Full clinical exam & vital signs check' : 'فحص سريري كامل وتقييم العلامات الحيوية' }}</span>
                            </li>
                            <li class="p-4 bg-surface rounded-xl border border-gray-100 flex items-center gap-3">
                                <div class="w-7 h-7 rounded-xl bg-accent/10 text-accent flex items-center justify-center font-bold shrink-0">✓</div>
                                <span class="font-medium">{{ $isEn ? 'Officially MOH licensed medical staff' : 'كوادر مرخصة من الهيئة السعودية للتخصصات' }}</span>
                            </li>
                            <li class="p-4 bg-surface rounded-xl border border-gray-100 flex items-center gap-3">
                                <div class="w-7 h-7 rounded-xl bg-accent/10 text-accent flex items-center justify-center font-bold shrink-0">✓</div>
                                <span class="font-medium">{{ $isEn ? 'Full medical report & case follow-up' : 'تقرير طبي معتمد ومتابعة الحالة بالكامل' }}</span>
                            </li>
                            <li class="p-4 bg-surface rounded-xl border border-gray-100 flex items-center gap-3">
                                <div class="w-7 h-7 rounded-xl bg-accent/10 text-accent flex items-center justify-center font-bold shrink-0">✓</div>
                                <span class="font-medium">{{ $isEn ? 'Sterile tools & top safety protocols' : 'معدات وتعقيم طبي على أعلى معايير الأمان' }}</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Related Services Section --}}
                    @if(isset($relatedServices) && $relatedServices->count() > 0)
                        <div class="space-y-4 pt-4 {{ $isEn ? 'text-left' : 'text-right' }}">
                            <h3 class="text-lg font-black text-primary">{{ $isEn ? 'Related Medical Services' : 'خدمات طبية ذات صلة' }}</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($relatedServices as $rel)
                                    @php
                                        $relTitle = ($isEn && isset($serviceTrans[$rel->slug])) ? $serviceTrans[$rel->slug]['title'] : $rel->title;
                                    @endphp
                                    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-soft hover:shadow-card transition-all space-y-3">
                                        <h4 class="font-bold text-sm text-primary">
                                            <a href="{{ route('services.show', $rel->slug) }}" class="hover:text-accent transition-colors">
                                                {{ $relTitle }}
                                            </a>
                                        </h4>
                                        <div class="flex items-center justify-between text-xs pt-2 border-t border-gray-50">
                                            <span class="font-bold text-accent dir-ltr">{{ number_format($rel->price, 2) }} {{ __('products.sar') }}</span>
                                            <a href="{{ route('services.show', $rel->slug) }}" class="text-primary hover:text-accent font-bold">
                                                {{ $isEn ? 'View Details →' : 'عرض التفاصيل ←' }}
                                            </a>
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
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-card space-y-5 {{ $isEn ? 'text-left' : 'text-right' }} sticky top-24">
                        <div class="text-center space-y-1">
                            <span class="text-xs text-gray-400 font-bold">{{ $isEn ? 'Book appointments easily' : 'احجز مواعيدك الطبية بسهولة' }}</span>
                            <h3 class="text-xl font-black text-primary">{{ $isEn ? 'Book Home Visit' : 'حجز زيارة منزلية' }}</h3>
                        </div>

                        <div class="p-4 bg-surface rounded-xl border border-gray-100 space-y-3 text-xs">
                            <div class="flex items-center justify-between text-gray-600">
                                <span>{{ $isEn ? 'Approx Duration:' : 'مدة الزيارة التقريبية:' }}</span>
                                <strong class="text-primary font-bold">{{ $service->duration_minutes ? intval($service->duration_minutes) . ($isEn ? ' mins' : ' دقيقة') : ($isEn ? 'As needed' : 'حسب الحالة') }}</strong>
                            </div>
                            <div class="flex items-center justify-between text-gray-600">
                                <span>{{ $isEn ? 'Coverage Scope:' : 'نطاق الخدمة:' }}</span>
                                <strong class="text-primary font-bold">{{ $isEn ? 'All KSA Cities' : 'الزيارات المنزلية بالمملكة' }}</strong>
                            </div>
                            <div class="flex items-center justify-between text-gray-600">
                                <span>{{ $isEn ? 'Availability:' : 'حالة التوفر:' }}</span>
                                <strong class="text-accent font-bold">{{ $isEn ? 'Available Today' : 'متاح اليوم' }}</strong>
                            </div>
                        </div>

                        <button type="button" onclick="emitLivewire('openBookingModal', {{ $service->id }})"
                            class="w-full btn-accent py-3.5 rounded-xl font-black text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                            <span>{{ $isEn ? 'Book Service Now' : 'طلب الحجز الآن' }}</span>
                            <svg class="w-4 h-4 {{ $isEn ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>

                        <a href="https://wa.me/966545880082?text={{ urlencode($isEn ? 'Hello, I would like to inquire about service: ' . $displayTitle : 'مرحباً، أود الاستفسار عن خدمة: ' . $service->title) }}"
                            target="_blank"
                            class="w-full py-3.5 rounded-xl bg-[#25D366]/10 text-[#128C7E] hover:bg-[#25D366]/20 font-bold text-xs transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.157 4.228 4.305-1.129z" />
                            </svg>
                            <span>{{ $isEn ? 'Quick Inquiry via WhatsApp' : 'استفسار سريـع عبر الواتساب' }}</span>
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </section>

</x-app-layout>