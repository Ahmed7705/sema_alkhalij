<x-app-layout title="{{ app()->getLocale()=='en' ? 'Home Medical Services | Sema Al-Khalij' : 'الخدمات الطبية المنزلية | سيما الخليج' }}">

    @php
        $srvCatMap = [
            'doctor-visits' => app()->getLocale()=='en' ? 'Doctor Visits' : 'الزيارات الطبية',
            'home-nursing' => app()->getLocale()=='en' ? 'Home Nursing' : 'التمريض المنزلي',
            'lab-tests' => app()->getLocale()=='en' ? 'Lab & Diagnostics' : 'الفحوصات والمختبر',
            'physiotherapy' => app()->getLocale()=='en' ? 'Physiotherapy' : 'العلاج الطبيعي',
        ];

        $serviceTrans = [
            'home-health-care' => [
                'title' => 'Home Health Care Services',
                'desc' => 'Tailored programs for the elderly and chronically ill patients in a warm, safe home environment.',
            ],
            'home-doctor-visits' => [
                'title' => 'Home Doctor Visits',
                'desc' => 'Physicians and consultants for clinical examination, accurate diagnosis, and home treatment.',
            ],
            'home-nursing-247' => [
                'title' => '24/7 Continuous Home Nursing',
                'desc' => 'Round-the-clock nursing care, vital signs monitoring, wound care, and IV therapy.',
            ],
            'physiotherapy-rehab' => [
                'title' => 'Physical Therapy & Rehabilitation',
                'desc' => 'Customized rehab sessions for post-surgery, stroke recovery, bone, and joint injuries.',
            ],
            'home-blood-sampling' => [
                'title' => 'Home Blood Sample Collection',
                'desc' => 'Certified lab specialist visits your home with sterile tools and fast electronic results.',
            ],
            'comprehensive-lab-tests' => [
                'title' => 'Comprehensive Home Lab Packages',
                'desc' => 'Full preventive health packages: liver/kidney functions, vitamins, lipid panel, and blood sugar.',
            ],
            'genetic-dna-tests' => [
                'title' => 'Genetic & DNA Testing',
                'desc' => 'DNA analysis, genetic profiling, and early disease detection with utmost privacy.',
            ],
            'medical-teleconsultation' => [
                'title' => 'Medical Tele-consultations',
                'desc' => 'Urgent video and phone consultations with top consultants to monitor your health condition.',
            ],
            'corporate-medical-care' => [
                'title' => 'Corporate Medical Care Solutions',
                'desc' => 'On-site clinic setup, periodic employee health checks, and event medical coverage.',
            ],
        ];
    @endphp

    {{-- =================== HERO BANNER =================== --}}
    <section class="relative py-16 sm:py-20 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/3 -translate-y-1/2 w-96 h-96 bg-accent/10 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 32px 32px;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-4">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-bold text-medical-100">
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span>{{ __('services.catalog_badge') }}</span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                {{ __('services.page_title') }}
            </h1>

            <p class="text-medical-200 text-sm sm:text-base max-w-3xl mx-auto leading-relaxed">
                {{ __('services.page_text') }}
            </p>
        </div>
    </section>

    {{-- =================== SERVICES CATALOG =================== --}}
    <section class="py-12 lg:py-16 bg-surface">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Search & Category Filter Card --}}
            <div class="bg-white p-5 sm:p-6 rounded-3xl shadow-soft border border-gray-100 space-y-5 {{ app()->getLocale()=='en' ? 'text-left' : 'text-right' }}">
                
                {{-- Search Bar Row --}}
                <form action="{{ route('services') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <div class="absolute {{ app()->getLocale()=='en' ? 'left-3.5' : 'right-3.5' }} top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none z-10 flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('services.search_placeholder') }}" 
                               style="{{ app()->getLocale()=='en' ? 'padding-left: 2.75rem !important;' : 'padding-right: 2.75rem !important;' }}"
                               class="w-full {{ app()->getLocale()=='en' ? 'pr-4 text-left' : 'pl-4 text-right' }} h-12 bg-gray-50 border border-gray-200 rounded-2xl text-xs sm:text-sm text-gray-800 focus:outline-none focus:border-primary focus:bg-white transition-all font-medium">
                    </div>

                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif

                    <button type="submit" class="h-12 px-8 bg-accent hover:bg-accent-hover text-white font-bold rounded-2xl text-xs sm:text-sm shadow transition-all flex items-center justify-center gap-2 shrink-0">
                        <span>{{ __('services.search_btn') }}</span>
                    </button>

                    @if(request('search') || request('category'))
                        <a href="{{ route('services') }}" class="h-12 px-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-2xl font-bold text-xs transition-all flex items-center justify-center shrink-0">
                            {{ __('services.clear_filter') }}
                        </a>
                    @endif
                </form>

                {{-- Category Filter Pills Row --}}
                <div class="flex items-center gap-2.5 overflow-x-auto pb-1 pt-3 border-t border-gray-100 no-scrollbar">
                    <a href="{{ route('services', array_filter(['search' => request('search')])) }}" 
                       class="px-5 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all border shrink-0 {{ empty(request('category')) ? 'bg-primary text-white border-primary shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600 border-gray-200' }}">
                        {{ __('services.all') }} ({{ $services->total() }})
                    </a>

                    @foreach($categories as $category)
                        <a href="{{ route('services', array_filter(['category' => $category->slug, 'search' => request('search')])) }}" 
                           class="px-5 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all border shrink-0 {{ request('category') === $category->slug ? 'bg-primary text-white border-primary shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600 border-gray-200' }}">
                            {{ $srvCatMap[$category->slug] ?? $category->name }}
                        </a>
                    @endforeach
                </div>

            </div>

            {{-- Grid of Dynamic Services from MySQL Database --}}
            @if($services->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($services as $s)
                        @php
                            $imgMap = [
                                'home-health-care' => 'service-care.png',
                                'home-doctor-visits' => 'service-doctor.png',
                                'home-nursing-247' => 'service-nursing.png',
                                'physiotherapy-rehab' => 'service-physio.png',
                                'home-blood-sampling' => 'service-sampling.png',
                                'comprehensive-lab-tests' => 'service-lab.png',
                                'genetic-dna-tests' => 'service-dna.png',
                                'medical-teleconsultation' => 'service-telehealth.png',
                                'corporate-medical-care' => 'medical-team.png',
                            ];
                            $imgName = $imgMap[$s->slug] ?? 'hero-doctor.png';

                            $displayTitle = (app()->getLocale() == 'en' && isset($serviceTrans[$s->slug])) ? $serviceTrans[$s->slug]['title'] : $s->title;
                            $displayDesc = (app()->getLocale() == 'en' && isset($serviceTrans[$s->slug])) ? $serviceTrans[$s->slug]['desc'] : ($s->short_description ?? $s->description);
                            $displayCat = isset($srvCatMap[$s->category->slug ?? '']) ? $srvCatMap[$s->category->slug] : ($s->category->name ?? __('services.badge'));
                        @endphp

                        <div class="bg-white rounded-3xl border border-gray-100 shadow-soft hover:shadow-card transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                            
                            {{-- Clickable Card: Image & Info --}}
                            <a href="{{ route('services.show', $s->slug) }}" class="block {{ app()->getLocale()=='en' ? 'text-left' : 'text-right' }}">
                                <div class="relative h-48 overflow-hidden">
                                    <img src="{{ asset('images/' . $imgName) }}" alt="{{ $displayTitle }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" style="object-position: center 25%;">
                                    <div class="absolute inset-0 bg-gradient-to-t from-primary/85 via-primary/40 to-transparent"></div>
                                    
                                    <span class="absolute top-3 {{ app()->getLocale()=='en' ? 'left-3' : 'right-3' }} px-3 py-1 bg-white/90 backdrop-blur-md text-primary font-bold text-[10px] rounded-lg shadow-sm">
                                        {{ $displayCat }}
                                    </span>

                                    <span class="absolute bottom-3 {{ app()->getLocale()=='en' ? 'right-3' : 'right-3' }} px-3 py-1 bg-accent text-white font-bold text-[11px] rounded-lg shadow-md border border-white/20 dir-ltr">
                                        @if($s->discount_price && $s->discount_price < $s->price)
                                            {{ number_format($s->discount_price, 0) }} {{ __('products.sar') }}
                                        @else
                                            {{ number_format($s->price, 0) }} {{ __('products.sar') }}
                                        @endif
                                    </span>
                                </div>

                                <div class="p-5 space-y-3">
                                    <h3 class="font-black text-primary text-base group-hover:text-accent transition-colors">
                                        {{ $displayTitle }}
                                    </h3>
                                    
                                    <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                                        {{ $displayDesc }}
                                    </p>

                                    <div class="pt-2 space-y-1.5 border-t border-gray-50">
                                        <div class="flex items-center gap-2 text-[11px] text-gray-600 font-medium">
                                            <svg class="w-3.5 h-3.5 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            <span>{{ __('services.benefit1') }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-[11px] text-gray-600 font-medium">
                                            <svg class="w-3.5 h-3.5 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            <span>{{ __('services.benefit2') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            {{-- Action Button --}}
                            <div class="px-5 pb-5 pt-2 border-t border-gray-50 bg-gray-50/50">
                                <button type="button" onclick="emitLivewire('openBookingModal', {{ $s->id }})" class="w-full btn-accent py-2.5 rounded-xl font-bold text-xs shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                    <span>{{ __('services.book_btn') }}</span>
                                    <svg class="w-4 h-4 {{ app()->getLocale()=='en' ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </button>
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- Pagination Links --}}
                <div class="pt-6 flex justify-center">
                    {{ $services->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl p-12 text-center border border-gray-100 space-y-4 max-w-md mx-auto my-12 shadow-soft">
                    <div class="w-16 h-16 rounded-2xl bg-gray-50 text-gray-400 flex items-center justify-center mx-auto border border-gray-100">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h3 class="text-lg font-black text-primary">{{ __('services.no_results_title') }}</h3>
                    <p class="text-xs text-gray-500">{{ __('services.no_results_text') }}</p>
                    <a href="{{ route('services') }}" class="btn-accent py-2.5 px-6 rounded-xl font-bold text-xs inline-block shadow">
                        {{ __('services.browse_all') }}
                    </a>
                </div>
            @endif

        </div>
    </section>

    {{-- =================== WHY CHOOSE US =================== --}}
    <section class="py-12 lg:py-16 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
                <div class="section-badge mx-auto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ __('services.quality_badge') }}</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-primary">{{ __('services.quality_heading') }}</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 {{ app()->getLocale()=='en' ? 'text-left' : 'text-right' }}">
                <div class="p-6 rounded-2xl bg-surface border border-gray-100 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-accent/10 text-accent flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-bold text-base text-primary">{{ __('services.quality1_title') }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ __('services.quality1_text') }}</p>
                </div>

                <div class="p-6 rounded-2xl bg-surface border border-gray-100 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-accent/10 text-accent flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-base text-primary">{{ __('services.quality2_title') }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ __('services.quality2_text') }}</p>
                </div>

                <div class="p-6 rounded-2xl bg-surface border border-gray-100 space-y-3">
                    <div class="w-10 h-10 rounded-xl bg-accent/10 text-accent flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h3 class="font-bold text-base text-primary">{{ __('services.quality3_title') }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed">{{ __('services.quality3_text') }}</p>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>