{{-- Centered Shopping Cart Modal --}}
<div x-show="cartOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        
        {{-- Backdrop --}}
        <div x-show="cartOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
             @click="cartOpen = false" 
             class="fixed inset-0 bg-gray-900/65 backdrop-blur-sm transition-opacity"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        {{-- Centered Modal Card --}}
        <div x-show="cartOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4 sm:translate-y-0" x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4 sm:translate-y-0" 
             class="inline-block align-bottom bg-white rounded-3xl text-right overflow-hidden shadow-floating transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
            
            {{-- Modal Header --}}
            <div class="bg-primary px-6 py-5 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-accent">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">سلة التسوق الطبية</h3>
                        <p class="text-xs text-medical-200" x-text="cartCount > 0 ? cartCount + ' منتجات في السلة' : 'السلة فارغة'"></p>
                    </div>
                </div>
                <button @click="cartOpen = false" class="text-medical-200 hover:text-white transition-colors p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Free Shipping Bar --}}
            <div class="bg-surface px-6 py-3 border-b border-gray-100 flex items-center justify-between text-xs">
                <span class="text-gray-600 font-medium">الشحن المجاني للطلبات فوق 200 ر.س</span>
                <span x-text="cartSubtotal >= 200 ? 'شحن مجاني مُفعل 🎉' : 'متبقي ' + (200 - cartSubtotal) + ' ر.س'" 
                      :class="cartSubtotal >= 200 ? 'text-accent font-bold' : 'text-amber-600 font-bold'"></span>
            </div>

            {{-- Cart Items Body --}}
            <div class="max-h-80 overflow-y-auto p-6 space-y-3">
                <template x-if="cart.length === 0">
                    <div class="text-center py-12 space-y-3">
                        <div class="w-16 h-16 mx-auto rounded-full bg-medical-50 text-accent flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-700 text-sm">سلة التسوق فارغة حالياً</h4>
                        <p class="text-xs text-gray-400 max-w-xs mx-auto">تصفح المتجر الطبي وأضف الأجهزة والمستلزمات إلى سلتك بسهولة.</p>
                    </div>
                </template>

                <template x-for="item in cart" :key="item.id">
                    <div class="flex items-center gap-3 p-3 rounded-2xl bg-surface border border-gray-100">
                        <img :src="'/images/' + item.img" :alt="item.title" class="w-14 h-14 rounded-xl object-cover border border-gray-200 shrink-0">
                        
                        <div class="flex-1 min-w-0 space-y-0.5">
                            <h4 class="font-bold text-xs text-primary truncate" x-text="item.title"></h4>
                            <div class="text-xs font-black text-accent" x-text="item.price + ' ر.س'"></div>
                            
                            {{-- Quantity Counter --}}
                            <div class="flex items-center gap-2 pt-1">
                                <button @click="updateQty(item.id, -1)" class="w-5 h-5 rounded-md bg-white border border-gray-200 flex items-center justify-center text-xs font-bold hover:bg-gray-100 text-gray-700">-</button>
                                <span class="text-xs font-bold text-primary px-1" x-text="item.qty"></span>
                                <button @click="updateQty(item.id, 1)" class="w-5 h-5 rounded-md bg-white border border-gray-200 flex items-center justify-center text-xs font-bold hover:bg-gray-100 text-gray-700">+</button>
                            </div>
                        </div>

                        <button @click="removeFromCart(item.id)" class="text-gray-400 hover:text-red-500 transition-colors p-1" title="حذف">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </template>
            </div>

            {{-- Footer Summary & Checkout Button --}}
            <div x-show="cart.length > 0" class="p-6 border-t border-gray-100 bg-white space-y-4">
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between text-gray-500">
                        <span>المجموع الفرعي</span>
                        <span class="font-bold text-gray-700" x-text="cartSubtotal + ' ر.س'"></span>
                    </div>
                    <div class="flex justify-between text-gray-500">
                        <span>الشحن والتوصيل</span>
                        <span class="font-bold text-accent" x-text="cartSubtotal >= 200 ? 'مجاني' : '25 ر.س'"></span>
                    </div>
                    <div class="flex justify-between text-sm font-black text-primary pt-2 border-t border-gray-100">
                        <span>الإجمالي الكلي (شامل الضريبة)</span>
                        <span class="text-accent text-base" x-text="(cartSubtotal + (cartSubtotal >= 200 ? 0 : 25)) + ' ر.س'"></span>
                    </div>
                </div>

                <button @click="checkoutOpen = true; cartOpen = false" class="w-full btn-accent py-3.5 rounded-xl font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                    <span>متابعة إتمام الطلب</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>

        </div>
    </div>
</div>

{{-- Checkout Modal --}}
<div x-show="checkoutOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="checkoutOpen" @click="checkoutOpen = false" class="fixed inset-0 bg-gray-900/65 backdrop-blur-sm transition-opacity"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div x-show="checkoutOpen" class="inline-block align-bottom bg-white rounded-3xl text-right overflow-hidden shadow-floating transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
            
            <div class="bg-primary px-6 py-5 text-white flex items-center justify-between">
                <div>
                    <span class="inline-block text-xs font-bold text-accent bg-white/10 px-2.5 py-0.5 rounded-full mb-1">دفع آمن ومضمون</span>
                    <h3 class="text-xl font-bold">إتمام طلب المستلزمات الطبية</h3>
                </div>
                <button @click="checkoutOpen = false" class="text-medical-200 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="#" method="POST" @submit.prevent="alert('تم استلام طلبك بنجاح! رقم الشحنة الافتراضي #SA-' + Math.floor(100000 + Math.random() * 900000) + '\nسيتواصل معك مندوب التوصيل فوراً.'); cart = []; checkoutOpen = false;" class="p-6 space-y-4">
                
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">الاسم الكامل <span class="text-red-500">*</span></label>
                    <input type="text" required placeholder="مثال: عبد الله أحمد" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">رقم الجوال <span class="text-red-500">*</span></label>
                        <input type="tel" required placeholder="05xxxxxxxx" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary dir-ltr text-right">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">المدينة <span class="text-red-500">*</span></label>
                        <select class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary">
                            <option>جدة</option>
                            <option>الرياض</option>
                            <option>مكة المكرمة</option>
                            <option>الدمام</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">عنوان التوصيل <span class="text-red-500">*</span></label>
                    <input type="text" required placeholder="الحي، اسم الشارع، رقم المنزل" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs sm:text-sm focus:outline-none focus:border-primary">
                </div>

                {{-- Payment Methods --}}
                <div class="space-y-2 pt-2">
                    <label class="block text-xs font-bold text-gray-700">طريقة الدفع الفضلى</label>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <label class="p-3 border border-gray-200 rounded-xl flex items-center gap-2 cursor-pointer hover:border-accent">
                            <input type="radio" name="pay" checked class="text-accent">
                            <span class="font-bold">الدفع عند الاستلام</span>
                        </label>
                        <label class="p-3 border border-gray-200 rounded-xl flex items-center gap-2 cursor-pointer hover:border-accent">
                            <input type="radio" name="pay" class="text-accent">
                            <span class="font-bold">مدى / Apple Pay</span>
                        </label>
                    </div>
                </div>

                {{-- Total --}}
                <div class="p-4 rounded-xl bg-surface border border-gray-100 flex items-center justify-between text-xs pt-3">
                    <span class="font-bold text-gray-600">المبلغ الإجمالي المطلـوب:</span>
                    <span class="text-base font-black text-accent" x-text="(cartSubtotal + (cartSubtotal >= 200 ? 0 : 25)) + ' ر.س'"></span>
                </div>

                <button type="submit" class="w-full btn-accent py-3.5 rounded-xl font-bold text-xs sm:text-sm shadow-md hover:shadow-lg">
                    تأكيد الطلب والشراء الآن
                </button>
            </form>

        </div>
    </div>
</div>
