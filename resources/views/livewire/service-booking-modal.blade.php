<div>
    @if($isOpen)
        <div
            class="fixed inset-0 z-50 overflow-y-auto bg-primary/80 backdrop-blur-md flex items-center justify-center p-4 sm:p-6 transition-all duration-300">

            <div
                class="relative bg-white rounded-3xl shadow-2xl border border-gray-100 max-w-2xl w-full text-right overflow-hidden transform transition-all flex flex-col max-h-[90vh]">

                {{-- Modal Header --}}
                <div
                    class="px-6 py-4 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-white/10 text-accent flex items-center justify-center font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-white">حجز زيارة منزلية جديدة</h3>
                            <p class="text-[11px] text-medical-200">اختر موعدك الطبي بالمنزل بسهولة</p>
                        </div>
                    </div>

                    <button wire:click="closeModal"
                        class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-colors font-bold">
                        ✕
                    </button>
                </div>

                @if(!$isCompleted)
                    {{-- 4-Step Stepper Header --}}
                    <div class="bg-surface px-6 py-3 border-b border-gray-100 shrink-0">
                        <div class="flex items-center justify-between max-w-lg mx-auto">

                            {{-- Step 1 --}}
                            <button type="button" wire:click="goToStep(1)" class="flex items-center gap-2 focus:outline-none">
                                <div
                                    class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs {{ $step >= 1 ? 'bg-primary text-white shadow-sm' : 'bg-gray-200 text-gray-500' }}">
                                    1
                                </div>
                                <span
                                    class="text-xs font-bold {{ $step >= 1 ? 'text-primary' : 'text-gray-400' }} hidden sm:inline">الخدمة</span>
                            </button>

                            <div class="flex-1 h-0.5 mx-2 {{ $step >= 2 ? 'bg-primary' : 'bg-gray-200' }}"></div>

                            {{-- Step 2 --}}
                            <button type="button" wire:click="goToStep(2)" class="flex items-center gap-2 focus:outline-none">
                                <div
                                    class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs {{ $step >= 2 ? 'bg-primary text-white shadow-sm' : 'bg-gray-200 text-gray-500' }}">
                                    2
                                </div>
                                <span
                                    class="text-xs font-bold {{ $step >= 2 ? 'text-primary' : 'text-gray-400' }} hidden sm:inline">الموعد</span>
                            </button>

                            <div class="flex-1 h-0.5 mx-2 {{ $step >= 3 ? 'bg-primary' : 'bg-gray-200' }}"></div>

                            {{-- Step 3 --}}
                            <button type="button" wire:click="goToStep(3)" class="flex items-center gap-2 focus:outline-none">
                                <div
                                    class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs {{ $step >= 3 ? 'bg-primary text-white shadow-sm' : 'bg-gray-200 text-gray-500' }}">
                                    3
                                </div>
                                <span
                                    class="text-xs font-bold {{ $step >= 3 ? 'text-primary' : 'text-gray-400' }} hidden sm:inline">العنوان</span>
                            </button>

                            <div class="flex-1 h-0.5 mx-2 {{ $step >= 4 ? 'bg-primary' : 'bg-gray-200' }}"></div>

                            {{-- Step 4 --}}
                            <button type="button" wire:click="goToStep(4)" class="flex items-center gap-2 focus:outline-none">
                                <div
                                    class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-xs {{ $step >= 4 ? 'bg-primary text-white shadow-sm' : 'bg-gray-200 text-gray-500' }}">
                                    4
                                </div>
                                <span
                                    class="text-xs font-bold {{ $step >= 4 ? 'text-primary' : 'text-gray-400' }} hidden sm:inline">التأكيد</span>
                            </button>

                        </div>
                    </div>

                    {{-- Pre-Selected Service Top Banner --}}
                    @if($selectedService && $step > 1)
                        <div class="bg-primary/5 border-b border-primary/10 px-6 py-2.5 flex items-center justify-between shrink-0">
                            <div class="flex items-center gap-2 text-xs">
                                <span class="text-gray-500">الخدمة المحجوزة:</span>
                                <strong class="text-primary font-black">{{ $selectedService->title }}</strong>
                                <span class="px-2 py-0.5 rounded-md bg-accent/10 text-accent font-extrabold dir-ltr text-[11px]">
                                    {{ number_format($selectedService->discount_price ?? $selectedService->price, 0) }} ر.س
                                </span>
                            </div>

                            <button type="button" wire:click="goToStep(1)"
                                class="text-[11px] font-bold text-primary hover:text-accent underline transition-colors">
                                تغيير الخدمة
                            </button>
                        </div>
                    @endif

                    {{-- Modal Body (Step Wizard Screens) --}}
                    <div class="p-6 overflow-y-auto space-y-5 flex-1">

                        {{-- STEP 1: Select Medical Service --}}
                        @if($step === 1)
                            <div class="space-y-4">
                                <div class="space-y-1">
                                    <h4 class="font-black text-primary text-base">الخطوة 1: اختر الخدمة الطبية المطلوبة</h4>
                                    <p class="text-xs text-gray-500">حدد نوع الكشف أو الخدمة الطبية التي ترغب بحجزها لمنزلك.</p>
                                </div>

                                @error('service_id')
                                    <div class="p-3 rounded-xl bg-red-50 text-red-600 text-xs font-bold border border-red-100">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-72 overflow-y-auto pr-1">
                                    @foreach($services as $s)
                                        <div wire:click="selectService({{ $s->id }})"
                                            class="p-4 rounded-2xl border transition-all cursor-pointer flex flex-col justify-between space-y-2 {{ $service_id == $s->id ? 'border-primary bg-primary/5 shadow-sm ring-1 ring-primary' : 'border-gray-200 bg-white hover:border-gray-300' }}">
                                            <div class="flex items-start justify-between gap-2">
                                                <h5 class="font-bold text-xs text-primary leading-snug">{{ $s->title }}</h5>
                                                <input type="radio" wire:model="service_id" value="{{ $s->id }}"
                                                    class="mt-0.5 text-accent focus:ring-accent">
                                            </div>

                                            <div class="flex items-center justify-between text-[11px] pt-2 border-t border-gray-100">
                                                <span class="text-gray-500">{{ $s->category->name ?? 'خدمة منزلية' }}</span>
                                                <span class="font-black text-accent dir-ltr">
                                                    @if($s->discount_price && $s->discount_price < $s->price)
                                                        {{ number_format($s->discount_price, 0) }} ر.س
                                                    @else
                                                        {{ number_format($s->price, 0) }} ر.س
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- STEP 2: Select Date & Time --}}
                        @if($step === 2)
                            <div class="space-y-4">
                                <div class="space-y-1">
                                    <h4 class="font-black text-primary text-base">الخطوة 2: اختر تاريخ ووقت الزيارة</h4>
                                    <p class="text-xs text-gray-500">حدد التاريخ والوقت المفضلين لحضور الفريق الطبي المنزلي.</p>
                                </div>

                                {{-- Date Picker --}}
                                <div class="space-y-2">
                                    <label class="block text-xs font-bold text-gray-700">تاريخ الزيارة المطلوبة:</label>
                                    <input type="date" wire:model="booking_date" min="{{ date('Y-m-d') }}"
                                        class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary">
                                    @error('booking_date') <span class="text-red-500 text-[11px] font-bold">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Time Slots Grid --}}
                                <div class="space-y-2 pt-2">
                                    <label class="block text-xs font-bold text-gray-700">الفترة الزمنية المناسبة:</label>
                                    @php
                                        $slots = [
                                            '10:00 صباحاً - 12:00 ظهراً',
                                            '12:00 ظهراً - 02:00 مساءً',
                                            '04:00 مساءً - 06:00 مساءً',
                                            '06:00 مساءً - 08:00 مساءً',
                                            '08:00 مساءً - 10:00 مساءً'
                                        ];
                                    @endphp
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                        @foreach($slots as $slot)
                                            <button type="button" wire:click="$set('booking_time', '{{ $slot }}')"
                                                class="p-3 rounded-xl border text-xs font-bold transition-all flex items-center justify-between {{ $booking_time === $slot ? 'bg-primary text-white border-primary shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                                                <span>{{ $slot }}</span>
                                                @if($booking_time === $slot)
                                                    <span
                                                        class="w-4 h-4 rounded-full bg-white text-primary flex items-center justify-center text-[10px]">✓</span>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                    @error('booking_time') <span class="text-red-500 text-[11px] font-bold">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        {{-- STEP 3: Patient Info & Address --}}
                        @if($step === 3)
                            <div class="space-y-4">
                                <div class="space-y-1">
                                    <h4 class="font-black text-primary text-base">الخطوة 3: بيانات المريض وموقع الزيارة</h4>
                                    <p class="text-xs text-gray-500">أدخل اسم المريض ورقم الجوال للتواصل والعنوان بالتفصيل.</p>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    {{-- Patient Name --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold text-gray-700">اسم المريض ثلاثي *</label>
                                        <input type="text" wire:model="patient_name" placeholder="مثال: عبد الله أحمد علي"
                                            class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-medium focus:outline-none focus:border-primary">
                                        @error('patient_name') <span
                                        class="text-red-500 text-[11px] font-bold">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Mobile Phone --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold text-gray-700">رقم الجوال للتواصل *</label>
                                        <input type="text" wire:model="phone" placeholder="05XXXXXXXX" dir="ltr"
                                            class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary text-right">
                                        @error('phone') <span class="text-red-500 text-[11px] font-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    {{-- City Dropdown --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-xs font-bold text-gray-700">المدينة *</label>
                                        <select wire:model="city"
                                            class="w-full h-11 px-3 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary">
                                            <option value="جدة">جدة</option>
                                            <option value="الرياض">الرياض</option>
                                            <option value="مكة المكرمة">مكة المكرمة</option>
                                            <option value="المدينة المنورة">المدينة المنورة</option>
                                            <option value="الدمام">الدمام</option>
                                            <option value="الخبر">الخبر</option>
                                        </select>
                                        @error('city') <span class="text-red-500 text-[11px] font-bold">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Detailed Address --}}
                                    <div class="sm:col-span-2 space-y-1.5">
                                        <label class="block text-xs font-bold text-gray-700">العنوان والحي والشارع *</label>
                                        <input type="text" wire:model="address" placeholder="اسم الحي، الشارع، رقم المنزل أو الشقة"
                                            class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-medium focus:outline-none focus:border-primary">
                                        @error('address') <span class="text-red-500 text-[11px] font-bold">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Medical Notes --}}
                                <div class="space-y-1.5">
                                    <label class="block text-xs font-bold text-gray-700">ملاحظات أو تفاصيل صحية إضافية
                                        (اختياري):</label>
                                    <textarea wire:model="notes" rows="2"
                                        placeholder="أذكر أي أعراض خاصة أو ملاحظات للطبيب أو الفريق الطبي..."
                                        class="w-full p-3 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 focus:outline-none focus:border-primary"></textarea>
                                </div>
                            </div>
                        @endif

                        {{-- STEP 4: Summary & Final Confirmation --}}
                        @if($step === 4)
                            <div class="space-y-4">
                                <div class="space-y-1">
                                    <h4 class="font-black text-primary text-base">الخطوة 4: مراجعة وتأكيد الحجز النهائي</h4>
                                    <p class="text-xs text-gray-500">راجع تفاصيل حجزك قبل التأكيد النهائي.</p>
                                </div>

                                {{-- Summary Box --}}
                                <div class="bg-surface rounded-2xl p-4 border border-gray-200 space-y-3 text-xs">
                                    <div class="flex items-center justify-between pb-2 border-b border-gray-200">
                                        <span class="text-gray-500">الخدمة المختارة:</span>
                                        <strong class="text-primary font-black">{{ $selectedService->title ?? '' }}</strong>
                                    </div>

                                    <div class="flex items-center justify-between pb-2 border-b border-gray-200">
                                        <span class="text-gray-500">موعد وتاريخ الزيارة:</span>
                                        <strong class="text-gray-800 font-bold">{{ $booking_date }} | {{ $booking_time }}</strong>
                                    </div>

                                    <div class="flex items-center justify-between pb-2 border-b border-gray-200">
                                        <span class="text-gray-500">اسم المريض والجوال:</span>
                                        <strong class="text-gray-800 font-bold">{{ $patient_name }} ({{ $phone }})</strong>
                                    </div>

                                    <div class="flex items-center justify-between pb-2 border-b border-gray-200">
                                        <span class="text-gray-500">العنوان والمدينة:</span>
                                        <strong class="text-gray-800 font-bold">{{ $city }} - {{ $address }}</strong>
                                    </div>

                                    <div class="flex items-center justify-between pt-1 text-sm">
                                        <span class="font-bold text-gray-700">إجمالي المبلغ المطلوب:</span>
                                        <strong class="text-xl font-black text-accent dir-ltr">
                                            @if($selectedService)
                                                {{ number_format($selectedService->discount_price ?? $selectedService->price, 2) }} ر.س
                                            @endif
                                        </strong>
                                    </div>
                                </div>

                                {{-- Payment Method Selector (100% SVG Vector Icons, ZERO Emojis) --}}
                                <div class="space-y-2.5">
                                    <label class="block text-xs font-bold text-gray-700">طريقة الدفع المفضلة: *</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">

                                        {{-- Cash on Visit --}}
                                        <button type="button" wire:click="$set('payment_method', 'cash')"
                                            class="p-3.5 rounded-2xl border text-xs font-bold transition-all flex items-center justify-between {{ $payment_method === 'cash' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                                            <div class="flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 rounded-lg flex items-center justify-center {{ $payment_method === 'cash' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-600' }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                    </svg>
                                                </div>
                                                <span>الدفع نقداً عند الزيارة</span>
                                            </div>
                                            @if($payment_method === 'cash') <span class="font-black text-sm">✓</span> @endif
                                        </button>

                                        {{-- Mada Card --}}
                                        <button type="button" wire:click="$set('payment_method', 'mada')"
                                            class="p-3.5 rounded-2xl border text-xs font-bold transition-all flex items-center justify-between {{ $payment_method === 'mada' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                                            <div class="flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 rounded-lg flex items-center justify-center {{ $payment_method === 'mada' ? 'bg-white/20 text-white' : 'bg-teal-100 text-teal-600' }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                        viewBox="0 0 24 24">
                                                        <rect x="2" y="5" width="20" height="14" rx="2" />
                                                        <line x1="2" y1="10" x2="22" y2="10" />
                                                    </svg>
                                                </div>
                                                <span>بطاقة مدى (mada)</span>
                                            </div>
                                            @if($payment_method === 'mada') <span class="font-black text-sm">✓</span> @endif
                                        </button>

                                        {{-- Visa / Mastercard --}}
                                        <button type="button" wire:click="$set('payment_method', 'visa')"
                                            class="p-3.5 rounded-2xl border text-xs font-bold transition-all flex items-center justify-between {{ $payment_method === 'visa' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                                            <div class="flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 rounded-lg flex items-center justify-center {{ $payment_method === 'visa' ? 'bg-white/20 text-white' : 'bg-blue-100 text-blue-600' }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <span>فيزا / ماستركارد (Visa/Mastercard)</span>
                                            </div>
                                            @if($payment_method === 'visa') <span class="font-black text-sm">✓</span> @endif
                                        </button>

                                        {{-- Apple Pay --}}
                                        <button type="button" wire:click="$set('payment_method', 'apple_pay')"
                                            class="p-3.5 rounded-2xl border text-xs font-bold transition-all flex items-center justify-between {{ $payment_method === 'apple_pay' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                                            <div class="flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 rounded-lg flex items-center justify-center {{ $payment_method === 'apple_pay' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-800' }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <span>أبل باي (Apple Pay)</span>
                                            </div>
                                            @if($payment_method === 'apple_pay') <span class="font-black text-sm">✓</span> @endif
                                        </button>

                                        {{-- Tabby --}}
                                        <button type="button" wire:click="$set('payment_method', 'tabby')"
                                            class="p-3.5 rounded-2xl border text-xs font-bold transition-all flex items-center justify-between {{ $payment_method === 'tabby' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                                            <div class="flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 rounded-lg flex items-center justify-center {{ $payment_method === 'tabby' ? 'bg-white/20 text-white' : 'bg-purple-100 text-purple-600' }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                                    </svg>
                                                </div>
                                                <span>تابي (Tabby - قسمها على 4 دفعات)</span>
                                            </div>
                                            @if($payment_method === 'tabby') <span class="font-black text-sm">✓</span> @endif
                                        </button>

                                        {{-- Tamara --}}
                                        <button type="button" wire:click="$set('payment_method', 'tamara')"
                                            class="p-3.5 rounded-2xl border text-xs font-bold transition-all flex items-center justify-between {{ $payment_method === 'tamara' ? 'bg-primary text-white border-primary shadow-sm' : 'bg-gray-50 text-gray-700 border-gray-200 hover:bg-gray-100' }}">
                                            <div class="flex items-center gap-2.5">
                                                <div
                                                    class="w-7 h-7 rounded-lg flex items-center justify-center {{ $payment_method === 'tamara' ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-600' }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <span>تمارا (Tamara - دفع آجل بدون فوائد)</span>
                                            </div>
                                            @if($payment_method === 'tamara') <span class="font-black text-sm">✓</span> @endif
                                        </button>

                                    </div>
                                </div>

                            </div>
                        @endif

                    </div>

                    {{-- Modal Footer --}}
                    <div class="px-6 py-4 bg-surface border-t border-gray-100 flex items-center justify-between shrink-0">
                        @if($step > 1)
                            <button type="button" wire:click="previousStep"
                                class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs transition-all">
                                &rarr; الخطوة السابقة
                            </button>
                        @else
                            <div></div>
                        @endif

                        @if($step < 4)
                            <button type="button" wire:click="nextStep"
                                class="btn-accent px-6 py-2.5 rounded-xl font-bold text-xs shadow hover:shadow-md transition-all flex items-center gap-2">
                                <span>التالي</span>
                                <span>&larr;</span>
                            </button>
                        @else
                            <button type="button" wire:click="submitBooking"
                                class="btn-accent px-8 py-3 rounded-xl font-black text-xs shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
                                <span>تأكيد وإرسال طلب الحجز النهائي</span>
                                <span>✓</span>
                            </button>
                        @endif
                    </div>
                @else
                    {{-- SUCCESS SCREEN --}}
                    <div class="p-8 text-center space-y-5 my-auto">
                        <div
                            class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto text-3xl font-black shadow-inner">
                            ✓
                        </div>

                        <div class="space-y-2">
                            <h3 class="text-2xl font-black text-primary">تم تسجيل طلب الحجز بنجاح!</h3>
                            <p class="text-xs text-gray-500 max-w-md mx-auto leading-relaxed">
                                شكراً لك، تم حفظ طلب الزيارة المنزلية وسيتم التواصل معك من قبل فريق التنسيق الطبي خلال 15 دقيقة
                                لتأكيد تفاصيل الوصول.
                            </p>
                        </div>

                        <div class="p-4 bg-surface rounded-2xl border border-gray-200 inline-block text-center space-y-1">
                            <span class="text-xs text-gray-500 font-bold">رقم الحجز المعتمد:</span>
                            <div class="text-2xl font-black text-accent tracking-wider dir-ltr">
                                #{{ $completedBookingNumber }}
                            </div>
                        </div>

                        <div class="pt-4 flex items-center justify-center gap-3">
                            <button wire:click="closeModal" class="btn-accent py-3 px-8 rounded-xl font-bold text-xs shadow-md">
                                إغلاق النافذة
                            </button>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    @endif
</div>