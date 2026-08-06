<x-app-layout :title="$product->title . ' | ' . (app()->getLocale()=='en' ? 'Sema Al-Khalij Medical Store' : 'متجر سيما الخليج الطبي')">

    @php
        $isEn = app()->getLocale() == 'en';

        $catMap = [
            'medical-devices' => $isEn ? 'Home Medical Devices' : 'الأجهزة الطبية المنزلية',
            'medical-supplies' => $isEn ? 'Medical Supplies' : 'المستلزمات الطبية',
            'mobility-beds' => $isEn ? 'Beds & Wheelchairs' : 'الكراسي والأسرة الطبية',
        ];

        $productTrans = [
            'smart-blood-pressure-monitor' => [
                'title' => 'Smart Digital Blood Pressure Monitor',
                'desc' => 'Smart voice monitor with LED screen and arrhythmia detector.',
                'full_desc' => 'Smart voice monitor with LED screen, arrhythmia detector, dual user memory, and universal arm cuff.',
            ],
            'glucometer-kit' => [
                'title' => 'Comprehensive Blood Glucose Meter Kit',
                'desc' => 'Complete glucose kit including meter + 50 test strips + lancing device.',
                'full_desc' => 'Complete glucose kit including digital meter, 50 sterile test strips, lancing device, 50 lancets, and carrying case.',
            ],
            'foldable-wheelchair' => [
                'title' => 'Lightweight Foldable Medical Wheelchair',
                'desc' => 'Reinforced aluminum wheelchair with comfortable armrests and dual hand brakes.',
                'full_desc' => 'Supports up to 120 kg, easy to fold and place in car trunk, shock-absorbing with anti-bedsore comfortable seat.',
            ],
            'pulse-oximeter' => [
                'title' => 'Fingertip Pulse Oximeter & Heart Rate Monitor',
                'desc' => 'Fast electronic pulse & oxygen monitor with color OLED display.',
                'full_desc' => 'Fast electronic pulse and oxygen saturation (SpO2) monitor with multi-directional color OLED display.',
            ],
            'nebulizer-compressor' => [
                'title' => 'Medical Compressor Nebulizer for Asthma',
                'desc' => 'Quiet home nebulizer system suitable for children and adults.',
                'full_desc' => 'Quiet home aerosol nebulizer system for asthma and allergy treatment, suitable for both children and adults.',
            ],
            'infrared-thermometer' => [
                'title' => 'Non-Contact Infrared Thermometer',
                'desc' => 'Instant non-contact forehead and object temperature reading in 1 second.',
                'full_desc' => 'Instant non-contact forehead and surface temperature measurement in 1 second with color fever alert backlight.',
            ],
            'sterile-wound-dressing-kit' => [
                'title' => 'Comprehensive Sterile Wound Care Kit',
                'desc' => 'High quality sterile bandages and antiseptic kit for wounds and bedsores.',
                'full_desc' => 'High quality sterile bandages, gauze pads, antiseptic solutions, medical tape, and gloves for wounds and bedsores.',
            ],
            'electric-medical-bed' => [
                'title' => '3-Function Electric Medical Bed for Home Care',
                'desc' => 'Advanced medical bed with remote control for backrest, leg elevation, and height.',
                'full_desc' => 'Advanced medical bed with remote control for backrest, leg elevation, and height adjustment, includes side rails and medical mattress.',
            ],
        ];

        $displayTitle = ($isEn && isset($productTrans[$product->slug])) ? $productTrans[$product->slug]['title'] : $product->title;
        $displayShortDesc = ($isEn && isset($productTrans[$product->slug])) ? $productTrans[$product->slug]['desc'] : $product->short_description;
        $displayFullDesc = ($isEn && isset($productTrans[$product->slug])) ? $productTrans[$product->slug]['full_desc'] : $product->description;
        $displayCat = isset($catMap[$product->category->slug ?? '']) ? $catMap[$product->category->slug] : ($product->category->name ?? __('products.cat_supplies'));
    @endphp

    {{-- Breadcrumb Header --}}
    <div class="bg-surface border-b border-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">{{ $isEn ? 'Home' : 'الرئيسية' }}</a>
            <span>/</span>
            <a href="{{ route('products') }}" class="hover:text-primary transition-colors">{{ $isEn ? 'Medical Store' : 'المتجر الطبي' }}</a>
            <span>/</span>
            <span class="text-primary font-black">{{ $displayTitle }}</span>
        </div>
    </div>

    {{-- Main Product Detail Section --}}
    <section class="py-12 bg-white" x-data="{ qty: 1 }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                
                {{-- Product Image Showcase --}}
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
                    $dbImg = str_replace('products/', '', $product->image ?? '');
                    $imgName = (!empty($dbImg) && file_exists(public_path('images/' . $dbImg))) ? $dbImg : ($imgMap[$product->slug] ?? 'prod-bp.png');
                @endphp

                <div class="space-y-4">
                    <div class="relative h-96 rounded-3xl bg-surface border border-gray-100 overflow-hidden shadow-soft flex items-center justify-center p-6">
                        <img src="{{ asset('images/' . $imgName) }}" alt="{{ $displayTitle }}" class="w-full h-full object-cover rounded-2xl shadow-sm">
                        
                        @if($product->discount_price && $product->discount_price < $product->price)
                            @php
                                $discountPct = round((($product->price - $product->discount_price) / $product->price) * 100);
                            @endphp
                            <span class="absolute top-4 {{ $isEn ? 'left-4' : 'right-4' }} px-3 py-1 bg-red-500 text-white font-black text-xs rounded-xl shadow-md">
                                {{ __('products.discount') }} {{ $discountPct }}%
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Product Information & Purchasing --}}
                <div class="space-y-6 {{ $isEn ? 'text-left' : 'text-right' }}">
                    
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 bg-primary/10 text-primary font-bold text-xs rounded-lg">
                                {{ $displayCat }}
                            </span>
                            <span class="text-xs text-gray-400 font-bold">{{ __('products.code') }}: {{ $product->sku }}</span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-black text-primary leading-tight">
                            {{ $displayTitle }}
                        </h1>
                    </div>

                    {{-- Price Display --}}
                    <div class="p-4 rounded-2xl bg-surface border border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-600">{{ $isEn ? 'Price includes VAT (15%):' : 'السعر شامل الضريبة (15%):' }}</span>
                        <div class="flex items-center gap-3">
                            @if($product->discount_price && $product->discount_price < $product->price)
                                <span class="text-sm text-gray-400 line-through font-bold dir-ltr">
                                    {{ number_format($product->price, 2) }} {{ __('products.sar') }}
                                </span>
                                <span class="text-2xl font-black text-accent dir-ltr">
                                    {{ number_format($product->discount_price, 2) }} {{ __('products.sar') }}
                                </span>
                            @else
                                <span class="text-2xl font-black text-primary dir-ltr">
                                    {{ number_format($product->price, 2) }} {{ __('products.sar') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Stock Status --}}
                    <div class="flex items-center gap-2 text-xs font-bold">
                        <span class="w-2.5 h-2.5 rounded-full {{ $product->stock > 0 ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                        <span class="{{ $product->stock > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                            @if($product->stock > 0)
                                {{ $isEn ? 'In Stock — Fast Shipping (' . $product->stock . ' available)' : 'متوفر بالمخزون الشحن الفوري (' . $product->stock . ' قطعة متوفرة)' }}
                            @else
                                {{ __('products.out_of_stock') }}
                            @endif
                        </span>
                    </div>

                    {{-- Short Description --}}
                    <p class="text-sm text-gray-600 leading-relaxed border-t border-b border-gray-100 py-4">
                        {{ $displayShortDesc }}
                    </p>

                    {{-- Quantity Selector & Interactive E-Commerce Buttons --}}
                    <div class="space-y-4 pt-2">
                        
                        <div class="flex items-center gap-3">
                            <label class="text-xs font-bold text-gray-700">{{ $isEn ? 'Quantity:' : 'الكمية المطلوبة:' }}</label>
                            <div class="flex items-center border border-gray-200 rounded-xl bg-gray-50 p-1 dir-ltr">
                                <button type="button" @click="if(qty > 1) qty--" class="w-8 h-8 rounded-lg bg-white shadow-xs text-gray-800 font-bold hover:bg-gray-100 flex items-center justify-center">-</button>
                                <span class="w-12 text-center text-sm font-black text-primary" x-text="qty">1</span>
                                <button type="button" @click="qty++" class="w-8 h-8 rounded-lg bg-white shadow-xs text-gray-800 font-bold hover:bg-gray-100 flex items-center justify-center">+</button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            {{-- Add to Cart Button --}}
                            <button type="button" 
                                    @click="addToCart({ id: {{ $product->id }}, title: '{{ addslashes($displayTitle) }}', price: {{ $product->discount_price ?? $product->price }}, img: '{{ $imgName }}', qty: qty }); emitLivewire('addToCart', 'product', {{ $product->id }}, qty)"
                                    class="w-full btn-accent py-3.5 px-6 rounded-2xl font-black text-xs shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <span>{{ $isEn ? 'Add to Cart Now' : 'أضف للسلة الآن' }}</span>
                            </button>

                            {{-- Buy Now Button --}}
                            <button type="button" 
                                    @click="addToCart({ id: {{ $product->id }}, title: '{{ addslashes($displayTitle) }}', price: {{ $product->discount_price ?? $product->price }}, img: '{{ $imgName }}', qty: qty }); emitLivewire('addToCart', 'product', {{ $product->id }}, qty); checkoutOpen = true"
                                    class="w-full bg-primary hover:bg-[#071f18] text-white py-3.5 px-6 rounded-2xl font-black text-xs shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                <span>{{ $isEn ? 'Buy Now Directly' : 'اشترِ الآن مباشرة' }}</span>
                            </button>
                        </div>

                        {{-- Direct WhatsApp Button --}}
                        <a href="https://wa.me/966545880082?text={{ urlencode($isEn ? 'Hello, I would like to order product: ' . $displayTitle . ' (SKU: ' . $product->sku . ')' : 'السلام عليكم، أرغب بطلب المنتج الطبي: ' . $product->title . ' (رمز: ' . $product->sku . ')') }}" 
                           target="_blank" 
                           class="w-full bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-center py-3 px-6 rounded-2xl font-bold text-xs transition-all flex items-center justify-center gap-2">
                            <span>{{ $isEn ? 'Inquire & Order via WhatsApp' : 'طلب واستفسار عبر الواتساب' }}</span>
                        </a>

                    </div>

                    {{-- Detailed Description --}}
                    <div class="space-y-3 pt-4 border-t border-gray-100">
                        <h3 class="font-black text-primary text-base">{{ $isEn ? 'Product Specifications & Details:' : 'مواصفات وتفاصيل المنتج:' }}</h3>
                        <p class="text-xs text-gray-600 leading-relaxed bg-surface p-4 rounded-2xl border border-gray-100">
                            {{ $displayFullDesc }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- Related Products --}}
            @if($relatedProducts->count() > 0)
                <div class="mt-16 pt-12 border-t border-gray-100 space-y-6">
                    <h2 class="text-xl font-black text-primary {{ $isEn ? 'text-left' : 'text-right' }}">{{ $isEn ? 'Related Products in Same Category:' : 'منتجات ذات صلة من نفس التصنيف:' }}</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $rp)
                            @php
                                $rDbImg = str_replace('products/', '', $rp->image ?? '');
                                $rImgName = (!empty($rDbImg) && file_exists(public_path('images/' . $rDbImg))) ? $rDbImg : ($imgMap[$rp->slug] ?? 'prod-bp.png');
                                $rTitle = ($isEn && isset($productTrans[$rp->slug])) ? $productTrans[$rp->slug]['title'] : $rp->title;
                            @endphp
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-soft hover:shadow-card transition-all p-4 space-y-3 {{ $isEn ? 'text-left' : 'text-right' }}">
                                <div class="h-36 bg-gray-50 rounded-xl overflow-hidden">
                                    <img src="{{ asset('images/' . $rImgName) }}" alt="{{ $rTitle }}" class="w-full h-full object-cover">
                                </div>
                                <h4 class="font-bold text-xs text-primary line-clamp-1">
                                    <a href="{{ route('products.show', $rp->slug) }}" class="hover:text-accent transition-colors">
                                        {{ $rTitle }}
                                    </a>
                                </h4>
                                <div class="flex items-center justify-between gap-2">
                                    <button type="button" 
                                            onclick="emitLivewire('addToCart', 'product', {{ $rp->id }}, 1)"
                                            class="p-2 rounded-lg bg-primary/10 hover:bg-primary text-primary hover:text-white transition-colors"
                                            title="{{ __('products.add_to_cart') }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    </button>
                                    <div class="text-xs font-black text-accent {{ $isEn ? 'text-right' : 'text-left' }} whitespace-nowrap">
                                        {{ number_format($rp->discount_price ?? $rp->price, 0) }} <span class="text-[10px]">{{ __('products.sar') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>

</x-app-layout>
