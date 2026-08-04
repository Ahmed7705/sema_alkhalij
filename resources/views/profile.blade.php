<x-app-layout title="لوحة العميل وحساب المريض | سيما الخليج للخدمات الطبية">

    {{-- Profile Hero Header --}}
    <section class="relative py-12 sm:py-16 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden dir-rtl text-right">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                
                {{-- User Avatar & Details --}}
                <div class="flex items-center gap-4 text-center sm:text-right">
                    <div class="relative">
                        <div class="w-20 h-20 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-accent font-black text-2xl flex items-center justify-center shadow-lg">
                            {{ mb_substr($user->name, 0, 2) }}
                        </div>
                        <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-accent text-white flex items-center justify-center text-[10px] font-bold border-2 border-primary" title="حساب موثق">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                    </div>
                    
                    <div class="space-y-1">
                        <div class="flex items-center justify-center sm:justify-start gap-2">
                            <h1 class="text-2xl font-black">{{ $user->name }}</h1>
                            <span class="px-2.5 py-0.5 rounded-full bg-accent/20 text-accent border border-accent/30 text-[10px] font-bold">
                                {{ __($user->role) }}
                            </span>
                        </div>
                        <p class="text-xs text-medical-200">البريد: {{ $user->email }} • الجوال: {{ $user->phone ?? 'غير مسجل' }}</p>
                        @if($user->identification_number)
                            <p class="text-[11px] text-medical-300">الهوية: {{ strtoupper($user->identification_type ?? 'saudi_id') }} - <span class="dir-ltr inline-block">{{ $user->identification_number }}</span></p>
                        @endif
                    </div>
                </div>

                {{-- Action Shortcuts --}}
                <div class="flex items-center gap-3">
                    @if(in_array($user->role, ['admin', 'super_admin', 'manager']))
                        <a href="{{ route('admin.dashboard') }}" class="py-2.5 px-5 rounded-xl bg-accent text-white font-black text-xs shadow-lg hover:bg-accent-hover transition-all flex items-center gap-1.5 border border-white/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>لوحة تحكم الأدمن</span>
                        </a>
                    @endif

                    <a href="{{ route('services') }}" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 rounded-xl text-xs font-bold transition-all text-white border border-white/10">
                        حجز خدمة منزلية جديدة
                    </a>
                    
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 rounded-xl text-xs font-bold transition-all text-white cursor-pointer border-0">
                            تسجيل الخروج
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    {{-- Flash Notifications --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 dir-rtl text-right">
            <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-800 font-bold text-xs border border-emerald-200 flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 dir-rtl text-right">
            <div class="p-4 rounded-2xl bg-rose-50 text-rose-800 font-bold text-xs border border-rose-200 space-y-1">
                <span class="block font-black">يرجى تصحيح الأخطاء التالية:</span>
                <ul class="list-disc list-inside text-[11px]">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Customer Portal Main Content --}}
    <section class="py-12 bg-surface dir-rtl text-right" x-data="{ activeTab: 'dashboard' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Portal Navigation Bar --}}
            <div class="bg-white p-2 rounded-2xl shadow-sm border border-gray-100 flex flex-wrap items-center gap-2">
                <button @click="activeTab = 'dashboard'" :class="activeTab === 'dashboard' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>نظرة عامة</span>
                </button>

                <button @click="activeTab = 'visits'" :class="activeTab === 'visits' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>حجوزاتي وزياراتي ({{ $bookings->count() }})</span>
                </button>
                
                <button @click="activeTab = 'orders'" :class="activeTab === 'orders' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span>طلبات الشراء ({{ $orders->count() }})</span>
                </button>

                <button @click="activeTab = 'reports'" :class="activeTab === 'reports' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>التقارير الطبية ({{ $medicalReports->count() }})</span>
                </button>

                <button @click="activeTab = 'samples'" :class="activeTab === 'samples' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 00-1.789 2.894l.447.894a2 2 0 001.789 1.106h11.906a2 2 0 001.789-1.106l.447-.894a2 2 0 00-.56-2.292z"/></svg>
                    <span>تتبع العينات ({{ $labSamples->count() }})</span>
                </button>

                <button @click="activeTab = 'addresses'" :class="activeTab === 'addresses' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>عناويني ({{ $addresses->count() }})</span>
                </button>

                <button @click="activeTab = 'wishlist'" :class="activeTab === 'wishlist' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <span>المفضلة ({{ $wishlistItems->count() }})</span>
                </button>

                <button @click="activeTab = 'info'" :class="activeTab === 'info' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>الملف الشخصي</span>
                </button>
            </div>

            {{-- TAB 1: OVERVIEW DASHBOARD --}}
            <div x-show="activeTab === 'dashboard'" class="space-y-8">
                
                {{-- Quick Stats Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                        <span class="text-xs font-bold text-gray-400">إجمالي الزيارات الطبية</span>
                        <div class="text-2xl font-black text-primary dir-ltr text-right">{{ $bookings->count() }} <span class="text-xs font-bold text-gray-400">زيارة</span></div>
                    </div>
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                        <span class="text-xs font-bold text-gray-400">طلبات المتجر والشراء</span>
                        <div class="text-2xl font-black text-primary dir-ltr text-right">{{ $orders->count() }} <span class="text-xs font-bold text-gray-400">طلب</span></div>
                    </div>
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                        <span class="text-xs font-bold text-gray-400">التقارير والنتائج الجاهزة</span>
                        <div class="text-2xl font-black text-emerald-600 dir-ltr text-right">{{ $medicalReports->count() }} <span class="text-xs font-bold text-gray-400">تقرير</span></div>
                    </div>
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                        <span class="text-xs font-bold text-gray-400">عناصر المفضلة</span>
                        <div class="text-2xl font-black text-accent dir-ltr text-right">{{ $wishlistItems->count() }} <span class="text-xs font-bold text-gray-400">عنصر</span></div>
                    </div>
                </div>

                {{-- Recent Activity Summaries --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    {{-- Latest Bookings --}}
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <h3 class="font-black text-sm text-primary">أحدث الزيارات الطبية المنزلية</h3>
                            <button @click="activeTab = 'visits'" class="text-xs font-bold text-accent hover:underline">عرض الكل</button>
                        </div>
                        @forelse($bookings->take(3) as $b)
                            <div class="p-4 rounded-2xl bg-surface border border-gray-100 flex items-center justify-between gap-4">
                                <div class="space-y-1">
                                    <span class="font-black text-xs text-primary block">{{ $b->service ? $b->service->title : 'خدمة منزلية' }}</span>
                                    <span class="text-[11px] text-gray-500 block">رقم الحجز: <strong class="text-gray-700 dir-ltr inline-block">#{{ $b->booking_number }}</strong> • {{ $b->booking_date }}</span>
                                </div>
                                <a href="{{ route('profile.booking-show', $b->id) }}" class="px-3 py-1.5 bg-primary/10 hover:bg-primary text-primary hover:text-white rounded-xl text-xs font-bold transition-all">التفاصيل</a>
                            </div>
                        @empty
                            <div class="text-center py-6 text-xs text-gray-400 font-bold">لا توجد زيارات حالياً</div>
                        @endforelse
                    </div>

                    {{-- Latest Orders --}}
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <h3 class="font-black text-sm text-primary">أحدث طلبات المتجر الطبي</h3>
                            <button @click="activeTab = 'orders'" class="text-xs font-bold text-accent hover:underline">عرض الكل</button>
                        </div>
                        @forelse($orders->take(3) as $o)
                            <div class="p-4 rounded-2xl bg-surface border border-gray-100 flex items-center justify-between gap-4">
                                <div class="space-y-1">
                                    <span class="font-black text-xs text-primary block">طلب رقم: #{{ $o->order_number }}</span>
                                    <span class="text-[11px] text-gray-500 block">{{ $o->created_at->format('Y-m-d') }} • {{ number_format($o->total_amount, 2) }} ر.س</span>
                                </div>
                                <a href="{{ route('profile.order-show', $o->id) }}" class="px-3 py-1.5 bg-accent/10 hover:bg-accent text-accent hover:text-white rounded-xl text-xs font-bold transition-all">التفاصيل</a>
                            </div>
                        @empty
                            <div class="text-center py-6 text-xs text-gray-400 font-bold">لا توجد طلبات متجر حالياً</div>
                        @endforelse
                    </div>

                </div>
            </div>

            {{-- TAB 2: VISITS & BOOKINGS --}}
            <div x-show="activeTab === 'visits'" class="space-y-4">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-lg text-primary">حجوزاتي وزياراتي الطبية المنزلية</h3>
                    
                    @forelse($bookings as $b)
                        <div class="p-5 rounded-2xl bg-surface border border-gray-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="space-y-1.5">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-black text-sm text-primary">{{ $b->service ? $b->service->title : 'خدمة زيارة منزلية' }}</h4>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                        {{ __($b->status) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500">رقم الحجز: <strong class="text-gray-800 dir-ltr inline-block">#{{ $b->booking_number }}</strong> • التاريخ: {{ $b->booking_date }} ({{ $b->booking_time }})</p>
                                <p class="text-xs text-gray-500">الموقع: {{ $b->city }} - {{ $b->address }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="font-black text-accent text-sm dir-ltr">{{ number_format($b->total_price, 2) }} ر.س</span>
                                <a href="{{ route('profile.booking-show', $b->id) }}" class="px-4 py-2 bg-primary hover:bg-primary-hover text-white rounded-xl text-xs font-bold transition-all shadow-sm">عرض التفاصيل والمسار</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 space-y-3">
                            <h4 class="text-sm font-black text-primary">لا توجد زيارات محجوزة</h4>
                            <a href="{{ route('services') }}" class="inline-block px-6 py-3 bg-accent text-white rounded-2xl text-xs font-bold shadow-lg">حجز زيارة الآن</a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- TAB 3: STORE ORDERS --}}
            <div x-show="activeTab === 'orders'" class="space-y-4">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-lg text-primary">طلباتي من المتجر الطبي والفوترة</h3>
                    
                    @forelse($orders as $o)
                        <div class="p-5 rounded-2xl bg-surface border border-gray-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="space-y-1.5">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-black text-sm text-primary">طلب رقم: #{{ $o->order_number }}</h4>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        {{ __($o->status) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500">التاريخ: {{ $o->created_at->format('Y-m-d H:i') }} • طريقة الدفع: {{ $o->payment_method ?? 'بطاقة' }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="font-black text-accent text-sm dir-ltr">{{ number_format($o->total_amount, 2) }} ر.س</span>
                                <a href="{{ route('profile.order-show', $o->id) }}" class="px-4 py-2 bg-accent hover:bg-accent-hover text-white rounded-xl text-xs font-bold transition-all shadow-sm">عرض الفاتورة والتفاصيل</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 space-y-3">
                            <h4 class="text-sm font-black text-primary">لا توجد طلبات شراء بالمتجر</h4>
                            <a href="{{ route('products') }}" class="inline-block px-6 py-3 bg-accent text-white rounded-2xl text-xs font-bold shadow-lg">تصفح المتجر الطبي</a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- TAB 4: MEDICAL REPORTS --}}
            <div x-show="activeTab === 'reports'" class="space-y-4">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-lg text-primary">نتائج الفحوصات والتقارير الطبية المحمية</h3>
                    
                    @forelse($medicalReports as $report)
                        <div class="p-5 rounded-2xl bg-emerald-50/50 border border-emerald-100 flex items-center justify-between gap-4">
                            <div class="space-y-1">
                                <span class="font-black text-sm text-primary block">{{ $report->file_name }}</span>
                                <span class="text-xs text-gray-500 block">كود الزيارة: <strong class="text-accent dir-ltr inline-block">{{ $report->visit_code ?? 'عام' }}</strong> • تاريخ الرفع: {{ $report->uploaded_at ?? $report->created_at->format('Y-m-d') }}</span>
                            </div>
                            <a href="{{ route('medical-reports.download', $report->id) }}" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-black text-xs shadow-md transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                <span>تحميل التقرير PDF</span>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-12 space-y-2">
                            <h4 class="text-sm font-black text-primary">لا توجد تقارير طبية جاهزة حالياً</h4>
                            <p class="text-xs text-gray-400">ستظهر نتائج التحاليل والتقارير الطبية هنا فور اعتمادها من الكادر الطبي المختص.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- TAB 5: LAB SAMPLES TRACKING --}}
            <div x-show="activeTab === 'samples'" class="space-y-4">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-lg text-primary">تتبع العينات الفحوصات المخبرية</h3>
                    
                    @forelse($labSamples as $sample)
                        <div class="p-6 rounded-2xl bg-surface border border-gray-100 space-y-4">
                            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                                <div>
                                    <span class="font-bold text-xs text-gray-500">كود الزيارة والعينة:</span>
                                    <span class="font-black text-sm text-accent dir-ltr inline-block mr-2">{{ $sample->visit_code }}</span>
                                </div>
                                <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-800 text-xs font-bold border border-blue-200">
                                    حالة العينة الحالية: {{ __($sample->sample_status) }}
                                </span>
                            </div>

                            {{-- Visual Tracking Workflow --}}
                            @php
                                $sampleSteps = [
                                    'registered' => 'تسجيل العينة',
                                    'assigned' => 'إسناد الفني',
                                    'sample_collected' => 'تم سحب العينة',
                                    'sent_to_lab' => 'إرسال للمختبر',
                                    'received_by_lab' => 'استلام المختبر',
                                    'processing' => 'جاري الفحص',
                                    'result_ready' => 'النتيجة جاهزة'
                                ];
                                $sampleLevels = ['registered' => 1, 'assigned' => 2, 'sample_collected' => 3, 'sent_to_lab' => 4, 'received_by_lab' => 5, 'processing' => 6, 'result_ready' => 7];
                                $currSampleLevel = $sampleLevels[$sample->sample_status] ?? 1;
                            @endphp

                            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-2 text-center pt-2">
                                @foreach($sampleSteps as $sKey => $sLabel)
                                    @php $sLvl = $sampleLevels[$sKey]; @endphp
                                    <div class="p-2.5 rounded-xl border text-[11px] font-bold space-y-1
                                        @if($sLvl <= $currSampleLevel) bg-blue-50 border-blue-300 text-blue-900 @else bg-gray-50 border-gray-200 text-gray-400 opacity-50 @endif">
                                        <span class="block">{{ $sLabel }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-xs text-gray-400 font-bold">لا توجد عينات مخبرية مسجلة لحسابك حالياً</div>
                    @endforelse
                </div>
            </div>

            {{-- TAB 6: SAVED ADDRESSES --}}
            <div x-show="activeTab === 'addresses'" class="space-y-6">
                
                {{-- Address Form --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-lg text-primary border-b border-gray-100 pb-3">إضافة عنوان زيارة منزلي جديد</h3>
                    <form action="{{ route('addresses.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">اسم العنوان (المنزل/العمل) *</label>
                                <input type="text" name="label" required placeholder="مثال: المنزل الرئيسي" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">المدينة *</label>
                                <input type="text" name="city" required value="الرياض" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">الحي</label>
                                <input type="text" name="district" placeholder="اسم الحي" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">الشارع</label>
                                <input type="text" name="street" placeholder="اسم الشارع" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">رقم المبنى / الشقة</label>
                                <input type="text" name="building_no" placeholder="رقم المبنى" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">تفاصيل وملاحظات إضافية</label>
                                <input type="text" name="additional_info" placeholder="بجوار..." class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_default" value="1" id="is_default" class="rounded text-primary">
                            <label for="is_default" class="text-xs font-bold text-gray-700">تعيين كعنوان افتراضي للزيارات والطلب</label>
                        </div>

                        <button type="submit" class="px-8 py-3 bg-primary hover:bg-primary-hover text-white rounded-2xl font-black text-xs shadow-md">حفظ العنوان الجديد</button>
                    </form>
                </div>

                {{-- Addresses List --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-lg text-primary border-b border-gray-100 pb-3">قائمة العناوين المحفوظة</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($addresses as $addr)
                            <div class="p-5 rounded-2xl bg-surface border border-gray-100 space-y-3">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-black text-sm text-primary">{{ $addr->label }}</h4>
                                    @if($addr->is_default)
                                        <span class="px-2.5 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold">افتراضي</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-600 leading-relaxed">{{ $addr->city }} - {{ $addr->district }} - {{ $addr->street }} {{ $addr->building_no ? 'مبنى ' . $addr->building_no : '' }}</p>
                                <p class="text-[11px] text-gray-400">{{ $addr->additional_info }}</p>

                                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                    @if(!$addr->is_default)
                                        <form action="{{ route('addresses.set-default', $addr->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-[11px] text-primary font-bold hover:underline">جعله افتراضي</button>
                                        </form>
                                    @else
                                        <div></div>
                                    @endif

                                    <form action="{{ route('addresses.destroy', $addr->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[11px] text-rose-600 font-bold hover:underline">حذف العنوان</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-xs text-gray-400 font-bold col-span-2">لا توجد عناوين محفوظة حالياً</div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- TAB 7: WISHLIST --}}
            <div x-show="activeTab === 'wishlist'" class="space-y-4">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-lg text-primary">المنتجات المحفوظة في المفضلة</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @forelse($wishlistItems as $wItem)
                            <div class="p-4 rounded-2xl bg-surface border border-gray-100 space-y-3 text-center">
                                <h4 class="font-black text-xs text-primary">{{ $wItem->product ? $wItem->product->name : 'منتج طبي' }}</h4>
                                <span class="font-black text-accent text-xs dir-ltr block">{{ number_format($wItem->product ? $wItem->product->price : 0, 2) }} ر.س</span>
                                <a href="{{ route('products') }}" class="block px-4 py-2 bg-primary text-white rounded-xl text-xs font-bold">عرض بالمتجر</a>
                            </div>
                        @empty
                            <div class="text-center py-12 text-xs text-gray-400 font-bold col-span-3">لا توجد منتجات بالمفضلة حالياً</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- TAB 8: EDIT PROFILE & PASSWORD --}}
            <div x-show="activeTab === 'info'" class="space-y-6">
                
                {{-- Profile Info Form --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-5">
                    <h3 class="font-black text-lg text-primary border-b border-gray-100 pb-3">تحديث البيانات الشخصية الهوية</h3>

                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">الاسم الكامل *</label>
                                <input type="text" name="name" value="{{ $user->name }}" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">البريد الإلكتروني *</label>
                                <input type="email" name="email" value="{{ $user->email }}" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">رقم الجوال للتواصل *</label>
                                <input type="text" name="phone" value="{{ $user->phone }}" placeholder="05XXXXXXXX" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold dir-ltr text-right">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">نوع الهوية للمريض</label>
                                <select name="identification_type" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                                    <option value="saudi_id" {{ $user->identification_type === 'saudi_id' ? 'selected' : '' }}>هوية وطنية سعودية</option>
                                    <option value="iqama" {{ $user->identification_type === 'iqama' ? 'selected' : '' }}>إقامة مقيم</option>
                                    <option value="border_no" {{ $user->identification_type === 'border_no' ? 'selected' : '' }}>رقم حدود</option>
                                    <option value="gcc_id" {{ $user->identification_type === 'gcc_id' ? 'selected' : '' }}>هوية مواطن خليجي</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-gray-700 mb-1">رقم الهوية الوطنية / الإقامة</label>
                                <input type="text" name="identification_number" value="{{ $user->identification_number }}" placeholder="10XXXXXXXX" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold dir-ltr text-right">
                            </div>
                        </div>

                        <button type="submit" class="px-8 py-3 bg-primary hover:bg-primary-hover text-white rounded-2xl font-black text-xs shadow-md">حفظ التعديلات</button>
                    </form>
                </div>

                {{-- Password Form --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-5">
                    <h3 class="font-black text-lg text-primary border-b border-gray-100 pb-3">تغيير كلمة المرور</h3>

                    <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">كلمة المرور الحالية *</label>
                                <input type="password" name="current_password" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">كلمة المرور الجديدة *</label>
                                <input type="password" name="new_password" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">تأكيد كلمة المرور الجديدة *</label>
                                <input type="password" name="new_password_confirmation" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>
                        </div>

                        <button type="submit" class="px-8 py-3 bg-accent hover:bg-accent-hover text-white rounded-2xl font-black text-xs shadow-md">تحديث كلمة السر</button>
                    </form>
                </div>

            </div>

        </div>
    </section>

</x-app-layout>
