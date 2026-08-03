<x-app-layout title="لوحة العميل وحساب المريض | سيما الخليج للخدمات الطبية">

    {{-- =================== PROFILE HERO HEADER =================== --}}
    <section class="relative py-12 sm:py-16 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                
                {{-- Avatar & Info --}}
                <div class="flex items-center gap-4 text-center sm:text-right">
                    <div class="relative">
                        <div class="w-20 h-20 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-accent font-black text-2xl flex items-center justify-center shadow-lg">
                            {{ Auth::check() ? mb_substr(Auth::user()->name, 0, 2) : 'ضيف' }}
                        </div>
                        <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-accent text-white flex items-center justify-center text-[10px] font-bold border-2 border-primary" title="حساب موثق">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                    </div>
                    
                    <div class="space-y-1">
                        <div class="flex items-center justify-center sm:justify-start gap-2">
                            <h1 class="text-2xl font-black">{{ Auth::check() ? Auth::user()->name : 'مستخدم زائر' }}</h1>
                            <span class="px-2.5 py-0.5 rounded-full bg-accent/20 text-accent border border-accent/30 text-[10px] font-bold">
                                {{ Auth::check() && Auth::user()->role === 'admin' ? 'مدير النظام' : 'عضوية مميزة' }}
                            </span>
                        </div>
                        <p class="text-xs text-medical-200">البريد: {{ Auth::check() ? Auth::user()->email : 'مستخدم زائر' }} • {{ Auth::check() && Auth::user()->phone ? Auth::user()->phone : '05xxxxxxxx' }}</p>
                        <p class="text-[11px] text-medical-300">عضو منذ {{ Auth::check() ? Auth::user()->created_at->format('Y/m/d') : date('Y/m/d') }}</p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3">
                    @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->isSuperAdmin()))
                        <a href="{{ route('admin.dashboard') }}" class="py-2.5 px-5 rounded-xl bg-accent text-white font-black text-xs shadow-lg hover:bg-accent-hover transition-all flex items-center gap-1.5 border border-white/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>لوحة تحكم الأدمن</span>
                        </a>
                    @endif

                    <a href="{{ route('services') }}" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 rounded-xl text-xs font-bold transition-all text-white border border-white/10">
                        حجز خدمة جديدة
                    </a>
                    @if(Auth::check())
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 rounded-xl text-xs font-bold transition-all text-white cursor-pointer border-0">
                                تسجيل الخروج
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </section>

    {{-- =================== FLASH MESSAGES =================== --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-700 font-bold text-xs border border-emerald-100 flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>
    @endif

    {{-- =================== PROFILE DASHBOARD TABS =================== --}}
    <section class="py-12 bg-surface" x-data="{ activeTab: 'visits' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Tabs Navigation --}}
            <div class="bg-white p-2 rounded-2xl shadow-soft border border-gray-100 flex flex-wrap items-center gap-2">
                <button @click="activeTab = 'visits'" :class="activeTab === 'visits' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>الزيارات والمواعيد ({{ $bookings->count() }})</span>
                </button>
                
                <button @click="activeTab = 'orders'" :class="activeTab === 'orders' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span>طلباتي من المتجر ({{ $orders->count() }})</span>
                </button>

                <button @click="activeTab = 'addresses'" :class="activeTab === 'addresses' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>عناويني المحفوظة ({{ $addresses->count() }})</span>
                </button>

                <button @click="activeTab = 'info'" :class="activeTab === 'info' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>البيانات الشخصية والكلمة السرية</span>
                </button>
            </div>

            {{-- TAB 1: VISITS & APPOINTMENTS --}}
            <div x-show="activeTab === 'visits'" class="space-y-4">
                <div class="bg-white p-6 rounded-3xl shadow-soft border border-gray-100 space-y-4 text-right">
                    <h3 class="font-black text-lg text-primary">المواعيد والزيارات الطبية المنزلية</h3>
                    
                    @if($bookings->count() > 0)
                        <div class="space-y-3">
                            @foreach($bookings as $b)
                                <div class="p-4 rounded-2xl bg-surface border border-gray-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-accent/10 text-accent font-bold flex items-center justify-center shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-black text-sm text-primary">{{ $b->service->title ?? 'خدمة زيارة منزلية' }}</h4>
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700">
                                                    {{ $b->status ?? 'قيد المراجعة' }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500">رقم الحجز: <strong class="text-gray-800 font-bold dir-ltr">#{{ $b->booking_number }}</strong> • تاريخ الموعد: {{ $b->booking_date }} ({{ $b->booking_time }})</p>
                                            <p class="text-xs text-gray-500">موقع الزيارة: {{ $b->city }} - {{ $b->address }}</p>
                                        </div>
                                    </div>
                                    <div class="text-left font-black text-accent dir-ltr">
                                        {{ number_format($b->total_price, 2) }} ر.س
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 space-y-3">
                            <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center mx-auto border border-teal-100">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <h4 class="text-sm font-black text-primary">لا توجد زيارات منزلية محجوزة حالياً</h4>
                            <p class="text-xs text-gray-500 max-w-sm mx-auto">يمكنك طلب زيارة كشف طبيب عام، تمريض منزلي، أو تحليل مخبري فوراً.</p>
                            <a href="{{ route('services') }}" class="inline-block btn-accent px-6 py-2.5 rounded-xl text-xs font-bold shadow-md">
                                حجز زيارة منزلية جديدة
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- TAB 2: STORE ORDERS --}}
            <div x-show="activeTab === 'orders'" class="space-y-4">
                <div class="bg-white p-6 rounded-3xl shadow-soft border border-gray-100 space-y-4 text-right">
                    <h3 class="font-black text-lg text-primary">طلباتي وفواتير المتجر الطبي</h3>
                    
                    @if($orders->count() > 0)
                        <div class="space-y-3">
                            @foreach($orders as $o)
                                <div class="p-4 rounded-2xl bg-surface border border-gray-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary font-bold flex items-center justify-center shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                        </div>
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-black text-sm text-primary">طلب رقم: #{{ $o->order_number }}</h4>
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">
                                                    {{ $o->status ?? 'مؤكد' }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-gray-500">تاريخ الطلب: {{ $o->created_at->format('Y/m/d') }} • طريقة الدفع: {{ strtoupper($o->payment_method) }}</p>
                                            <p class="text-xs text-gray-500">المدينة والعنوان: {{ $o->city }} - {{ $o->shipping_address }}</p>
                                        </div>
                                    </div>
                                    <div class="text-left space-y-1">
                                        <div class="text-sm font-black text-accent dir-ltr">
                                            {{ number_format($o->total_price, 2) }} ر.س
                                        </div>
                                        <button onclick="window.print()" class="text-[11px] text-primary hover:text-accent font-bold transition-colors">
                                            تحميل الفاتورة PDF
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 space-y-3">
                            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto border border-blue-100">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                            <h4 class="text-sm font-black text-primary">لا توجد طلبات سابقة بالمتجر</h4>
                            <p class="text-xs text-gray-500 max-w-sm mx-auto">تصفح الأجهزة والمستلزمات الطبية المعتمدة بخصومات وتوصيل سريع.</p>
                            <a href="{{ route('products') }}" class="inline-block btn-accent px-6 py-2.5 rounded-xl text-xs font-bold shadow-md">
                                تصفح المتجر الطبي
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- TAB 3: SAVED ADDRESSES --}}
            <div x-show="activeTab === 'addresses'" class="space-y-4">
                <div class="bg-white p-6 rounded-3xl shadow-soft border border-gray-100 space-y-4 text-right">
                    <h3 class="font-black text-lg text-primary">العناوين والمواقع المحفوظة للزيارات</h3>
                    
                    @if($addresses->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($addresses as $addr)
                                <div class="p-4 rounded-2xl bg-surface border border-gray-100 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-bold text-xs text-primary">{{ $addr->title ?? 'عنوان المنزل' }}</h4>
                                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">افتراضي</span>
                                    </div>
                                    <p class="text-xs text-gray-600 leading-relaxed">{{ $addr->city }} - {{ $addr->address_line }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 space-y-3">
                            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto border border-amber-100">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <h4 class="text-sm font-black text-primary">لم تقم بإضافة عناوين منزليّة بعد</h4>
                            <p class="text-xs text-gray-500 max-w-sm mx-auto">يتم حفظ عنوانك تلقائياً عند إجراء أول حجز زيارة منزلية أو طلب شراء.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- TAB 4: EDIT PROFILE & PASSWORD --}}
            <div x-show="activeTab === 'info'" class="space-y-6">
                
                {{-- Edit Profile Form --}}
                <div class="bg-white p-6 rounded-3xl shadow-soft border border-gray-100 space-y-5 text-right">
                    <h3 class="font-black text-lg text-primary border-b border-gray-100 pb-3">تحديث البيانات الشخصية</h3>

                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-gray-700">الاسم الكامل *</label>
                                <input type="text" name="name" value="{{ Auth::check() ? Auth::user()->name : '' }}" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-medium focus:outline-none focus:border-primary">
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-gray-700">البريد الإلكتروني *</label>
                                <input type="email" name="email" value="{{ Auth::check() ? Auth::user()->email : '' }}" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-medium focus:outline-none focus:border-primary">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-bold text-gray-700">رقم الجوال للتواصل *</label>
                            <input type="text" name="phone" value="{{ Auth::check() ? Auth::user()->phone : '' }}" placeholder="05XXXXXXXX" dir="ltr" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary text-right">
                        </div>

                        <button type="submit" class="btn-accent px-6 py-2.5 rounded-xl font-bold text-xs shadow-md">
                            حفظ التعديلات
                        </button>
                    </form>
                </div>

                {{-- Edit Password Form --}}
                <div class="bg-white p-6 rounded-3xl shadow-soft border border-gray-100 space-y-5 text-right">
                    <h3 class="font-black text-lg text-primary border-b border-gray-100 pb-3">تغيير كلمة المرور</h3>

                    <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-gray-700">كلمة المرور الحالية *</label>
                                <input type="password" name="current_password" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-medium focus:outline-none focus:border-primary">
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-gray-700">كلمة المرور الجديدة *</label>
                                <input type="password" name="new_password" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-medium focus:outline-none focus:border-primary">
                            </div>

                            <div class="space-y-1.5">
                                <label class="block text-xs font-bold text-gray-700">تأكيد كلمة المرور الجديدة *</label>
                                <input type="password" name="new_password_confirmation" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-medium focus:outline-none focus:border-primary">
                            </div>
                        </div>

                        <button type="submit" class="btn-accent px-6 py-2.5 rounded-xl font-bold text-xs shadow-md">
                            تعديل كلمة السر
                        </button>
                    </form>
                </div>

            </div>

        </div>
    </section>

</x-app-layout>
