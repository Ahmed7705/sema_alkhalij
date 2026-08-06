<div>
    @php
        $isEn = app()->getLocale() == 'en';
    @endphp

    {{-- Centered Global Store Luxury Modal --}}
    @if($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto bg-primary/80 backdrop-blur-md flex items-center justify-center p-4 sm:p-6 transition-all duration-300">
            
            {{-- Modal Box Container --}}
            <div class="relative bg-white rounded-3xl shadow-2xl border border-gray-100 max-w-xl w-full {{ $isEn ? 'text-left' : 'text-right' }} overflow-hidden transform transition-all flex flex-col max-h-[85vh]">
                
                {{-- Header --}}
                <div class="px-6 py-4 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/10 text-accent flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-white">{{ $isEn ? 'Medical Shopping Cart' : 'سلة التسوق الطبية' }}</h3>
                            <p class="text-[11px] text-medical-200">{{ $isEn ? 'Review your selected medical products and services' : 'تصفح وراجع العناصر المحفوطة بالسلة' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 bg-white/10 text-accent font-bold text-xs rounded-full">
                            {{ $cartCount }} {{ $isEn ? 'items' : 'عناصر' }}
                        </span>
                        <button wire:click="closeDrawer" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors font-bold">
                            ✕
                        </button>
                    </div>
                </div>

                {{-- Cart Items List --}}
                <div class="p-6 overflow-y-auto space-y-4 flex-1">
                    @if($cartItems->count() > 0)
                        @foreach($cartItems as $item)
                            @php
                                $title = $item->product ? $item->product->title : ($item->service ? $item->service->title : ($isEn ? 'Medical Item' : 'عنصر طبي'));
                                $typeLabel = $item->product ? ($isEn ? 'Medical Product' : 'منتج طبي') : ($isEn ? 'Home Service' : 'خدمة منزلية');
                                $imgSlug = $item->product ? $item->product->slug : ($item->service ? $item->service->slug : '');
                                
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
                                $imgName = $imgMap[$imgSlug] ?? 'hero-doctor.png';
                            @endphp
                            
                            <div class="bg-surface p-4 rounded-2xl border border-gray-100 flex items-center gap-4 transition-all hover:border-gray-200">
                                
                                {{-- Thumbnail --}}
                                <div class="w-16 h-16 rounded-xl bg-white p-1 border border-gray-100 shrink-0 overflow-hidden">
                                    <img src="{{ asset('images/' . $imgName) }}" alt="{{ $title }}" class="w-full h-full object-cover rounded-lg">
                                </div>

                                {{-- Details --}}
                                <div class="flex-1 space-y-1 {{ $isEn ? 'text-left' : 'text-right' }}">
                                    <div class="flex items-center justify-between">
                                        <span class="px-2.5 py-0.5 rounded-md bg-primary/10 text-primary font-extrabold text-[10px]">
                                            {{ $typeLabel }}
                                        </span>
                                        
                                        <button wire:click="removeFromCart({{ $item->id }})" class="text-gray-400 hover:text-red-500 text-xs font-bold transition-colors">
                                            {{ $isEn ? 'Remove ✕' : 'حذف ✕' }}
                                        </button>
                                    </div>

                                    <h4 class="font-bold text-xs text-primary leading-snug line-clamp-1">
                                        {{ $title }}
                                    </h4>

                                    <div class="flex items-center justify-between pt-1">
                                        {{-- Quantity Selector --}}
                                        <div class="flex items-center border border-gray-200 rounded-lg bg-white overflow-hidden dir-ltr">
                                            <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" class="w-6 h-6 flex items-center justify-center text-xs text-gray-600 hover:bg-gray-100 font-bold">-</button>
                                            <span class="px-3 text-xs font-black text-gray-800">{{ $item->quantity }}</span>
                                            <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" class="w-6 h-6 flex items-center justify-center text-xs text-gray-600 hover:bg-gray-100 font-bold">+</button>
                                        </div>

                                        <div class="text-xs font-black text-accent">
                                            {{ number_format($item->price * $item->quantity, 2) }} <span class="text-[10px]">{{ __('products.sar') }}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-16 space-y-4 my-auto">
                            <div class="w-16 h-16 rounded-2xl bg-medical-50 text-primary flex items-center justify-center mx-auto border border-primary/10">
                                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                            <h4 class="text-base font-black text-primary">{{ $isEn ? 'Your Shopping Cart is Empty' : 'سلة التسوق فارغة حالياً' }}</h4>
                            <p class="text-xs text-gray-500 max-w-xs mx-auto">{{ $isEn ? 'Browse our medical products and services to add items easily.' : 'تصفح الخدمات والمنتجات الطبية وأضف ما تحتاجه لسلتك بسهولة.' }}</p>
                        </div>
                    @endif
                </div>

                {{-- Footer Summary & Action Buttons --}}
                @if($cartItems->count() > 0)
                    <div class="p-6 bg-surface border-t border-gray-100 space-y-4 shrink-0">
                        
                        <div class="space-y-2 text-xs bg-white p-4 rounded-2xl border border-gray-100">
                            <div class="flex items-center justify-between text-gray-500">
                                <span>{{ $isEn ? 'Subtotal:' : 'المجموع الفرعي:' }}</span>
                                <span class="font-bold text-gray-800">{{ number_format($subtotal, 2) }} <span class="text-[10px]">{{ __('products.sar') }}</span></span>
                            </div>
                            <div class="flex items-center justify-between text-gray-500">
                                <span>{{ $isEn ? 'VAT (15% Included):' : 'ضريبة القيمة المضافة (15% شاملة):' }}</span>
                                <span class="font-bold text-gray-800">{{ number_format($tax, 2) }} <span class="text-[10px]">{{ __('products.sar') }}</span></span>
                            </div>
                            <div class="flex items-center justify-between pt-2 border-t border-gray-100 text-sm font-black text-primary">
                                <span>{{ $isEn ? 'Grand Total:' : 'الإجمالي النهائي المطلوب:' }}</span>
                                <span class="text-lg font-black text-accent">{{ number_format($total, 2) }} <span class="text-xs">{{ __('products.sar') }}</span></span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <a href="{{ route('checkout') }}" class="btn-accent py-3 px-6 rounded-xl font-black text-xs shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                                <span>{{ $isEn ? 'Proceed to Checkout' : 'متابعة الشراء والدفع' }}</span>
                                <svg class="w-4 h-4 {{ $isEn ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            </a>
                            
                            <button wire:click="closeDrawer" class="py-3 px-6 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs transition-all">
                                {{ $isEn ? 'Close & Continue Shopping' : 'إغلاق ومتابعة التسوق' }}
                            </button>
                        </div>

                    </div>
                @endif

            </div>

        </div>
    @endif
</div>
