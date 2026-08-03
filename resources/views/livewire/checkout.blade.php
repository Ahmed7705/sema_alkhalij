<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if(!$isCompleted)
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 text-right">
            
            {{-- RIGHT COLUMN: Customer Details & Payment Options (8 Cols) --}}
            <div class="lg:col-span-7 space-y-6">
                
                {{-- Flash Message Error --}}
                @if(session()->has('error'))
                    <div class="p-4 rounded-2xl bg-red-50 text-red-600 font-bold text-xs border border-red-100">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Shipping & Contact Info --}}
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-soft border border-gray-100 space-y-5">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <h3 class="text-base font-black text-primary flex items-center gap-2">
                            <span class="w-7 h-7 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xs">1</span>
                            <span>بيانات الشحن والتوصيل الطبي</span>
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- Name --}}
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700">الاسم الكامل *</label>
                            <input type="text" wire:model="name" placeholder="أدخل اسمك الكامل الثلاثي" 
                                   class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-medium focus:outline-none focus:border-primary">
                            @error('name') <span class="text-red-500 text-[11px] font-bold">{{ $message }}</span> @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700">رقم الجوال للتواصل *</label>
                            <input type="text" wire:model="phone" placeholder="05XXXXXXXX" dir="ltr" 
                                   class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary text-right">
                            @error('phone') <span class="text-red-500 text-[11px] font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        {{-- City Dropdown --}}
                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700">المدينة *</label>
                            <select wire:model="city" class="w-full h-11 px-3 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary">
                                <option value="جدة">جدة</option>
                                <option value="الرياض">الرياض</option>
                                <option value="مكة المكرمة">مكة المكرمة</option>
                                <option value="المدينة المنورة">المدينة المنورة</option>
                                <option value="الدمام">الدمام</option>
                                <option value="الخبر">الخبر</option>
                            </select>
                            @error('city') <span class="text-red-500 text-[11px] font-bold">{{ $message }}</span> @enderror
                        </div>

                        {{-- Shipping Address --}}
                        <div class="sm:col-span-2 space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700">العنوان والحي والشارع بالتفصيل *</label>
                            <input type="text" wire:model="address" placeholder="اسم الحي، الشارع، رقم المنزل أو رقم الشقة" 
                                   class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-medium focus:outline-none focus:border-primary">
                            @error('address') <span class="text-red-500 text-[11px] font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700">ملاحظات التوصيل والشحن (اختياري):</label>
                        <textarea wire:model="notes" rows="2" placeholder="أذكر أي تعليمات خاصة بالتوصيل أو الاتصال..." 
                                  class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 focus:outline-none focus:border-primary"></textarea>
                    </div>
                </div>

                {{-- Payment Methods Selector (Official Branded Logos) --}}
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-soft border border-gray-100 space-y-5">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <h3 class="text-base font-black text-primary flex items-center gap-2">
                            <span class="w-7 h-7 rounded-xl bg-primary/10 text-primary flex items-center justify-center text-xs">2</span>
                            <span>طريقة الدفع المفضلة: *</span>
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        
                        {{-- Cash on Delivery / Visit --}}
                        <button type="button" wire:click="$set('payment_method', 'cash')" 
                                class="p-4 rounded-2xl border text-xs font-bold transition-all flex items-center justify-between {{ $payment_method === 'cash' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                            <div class="flex items-center gap-3">
                                <div class="px-2.5 py-1 rounded-lg bg-emerald-600 text-white font-black text-[10px] tracking-wider uppercase shrink-0">
                                    CASH
                                </div>
                                <span>الدفع نقداً عند التوصيل</span>
                            </div>
                            @if($payment_method === 'cash') <span class="font-black text-sm">✓</span> @endif
                        </button>

                        {{-- Mada Card --}}
                        <button type="button" wire:click="$set('payment_method', 'mada')" 
                                class="p-4 rounded-2xl border text-xs font-bold transition-all flex items-center justify-between {{ $payment_method === 'mada' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                            <div class="flex items-center gap-3">
                                <div class="px-2.5 py-1 rounded-lg bg-[#00A499] text-white font-black text-[10px] tracking-wider uppercase shrink-0">
                                    MADA مدى
                                </div>
                                <span>بطاقة مدى (mada)</span>
                            </div>
                            @if($payment_method === 'mada') <span class="font-black text-sm">✓</span> @endif
                        </button>

                        {{-- Visa / Mastercard --}}
                        <button type="button" wire:click="$set('payment_method', 'visa')" 
                                class="p-4 rounded-2xl border text-xs font-bold transition-all flex items-center justify-between {{ $payment_method === 'visa' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                            <div class="flex items-center gap-3">
                                <div class="px-2.5 py-1 rounded-lg bg-[#1A1F71] text-white font-black text-[10px] tracking-wider uppercase shrink-0">
                                    VISA / MC
                                </div>
                                <span>فيزا / ماستركارد</span>
                            </div>
                            @if($payment_method === 'visa') <span class="font-black text-sm">✓</span> @endif
                        </button>

                        {{-- Apple Pay --}}
                        <button type="button" wire:click="$set('payment_method', 'apple_pay')" 
                                class="p-4 rounded-2xl border text-xs font-bold transition-all flex items-center justify-between {{ $payment_method === 'apple_pay' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                            <div class="flex items-center gap-3">
                                <div class="px-2.5 py-1 rounded-lg bg-black text-white font-black text-[10px] tracking-wider shrink-0 flex items-center gap-1">
                                    <span></span> Pay
                                </div>
                                <span>أبل باي (Apple Pay)</span>
                            </div>
                            @if($payment_method === 'apple_pay') <span class="font-black text-sm">✓</span> @endif
                        </button>

                        {{-- Tabby --}}
                        <button type="button" wire:click="$set('payment_method', 'tabby')" 
                                class="p-4 rounded-2xl border text-xs font-bold transition-all flex items-center justify-between {{ $payment_method === 'tabby' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                            <div class="flex items-center gap-3">
                                <div class="px-2.5 py-1 rounded-lg bg-[#3BFF9C] text-black font-black text-[10px] tracking-wider uppercase shrink-0">
                                    tabby
                                </div>
                                <span>تابي (قسمها 4 دفعات)</span>
                            </div>
                            @if($payment_method === 'tabby') <span class="font-black text-sm">✓</span> @endif
                        </button>

                        {{-- Tamara --}}
                        <button type="button" wire:click="$set('payment_method', 'tamara')" 
                                class="p-4 rounded-2xl border text-xs font-bold transition-all flex items-center justify-between {{ $payment_method === 'tamara' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                            <div class="flex items-center gap-3">
                                <div class="px-2.5 py-1 rounded-lg bg-[#FFD368] text-black font-black text-[10px] tracking-wider uppercase shrink-0">
                                    tamara
                                </div>
                                <span>تمارا (دفع آجل بدون فوائد)</span>
                            </div>
                            @if($payment_method === 'tamara') <span class="font-black text-sm">✓</span> @endif
                        </button>

                    </div>
                </div>

            </div>

            {{-- LEFT COLUMN: Order Summary & ZATCA Invoice Preview (4 Cols) --}}
            <div class="lg:col-span-5 space-y-6">
                
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-soft border border-gray-100 space-y-6 sticky top-24">
                    <h3 class="text-base font-black text-primary border-b border-gray-100 pb-4">
                        ملخص طلب الشراء والفوترة
                    </h3>

                    {{-- Items List --}}
                    <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                        @if($cartItems->count() > 0)
                            @foreach($cartItems as $item)
                                @php
                                    $title = $item->product ? $item->product->title : ($item->service ? $item->service->title : 'عنصر طبي');
                                @endphp
                                <div class="flex items-center justify-between text-xs py-2 border-b border-gray-50">
                                    <div class="space-y-0.5 max-w-[180px]">
                                        <h4 class="font-bold text-gray-800 truncate">{{ $title }}</h4>
                                        <span class="text-[10px] text-gray-400 font-bold">الكمية: {{ $item->quantity }}</span>
                                    </div>
                                    <div class="font-black text-primary dir-ltr">
                                        {{ number_format($item->price * $item->quantity, 2) }} ر.س
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-6 text-xs text-gray-400 font-bold">
                                لا توجد عناصر بالسلة حالياً
                            </div>
                        @endif
                    </div>

                    {{-- Price Breakdown --}}
                    <div class="space-y-2.5 text-xs pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-between text-gray-500">
                            <span>المجموع الفرعي:</span>
                            <span class="font-bold text-gray-800 dir-ltr">{{ number_format($subtotal, 2) }} ر.س</span>
                        </div>

                        <div class="flex items-center justify-between text-gray-500">
                            <span>ضريبة القيمة المضافة (15% شاملة):</span>
                            <span class="font-bold text-gray-800 dir-ltr">{{ number_format($tax, 2) }} ر.س</span>
                        </div>

                        <div class="flex items-center justify-between text-gray-500">
                            <span>رسوم التوصيل والشحن:</span>
                            <span class="font-bold text-emerald-600">مجاناً</span>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-gray-200 text-base font-black text-primary">
                            <span>الإجمالي النهائي المطلوب:</span>
                            <span class="text-xl font-black text-accent dir-ltr">{{ number_format($total, 2) }} ر.س</span>
                        </div>
                    </div>

                    {{-- ZATCA Compliance Badge --}}
                    <div class="p-3 bg-surface rounded-xl border border-gray-100 flex items-center gap-2 text-[11px] text-gray-500 font-bold">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>إصدار فاتورة إلكترونية معتمدة من هيئة الزكاة والضريبة والجمارك (ZATCA)</span>
                    </div>

                    {{-- Submit Button --}}
                    <button type="button" wire:click="submitOrder" class="w-full btn-accent py-4 rounded-2xl font-black text-sm shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2">
                        <span>تأكيد ودفع الطلب النهائي</span>
                        <span>✓</span>
                    </button>
                </div>

            </div>

        </div>
    @else
        {{-- SUCCESS & ZATCA e-INVOICE SCREEN --}}
        <div class="max-w-3xl mx-auto bg-white rounded-3xl p-8 sm:p-12 shadow-2xl border border-gray-100 text-center space-y-8">
            
            <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-3xl font-black shadow-inner">
                ✓
            </div>

            <div class="space-y-2">
                <h2 class="text-2xl sm:text-3xl font-black text-primary">تم إصدار وتأكيد طلبك بنجاح!</h2>
                <p class="text-xs text-gray-500 max-w-md mx-auto leading-relaxed">
                    شكراً لك {{ $completedOrder->customer_name }}، تم حفظ طلبك وتوليد الفاتورة الإلكترونية المعتمدة رسمياً.
                </p>
            </div>

            {{-- ZATCA QR CODE DISPLAY --}}
            <div class="p-6 bg-surface rounded-3xl border border-gray-200 inline-block text-center space-y-4">
                <span class="text-xs text-gray-500 font-bold block">الفاتورة الإلكترونية المعتمدة (ZATCA QR Code):</span>
                
                <div class="w-48 h-48 mx-auto bg-white p-3 rounded-2xl shadow-sm border border-gray-200 flex items-center justify-center">
                    <img src="https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl={{ urlencode($completedOrder->zatca_qr) }}" 
                         alt="ZATCA e-Invoice QR Code" 
                         class="w-full h-full object-contain">
                </div>

                <div class="space-y-1">
                    <div class="text-xl font-black text-accent tracking-wider dir-ltr">
                        #{{ $completedOrder->order_number }}
                    </div>
                    <span class="text-[11px] text-gray-400">الرقم الضريبي: 310000000000003</span>
                </div>
            </div>

            {{-- Order Summary Table --}}
            <div class="bg-surface rounded-2xl p-6 border border-gray-200 text-right space-y-3 text-xs">
                <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                    <span class="text-gray-500">اسم العميل ورقم الجوال:</span>
                    <strong class="text-gray-800 font-bold">{{ $completedOrder->customer_name }} ({{ $completedOrder->phone }})</strong>
                </div>

                <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                    <span class="text-gray-500">عنوان التوصيل والمدينة:</span>
                    <strong class="text-gray-800 font-bold">{{ $completedOrder->city }} - {{ $completedOrder->shipping_address }}</strong>
                </div>

                <div class="flex items-center justify-between border-b border-gray-200 pb-2">
                    <span class="text-gray-500">طريقة الدفع المختارة:</span>
                    <strong class="text-primary font-black uppercase">{{ $completedOrder->payment_method }}</strong>
                </div>

                <div class="flex items-center justify-between pt-1 text-sm">
                    <span class="font-bold text-gray-700">المبلغ الإجمالي شامل الضريبة (15%):</span>
                    <strong class="text-xl font-black text-accent dir-ltr">{{ number_format($completedOrder->total_price, 2) }} ر.س</strong>
                </div>
            </div>

            <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                <button onclick="window.print()" class="btn-accent py-3 px-8 rounded-xl font-bold text-xs shadow-md">
                    طباعة / تحميل الفاتورة (PDF)
                </button>
                <a href="{{ route('home') }}" class="py-3 px-8 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs transition-all">
                    العودة للرئيسية
                </a>
            </div>

        </div>
    @endif
</div>
