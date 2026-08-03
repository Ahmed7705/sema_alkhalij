<x-app-layout :title="$product->title . ' | متجر سيما الخليج الطبي'">

    {{-- Breadcrumb Header --}}
    <div class="bg-surface border-b border-gray-100 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-xs font-bold text-gray-500 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">الرئيسية</a>
            <span>/</span>
            <a href="{{ route('products') }}" class="hover:text-primary transition-colors">المتجر الطبي</a>
            <span>/</span>
            <span class="text-primary font-black">{{ $product->title }}</span>
        </div>
    </div>

    {{-- Main Product Detail Section --}}
    <section class="py-12 bg-white" x-data="{ qty: 1 }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                
                {{-- Product Image Showcase --}}
                @php
                    $imgMap = [
                        'smart-blood-pressure-monitor' => 'service-care.png',
                        'glucometer-kit' => 'service-doctor.png',
                        'foldable-wheelchair' => 'service-nursing.png',
                        'pulse-oximeter' => 'service-sampling.png',
                        'nebulizer-compressor' => 'service-lab.png',
                        'infrared-thermometer' => 'service-telehealth.png',
                        'sterile-wound-dressing-kit' => 'service-physio.png',
                        'electric-medical-bed' => 'medical-team.png',
                    ];
                    $imgName = $imgMap[$product->slug] ?? 'hero-doctor.png';
                @endphp

                <div class="space-y-4">
                    <div class="relative h-96 rounded-3xl bg-surface border border-gray-100 overflow-hidden shadow-soft flex items-center justify-center p-6">
                        <img src="{{ asset('images/' . $imgName) }}" alt="{{ $product->title }}" class="w-full h-full object-cover rounded-2xl shadow-sm">
                        
                        @if($product->discount_price && $product->discount_price < $product->price)
                            @php
                                $discountPct = round((($product->price - $product->discount_price) / $product->price) * 100);
                            @endphp
                            <span class="absolute top-4 right-4 px-3 py-1 bg-red-500 text-white font-black text-xs rounded-xl shadow-md">
                                خصم {{ $discountPct }}%
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Product Information & Purchasing --}}
                <div class="space-y-6 text-right">
                    
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="px-3 py-1 bg-primary/10 text-primary font-bold text-xs rounded-lg">
                                {{ $product->category->name ?? 'مستلزمات طبية' }}
                            </span>
                            <span class="text-xs text-gray-400 font-bold">رمز المنتج: {{ $product->sku }}</span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-black text-primary leading-tight">
                            {{ $product->title }}
                        </h1>
                    </div>

                    {{-- Price Display --}}
                    <div class="p-4 rounded-2xl bg-surface border border-gray-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-gray-600">السعر شامل الضريبة (15%):</span>
                        <div class="flex items-center gap-3">
                            @if($product->discount_price && $product->discount_price < $product->price)
                                <span class="text-sm text-gray-400 line-through font-bold dir-ltr">
                                    {{ number_format($product->price, 2) }} ر.س
                                </span>
                                <span class="text-2xl font-black text-accent dir-ltr">
                                    {{ number_format($product->discount_price, 2) }} ر.س
                                </span>
                            @else
                                <span class="text-2xl font-black text-primary dir-ltr">
                                    {{ number_format($product->price, 2) }} ر.س
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Stock Status --}}
                    <div class="flex items-center gap-2 text-xs font-bold">
                        <span class="w-2.5 h-2.5 rounded-full {{ $product->stock > 0 ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                        <span class="{{ $product->stock > 0 ? 'text-emerald-600' : 'text-red-500' }}">
                            {{ $product->stock > 0 ? 'متوفر بالمخزون الشحن الفوري (' . $product->stock . ' قطعة متوفرة)' : 'غير متوفر حالياً' }}
                        </span>
                    </div>

                    {{-- Short Description --}}
                    <p class="text-sm text-gray-600 leading-relaxed border-t border-b border-gray-100 py-4">
                        {{ $product->short_description }}
                    </p>

                    {{-- Quantity Selector & Interactive E-Commerce Buttons --}}
                    <div class="space-y-4 pt-2">
                        
                        <div class="flex items-center gap-3">
                            <label class="text-xs font-bold text-gray-700">الكمية المطلوبة:</label>
                            <div class="flex items-center border border-gray-200 rounded-xl bg-gray-50 p-1 dir-ltr">
                                <button type="button" @click="if(qty > 1) qty--" class="w-8 h-8 rounded-lg bg-white shadow-xs text-gray-800 font-bold hover:bg-gray-100 flex items-center justify-center">-</button>
                                <span class="w-12 text-center text-sm font-black text-primary" x-text="qty">1</span>
                                <button type="button" @click="qty++" class="w-8 h-8 rounded-lg bg-white shadow-xs text-gray-800 font-bold hover:bg-gray-100 flex items-center justify-center">+</button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            {{-- Add to Cart Livewire Button --}}
                            <button type="button" 
                                    @click="Livewire.emit('addToCart', 'product', {{ $product->id }}, qty)"
                                    class="w-full btn-accent py-3.5 px-6 rounded-2xl font-black text-xs shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <span>أضف للسلة الآن</span>
                            </button>

                            {{-- Buy Now Button --}}
                            <button type="button" 
                                    @click="Livewire.emit('addToCart', 'product', {{ $product->id }}, qty); window.location.href='{{ route('checkout') }}'"
                                    class="w-full bg-primary hover:bg-[#071f18] text-white py-3.5 px-6 rounded-2xl font-black text-xs shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                <span>اشترِ الآن مباشرة</span>
                            </button>
                        </div>

                        {{-- Direct WhatsApp Button --}}
                        <a href="https://wa.me/966500000000?text={{ urlencode('السلام عليكم، أرغب بطلب المنتج الطبي: ' . $product->title . ' (رمز: ' . $product->sku . ')') }}" 
                           target="_blank" 
                           class="w-full bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 text-center py-3 px-6 rounded-2xl font-bold text-xs transition-all flex items-center justify-center gap-2">
                            <span>طلب واستفسار عبر الواتساب</span>
                        </a>

                    </div>

                    {{-- Detailed Description --}}
                    <div class="space-y-3 pt-4 border-t border-gray-100">
                        <h3 class="font-black text-primary text-base">مواصفات وتفاصيل المنتج:</h3>
                        <p class="text-xs text-gray-600 leading-relaxed bg-surface p-4 rounded-2xl border border-gray-100">
                            {{ $product->description }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- Related Products --}}
            @if($relatedProducts->count() > 0)
                <div class="mt-16 pt-12 border-t border-gray-100 space-y-6">
                    <h2 class="text-xl font-black text-primary text-right">منتجات ذات صلة من نفس التصنيف:</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProducts as $rp)
                            @php
                                $rImgName = $imgMap[$rp->slug] ?? 'hero-doctor.png';
                            @endphp
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-soft hover:shadow-card transition-all p-4 space-y-3 text-right">
                                <div class="h-36 bg-gray-50 rounded-xl overflow-hidden">
                                    <img src="{{ asset('images/' . $rImgName) }}" alt="{{ $rp->title }}" class="w-full h-full object-cover">
                                </div>
                                <h4 class="font-bold text-xs text-primary line-clamp-1">
                                    <a href="{{ route('products.show', $rp->slug) }}" class="hover:text-accent transition-colors">
                                        {{ $rp->title }}
                                    </a>
                                </h4>
                                <div class="flex items-center justify-between">
                                    <div class="text-xs font-black text-accent dir-ltr">
                                        {{ number_format($rp->discount_price ?? $rp->price, 0) }} ر.س
                                    </div>
                                    <button type="button" 
                                            onclick="Livewire.emit('addToCart', 'product', {{ $rp->id }}, 1)"
                                            class="p-2 rounded-lg bg-primary/10 hover:bg-primary text-primary hover:text-white transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>

</x-app-layout>
