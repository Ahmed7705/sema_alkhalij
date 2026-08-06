<x-app-layout title="{{ app()->getLocale()=='en' ? 'Medical Devices & Supplies | Sema Al-Khalij' : 'متجر الأجهزة والمستلزمات الطبية | سيما الخليج' }}">

    @php
        $catMap = [
            'medical-devices' => __('products.cat_devices'),
            'medical-supplies' => __('products.cat_supplies'),
            'mobility-beds' => __('products.cat_beds'),
        ];

        $productTrans = [
            'smart-blood-pressure-monitor' => [
                'title' => 'Smart Digital Blood Pressure Monitor',
                'desc' => 'Smart voice monitor with LED screen and arrhythmia detector.',
            ],
            'glucometer-kit' => [
                'title' => 'Comprehensive Blood Glucose Meter Kit',
                'desc' => 'Complete glucose kit including meter + 50 test strips + lancing device.',
            ],
            'foldable-wheelchair' => [
                'title' => 'Lightweight Foldable Medical Wheelchair',
                'desc' => 'Reinforced aluminum wheelchair with comfortable armrests and dual hand brakes.',
            ],
            'pulse-oximeter' => [
                'title' => 'Fingertip Pulse Oximeter & Heart Rate Monitor',
                'desc' => 'Fast electronic pulse & oxygen monitor with color OLED display.',
            ],
            'nebulizer-compressor' => [
                'title' => 'Medical Compressor Nebulizer for Asthma',
                'desc' => 'Quiet home nebulizer system suitable for children and adults.',
            ],
            'infrared-thermometer' => [
                'title' => 'Non-Contact Infrared Thermometer',
                'desc' => 'Instant non-contact forehead and object temperature reading in 1 second.',
            ],
            'sterile-wound-dressing-kit' => [
                'title' => 'Comprehensive Sterile Wound Care Kit',
                'desc' => 'High quality sterile bandages and antiseptic kit for wounds and bedsores.',
            ],
            'electric-medical-bed' => [
                'title' => '3-Function Electric Medical Bed for Home Care',
                'desc' => 'Advanced medical bed with remote control for backrest, leg elevation, and height.',
            ],
        ];
    @endphp

    {{-- =================== HERO STORE BANNER =================== --}}
    <section class="relative py-16 sm:py-20 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/3 -translate-y-1/2 w-96 h-96 bg-accent/10 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 32px 32px;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-4">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-bold text-medical-100">
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span>{{ __('products.badge') }}</span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                {{ app()->getLocale()=='en' ? 'Certified Home Medical Devices & Supplies' : 'الأجهزة والمستلزمات الطبية المنزلية المعتمدة' }}
            </h1>

            <p class="text-medical-200 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                {{ __('products.text') }}
            </p>
        </div>
    </section>

    {{-- =================== E-STORE PRODUCTS CATALOG =================== --}}
    <section class="py-12 lg:py-16 bg-surface">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Filter & Search Form --}}
            <form action="{{ route('products') }}" method="GET" class="bg-white p-4 sm:p-5 rounded-2xl shadow-soft border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
                
                {{-- Category Tabs --}}
                <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                    <a href="{{ route('products', array_filter(['search' => request('search'), 'sort' => request('sort')])) }}" 
                       class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all {{ empty($selectedCategory) || $selectedCategory === 'all' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200' }}">
                        {{ __('products.all') }}
                    </a>

                    @foreach($categories as $cat)
                        <a href="{{ route('products', array_filter(['category' => $cat->slug, 'search' => request('search'), 'sort' => request('sort')])) }}" 
                           class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all {{ $selectedCategory === $cat->slug ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200' }}">
                            {{ $catMap[$cat->slug] ?? $cat->name }}
                        </a>
                    @endforeach
                </div>

                {{-- Search Box & Sort --}}
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <div class="relative w-full md:w-64">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('products.search_placeholder') }}" 
                               class="w-full {{ app()->getLocale()=='en' ? 'pl-10 pr-4' : 'pr-10 pl-4' }} py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-medium focus:outline-none focus:border-primary focus:bg-white transition-all">
                        <button type="submit" class="absolute {{ app()->getLocale()=='en' ? 'left-3' : 'right-3' }} top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>

                    <select name="sort" onchange="this.form.submit()" class="h-10 px-3 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-700 font-bold focus:outline-none focus:border-primary">
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>{{ __('products.sort_newest') }}</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>{{ __('products.sort_price_asc') }}</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>{{ __('products.sort_price_desc') }}</option>
                    </select>
                </div>

            </form>

            {{-- Products Grid --}}
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($products as $p)
                        @php
                            $imgMap = [
                                'smart-blood-pressure-monitor' => 'prod-bp.png',
                                'glucometer-kit' => 'prod-glucometer.png',
                                'foldable-wheelchair' => 'prod-wheelchair.png',
                                'pulse-oximeter' => 'prod-oximeter.png',
                                'nebulizer-compressor' => 'prod-nebulizer.png',
                                'infrared-thermometer' => 'prod-supplies.png',
                                'sterile-wound-dressing-kit' => 'prod-firstaid.png',
                                'electric-medical-bed' => 'prod-bed.png',
                            ];
                            $dbImg = str_replace('products/', '', $p->image ?? '');
                            $imgName = (!empty($dbImg) && file_exists(public_path('images/' . $dbImg))) ? $dbImg : ($imgMap[$p->slug] ?? 'prod-bp.png');

                            $displayTitle = (app()->getLocale() == 'en' && isset($productTrans[$p->slug])) ? $productTrans[$p->slug]['title'] : $p->title;
                            $displayDesc = (app()->getLocale() == 'en' && isset($productTrans[$p->slug])) ? $productTrans[$p->slug]['desc'] : $p->short_description;
                            $displayCat = isset($catMap[$p->category->slug ?? '']) ? $catMap[$p->category->slug] : ($p->category->name ?? __('products.cat_supplies'));
                        @endphp

                        <div class="bg-white rounded-3xl border border-gray-100 shadow-soft hover:shadow-card transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                            
                            {{-- Clickable Card Container: Image & Information --}}
                            <a href="{{ route('products.show', $p->slug) }}" class="block p-4 space-y-3 {{ app()->getLocale()=='en' ? 'text-left' : 'text-right' }}">
                                {{-- Product Image Header --}}
                                <div class="relative h-48 overflow-hidden bg-gray-50 flex items-center justify-center p-3 rounded-2xl">
                                    <img src="{{ asset('images/' . $imgName) }}" alt="{{ $displayTitle }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 rounded-xl">
                                    
                                    {{-- Category Badge --}}
                                    <span class="absolute top-3 {{ app()->getLocale()=='en' ? 'right-3' : 'right-3' }} px-2.5 py-1 bg-white/90 backdrop-blur-md text-primary font-bold text-[10px] rounded-lg shadow-sm">
                                        {{ $displayCat }}
                                    </span>

                                    {{-- Discount Badge --}}
                                    @if($p->discount_price && $p->discount_price < $p->price)
                                        @php
                                            $discountPct = round((($p->price - $p->discount_price) / $p->price) * 100);
                                        @endphp
                                        <span class="absolute top-3 {{ app()->getLocale()=='en' ? 'left-3' : 'left-3' }} px-2.5 py-1 bg-red-500 text-white font-extrabold text-[10px] rounded-lg shadow-xs">
                                            {{ __('products.discount') }} {{ $discountPct }}%
                                        </span>
                                    @endif
                                </div>

                                {{-- Details --}}
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between text-[11px] text-gray-400 font-bold">
                                        <span>{{ __('products.code') }}: {{ $p->sku }}</span>
                                        <span class="{{ $p->stock > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                            {{ $p->stock > 0 ? __('products.in_stock') : __('products.out_of_stock') }}
                                        </span>
                                    </div>

                                    <h3 class="font-black text-primary text-sm sm:text-base group-hover:text-accent transition-colors leading-snug line-clamp-2">
                                        {{ $displayTitle }}
                                    </h3>

                                    <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">
                                        {{ $displayDesc }}
                                    </p>
                                </div>
                            </a>

                            {{-- Price & Cart Action Footer --}}
                            <div class="px-4 pb-4 pt-3 border-t border-gray-50 flex items-center justify-between gap-3 bg-gray-50/50">
                                <button type="button" 
                                        onclick="addToCart({ id: {{ $p->id }}, title: '{{ addslashes($displayTitle) }}', price: {{ $p->discount_price ?? $p->price }}, img: '{{ $imgName }}' }); emitLivewire('addToCart', 'product', {{ $p->id }}, 1);" 
                                        class="flex-shrink-0 btn-accent text-xs py-2.5 px-3.5 rounded-xl shadow-md hover:shadow-lg transition-all font-bold flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    <span>{{ __('products.add_to_cart') }}</span>
                                </button>

                                <div class="whitespace-nowrap flex-1 {{ app()->getLocale()=='en' ? 'text-right' : 'text-left' }}">
                                    @if($p->discount_price && $p->discount_price < $p->price)
                                        <div class="text-[11px] text-gray-400 line-through font-bold">
                                            {{ number_format($p->price, 0) }} {{ __('products.sar') }}
                                        </div>
                                        <div class="text-base sm:text-lg font-black text-accent">
                                            {{ number_format($p->discount_price, 0) }} <span class="text-xs font-bold">{{ __('products.sar') }}</span>
                                        </div>
                                    @else
                                        <div class="text-base sm:text-lg font-black text-primary">
                                            {{ number_format($p->price, 0) }} <span class="text-xs font-bold">{{ __('products.sar') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- Pagination Links --}}
                <div class="pt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl p-12 text-center border border-gray-100 shadow-soft space-y-4">
                    <div class="w-16 h-16 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto text-2xl font-bold">
                        🔍
                    </div>
                    <h3 class="text-lg font-black text-primary">{{ __('products.no_results') }}</h3>
                    <p class="text-xs text-gray-500 max-w-sm mx-auto">{{ __('products.no_results_text') }}</p>
                    <a href="{{ route('products') }}" class="inline-block btn-accent px-6 py-2.5 rounded-xl text-xs font-bold shadow-md">
                        {{ __('products.all') }}
                    </a>
                </div>
            @endif

        </div>
    </section>

</x-app-layout>
