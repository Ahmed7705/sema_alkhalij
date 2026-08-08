<x-app-layout :title="app()->getLocale()=='en' ? 'Customer Portal & Patient Profile | Sema Al-Khalij Medical Services' : 'لوحة العميل وحساب المريض | سيما الخليج للخدمات الطبية'">

    @php
        $isEn = app()->getLocale() == 'en';
        
        $roleMap = [
            'admin' => $isEn ? 'Executive Admin' : 'مدير النظام التنفيذي',
            'super_admin' => $isEn ? 'Executive Admin' : 'مدير النظام التنفيذي',
            'manager' => $isEn ? 'Medical Manager' : 'مدير طبي',
            'doctor' => $isEn ? 'Physician / Doctor' : 'طبيب استشاري',
            'nurse' => $isEn ? 'Medical Nurse' : 'تمريض طبي',
            'lab_tech' => $isEn ? 'Lab Technician' : 'فني مختبر',
            'company_user' => $isEn ? 'Company Representative' : 'ممثل شركة',
            'customer' => $isEn ? 'Verified Patient Account' : 'حساب مريض موثق',
        ];
        $displayRole = $roleMap[$user->role] ?? __($user->role);
    @endphp

    {{-- Profile Hero Header --}}
    <section class="relative py-12 sm:py-16 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden {{ $isEn ? 'text-left' : 'text-right' }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                
                {{-- User Avatar & Details --}}
                <div class="flex items-center gap-4 text-center sm:{{ $isEn ? 'text-left' : 'text-right' }}">
                    <div class="relative">
                        <div class="w-20 h-20 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-accent font-black text-2xl flex items-center justify-center shadow-lg">
                            {{ mb_substr($user->name, 0, 2) }}
                        </div>
                        <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-accent text-white flex items-center justify-center text-[10px] font-bold border-2 border-primary" title="{{ $isEn ? 'Verified Account' : 'حساب موثق' }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                    </div>
                    
                    <div class="space-y-1">
                        <div class="flex items-center justify-center sm:justify-start gap-2">
                            <h1 class="text-2xl font-black">{{ $user->name }}</h1>
                            <span class="px-2.5 py-0.5 rounded-full bg-accent/20 text-accent border border-accent/30 text-[10px] font-bold">
                                {{ $displayRole }}
                            </span>
                        </div>
                        <p class="text-xs text-medical-200">{{ $isEn ? 'Email:' : 'البريد:' }} {{ $user->email }} • {{ $isEn ? 'Mobile:' : 'الجوال:' }} {{ $user->phone ?? ($isEn ? 'Not registered' : 'غير مسجل') }}</p>
                        @if($user->identification_number)
                            <p class="text-[11px] text-medical-300">{{ $isEn ? 'ID:' : 'الهوية:' }} {{ strtoupper($user->identification_type ?? 'saudi_id') }} - <span class="dir-ltr inline-block">{{ $user->identification_number }}</span></p>
                        @endif
                    </div>
                </div>

                {{-- Action Shortcuts --}}
                <div class="flex items-center gap-3">
                    @if(in_array($user->role, ['admin', 'super_admin', 'manager']))
                        <a href="{{ route('admin.dashboard') }}" class="py-2.5 px-5 rounded-xl bg-accent text-white font-black text-xs shadow-lg hover:bg-accent-hover transition-all flex items-center gap-1.5 border border-white/20">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>{{ $isEn ? 'Admin Dashboard' : 'لوحة تحكم الأدمن' }}</span>
                        </a>
                    @endif

                    <a href="{{ route('services') }}" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 rounded-xl text-xs font-bold transition-all text-white border border-white/10">
                        {{ $isEn ? 'Book New Home Visit' : 'حجز خدمة منزلية جديدة' }}
                    </a>
                    
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 rounded-xl text-xs font-bold transition-all text-white cursor-pointer border-0">
                            {{ $isEn ? 'Sign Out' : 'تسجيل الخروج' }}
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    {{-- Flash Notifications --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 {{ $isEn ? 'text-left' : 'text-right' }}">
            <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-800 font-bold text-xs border border-emerald-200 flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 {{ $isEn ? 'text-left' : 'text-right' }}">
            <div class="p-4 rounded-2xl bg-rose-50 text-rose-800 font-bold text-xs border border-rose-200 space-y-1">
                <span class="block font-black">{{ $isEn ? 'Please fix the following errors:' : 'يرجى تصحيح الأخطاء التالية:' }}</span>
                <ul class="list-disc list-inside text-[11px]">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- Customer Portal Main Content --}}
    <section class="py-12 bg-surface {{ $isEn ? 'text-left' : 'text-right' }}" x-data="{ activeTab: 'dashboard' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Portal Navigation Bar --}}
            <div class="bg-white p-2 rounded-2xl shadow-sm border border-gray-100 flex flex-wrap items-center gap-2">
                <button @click="activeTab = 'dashboard'" :class="activeTab === 'dashboard' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>{{ $isEn ? 'Overview' : 'نظرة عامة' }}</span>
                </button>

                <button @click="activeTab = 'visits'" :class="activeTab === 'visits' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ $isEn ? 'My Visits (' . $bookings->count() . ')' : 'حجوزاتي وزياراتي (' . $bookings->count() . ')' }}</span>
                </button>
                
                <button @click="activeTab = 'orders'" :class="activeTab === 'orders' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span>{{ $isEn ? 'Store Orders (' . $orders->count() . ')' : 'طلبات الشراء (' . $orders->count() . ')' }}</span>
                </button>

                <button @click="activeTab = 'reports'" :class="activeTab === 'reports' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>{{ $isEn ? 'Medical Reports (' . $medicalReports->count() . ')' : 'التقارير الطبية (' . $medicalReports->count() . ')' }}</span>
                </button>

                <button @click="activeTab = 'samples'" :class="activeTab === 'samples' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 00-1.789 2.894l.447.894a2 2 0 001.789 1.106h11.906a2 2 0 001.789-1.106l.447-.894a2 2 0 00-.56-2.292z"/></svg>
                    <span>{{ $isEn ? 'Lab Samples (' . $labSamples->count() . ')' : 'تتبع العينات (' . $labSamples->count() . ')' }}</span>
                </button>

                <button @click="activeTab = 'addresses'" :class="activeTab === 'addresses' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>{{ $isEn ? 'My Addresses (' . $addresses->count() . ')' : 'عناويني (' . $addresses->count() . ')' }}</span>
                </button>

                <button @click="activeTab = 'wishlist'" :class="activeTab === 'wishlist' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <span>{{ $isEn ? 'Wishlist (' . $wishlistItems->count() . ')' : 'المفضلة (' . $wishlistItems->count() . ')' }}</span>
                </button>

                <button @click="activeTab = 'billing'" :class="activeTab === 'billing' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>{{ $isEn ? 'Invoices & Payments (' . $userInvoices->count() . ')' : 'الفواتير والمدفوعات (' . $userInvoices->count() . ')' }}</span>
                </button>


                <button @click="activeTab = 'info'" :class="activeTab === 'info' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>{{ $isEn ? 'Profile Settings' : 'الملف الشخصي' }}</span>
                </button>
            </div>

            {{-- TAB 1: OVERVIEW DASHBOARD --}}
            <div x-show="activeTab === 'dashboard'" class="space-y-8">
                
                {{-- Quick Stats Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                        <span class="text-xs font-bold text-gray-400">{{ $isEn ? 'Total Medical Visits' : 'إجمالي الزيارات الطبية' }}</span>
                        <div class="text-2xl font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $bookings->count() }} <span class="text-xs font-bold text-gray-400">{{ $isEn ? 'visits' : 'زيارة' }}</span></div>
                    </div>
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                        <span class="text-xs font-bold text-gray-400">{{ $isEn ? 'Store Orders & Purchases' : 'طلبات المتجر والشراء' }}</span>
                        <div class="text-2xl font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $orders->count() }} <span class="text-xs font-bold text-gray-400">{{ $isEn ? 'orders' : 'طلب' }}</span></div>
                    </div>
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                        <span class="text-xs font-bold text-gray-400">{{ $isEn ? 'Ready Medical Reports' : 'التقارير والنتائج الجاهزة' }}</span>
                        <div class="text-2xl font-black text-emerald-600 dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $medicalReports->count() }} <span class="text-xs font-bold text-gray-400">{{ $isEn ? 'reports' : 'تقرير' }}</span></div>
                    </div>
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-2">
                        <span class="text-xs font-bold text-gray-400">{{ $isEn ? 'Wishlist Items' : 'عناصر المفضلة' }}</span>
                        <div class="text-2xl font-black text-accent dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ $wishlistItems->count() }} <span class="text-xs font-bold text-gray-400">{{ $isEn ? 'items' : 'عنصر' }}</span></div>
                    </div>
                </div>

                {{-- Recent Activity Summaries --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    {{-- Latest Bookings --}}
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Latest Home Medical Visits' : 'أحدث الزيارات الطبية المنزلية' }}</h3>
                            <button @click="activeTab = 'visits'" class="text-xs font-bold text-accent hover:underline">{{ $isEn ? 'View All' : 'عرض الكل' }}</button>
                        </div>
                        @forelse($bookings->take(3) as $b)
                            <div class="p-4 rounded-2xl bg-surface border border-gray-100 flex items-center justify-between gap-4">
                                <div class="space-y-1">
                                    <span class="font-black text-xs text-primary block">{{ $b->service ? $b->service->title : ($isEn ? 'Home Visit Service' : 'خدمة منزلية') }}</span>
                                    <span class="text-[11px] text-gray-500 block">{{ $isEn ? 'Booking No:' : 'رقم الحجز:' }} <strong class="text-gray-700 dir-ltr inline-block">#{{ $b->booking_number }}</strong> • {{ $b->booking_date }}</span>
                                </div>
                                <a href="{{ route('profile.booking-show', $b->id) }}" class="px-3 py-1.5 bg-primary/10 hover:bg-primary text-primary hover:text-white rounded-xl text-xs font-bold transition-all">{{ $isEn ? 'Details' : 'التفاصيل' }}</a>
                            </div>
                        @empty
                            <div class="text-center py-6 text-xs text-gray-400 font-bold">{{ $isEn ? 'No visits currently' : 'لا توجد زيارات حالياً' }}</div>
                        @endforelse
                    </div>

                    {{-- Latest Orders --}}
                    <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Latest Store Orders' : 'أحدث طلبات المتجر الطبي' }}</h3>
                            <button @click="activeTab = 'orders'" class="text-xs font-bold text-accent hover:underline">{{ $isEn ? 'View All' : 'عرض الكل' }}</button>
                        </div>
                        @forelse($orders->take(3) as $o)
                            <div class="p-4 rounded-2xl bg-surface border border-gray-100 flex items-center justify-between gap-4">
                                <div class="space-y-1">
                                    <span class="font-black text-xs text-primary block">{{ $isEn ? 'Order No:' : 'طلب رقم:' }} #{{ $o->order_number }}</span>
                                    <span class="text-[11px] text-gray-500 block">{{ $o->created_at->format('Y-m-d') }} • {{ number_format($o->total_amount, 2) }} {{ __('products.sar') }}</span>
                                </div>
                                <a href="{{ route('profile.order-show', $o->id) }}" class="px-3 py-1.5 bg-accent/10 hover:bg-accent text-accent hover:text-white rounded-xl text-xs font-bold transition-all">{{ $isEn ? 'Details' : 'التفاصيل' }}</a>
                            </div>
                        @empty
                            <div class="text-center py-6 text-xs text-gray-400 font-bold">{{ $isEn ? 'No store orders currently' : 'لا توجد طلبات متجر حالياً' }}</div>
                        @endforelse
                    </div>

                </div>
            </div>

            {{-- TAB 2: VISITS & BOOKINGS --}}
            <div x-show="activeTab === 'visits'" class="space-y-4">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-lg text-primary">{{ $isEn ? 'My Home Medical Bookings & Visits' : 'حجوزاتي وزياراتي الطبية المنزلية' }}</h3>
                    
                    @forelse($bookings as $b)
                        <div class="p-5 rounded-2xl bg-surface border border-gray-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="space-y-1.5">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-black text-sm text-primary">{{ $b->service ? $b->service->title : ($isEn ? 'Home Medical Visit' : 'خدمة زيارة منزلية') }}</h4>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                        {{ __($b->status) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500">{{ $isEn ? 'Booking No:' : 'رقم الحجز:' }} <strong class="text-gray-800 dir-ltr inline-block">#{{ $b->booking_number }}</strong> • {{ $isEn ? 'Date:' : 'التاريخ:' }} {{ $b->booking_date }} ({{ $b->booking_time }})</p>
                                <p class="text-xs text-gray-500">{{ $isEn ? 'Location:' : 'الموقع:' }} {{ $b->city }} - {{ $b->address }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="font-black text-accent text-sm dir-ltr">{{ number_format($b->total_price, 2) }} {{ __('products.sar') }}</span>
                                <a href="{{ route('profile.booking-show', $b->id) }}" class="px-4 py-2 bg-primary hover:bg-primary-hover text-white rounded-xl text-xs font-bold transition-all shadow-sm">{{ $isEn ? 'View Details & Track' : 'عرض التفاصيل والمسار' }}</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 space-y-3">
                            <h4 class="text-sm font-black text-primary">{{ $isEn ? 'No booked visits found' : 'لا توجد زيارات محجوزة' }}</h4>
                            <a href="{{ route('services') }}" class="inline-block px-6 py-3 bg-accent text-white rounded-2xl text-xs font-bold shadow-lg">{{ $isEn ? 'Book Visit Now' : 'حجز زيارة الآن' }}</a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- TAB 3: STORE ORDERS --}}
            <div x-show="activeTab === 'orders'" class="space-y-4">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-lg text-primary">{{ $isEn ? 'My Store Orders & Invoices' : 'طلباتي من المتجر الطبي والفوترة' }}</h3>
                    
                    @forelse($orders as $o)
                        <div class="p-5 rounded-2xl bg-surface border border-gray-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="space-y-1.5">
                                <div class="flex items-center gap-2">
                                    <h4 class="font-black text-sm text-primary">{{ $isEn ? 'Order No:' : 'طلب رقم:' }} #{{ $o->order_number }}</h4>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        {{ __($o->status) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500">{{ $isEn ? 'Date:' : 'التاريخ:' }} {{ $o->created_at->format('Y-m-d H:i') }} • {{ $isEn ? 'Payment:' : 'طريقة الدفع:' }} {{ $o->payment_method ?? ($isEn ? 'Card' : 'بطاقة') }}</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="font-black text-accent text-sm dir-ltr">{{ number_format($o->total_amount, 2) }} {{ __('products.sar') }}</span>
                                <a href="{{ route('profile.order-show', $o->id) }}" class="px-4 py-2 bg-accent hover:bg-accent-hover text-white rounded-xl text-xs font-bold transition-all shadow-sm">{{ $isEn ? 'View Invoice & Details' : 'عرض الفاتورة والتفاصيل' }}</a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 space-y-3">
                            <h4 class="text-sm font-black text-primary">{{ $isEn ? 'No store orders found' : 'لا توجد طلبات شراء بالمتجر' }}</h4>
                            <a href="{{ route('products') }}" class="inline-block px-6 py-3 bg-accent text-white rounded-2xl text-xs font-bold shadow-lg">{{ $isEn ? 'Browse Medical Store' : 'تصفح المتجر الطبي' }}</a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- TAB 4: MEDICAL REPORTS --}}
            <div x-show="activeTab === 'reports'" class="space-y-4">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-lg text-primary">{{ $isEn ? 'Protected Medical Reports & Lab Results' : 'نتائج الفحوصات والتقارير الطبية المحمية' }}</h3>
                    
                    @forelse($medicalReports as $report)
                        <div class="p-5 rounded-2xl bg-emerald-50/50 border border-emerald-100 flex items-center justify-between gap-4">
                            <div class="space-y-1">
                                <span class="font-black text-sm text-primary block">{{ $report->file_name }}</span>
                                <span class="text-xs text-gray-500 block">{{ $isEn ? 'Visit Code:' : 'كود الزيارة:' }} <strong class="text-accent dir-ltr inline-block">{{ $report->visit_code ?? ($isEn ? 'General' : 'عام') }}</strong> • {{ $isEn ? 'Upload Date:' : 'تاريخ الرفع:' }} {{ $report->uploaded_at ?? $report->created_at->format('Y-m-d') }}</span>
                            </div>
                            <a href="{{ route('medical-reports.download', $report->id) }}" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-black text-xs shadow-md transition-all flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                <span>{{ $isEn ? 'Download PDF Report' : 'تحميل التقرير PDF' }}</span>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-12 space-y-2">
                            <h4 class="text-sm font-black text-primary">{{ $isEn ? 'No medical reports available currently' : 'لا توجد تقارير طبية جاهزة حالياً' }}</h4>
                            <p class="text-xs text-gray-400">{{ $isEn ? 'Test results and medical reports will appear here once approved by our medical team.' : 'ستظهر نتائج التحاليل والتقارير الطبية هنا فور اعتمادها من الكادر الطبي المختص.' }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- TAB 5: LAB SAMPLES TRACKING --}}
            <div x-show="activeTab === 'samples'" class="space-y-4">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-lg text-primary">{{ $isEn ? 'Lab Samples Real-time Tracking' : 'تتبع العينات والفحوصات المخبرية (9 مراحل)' }}</h3>
                    
                    @forelse($labSamples as $sample)
                        <div class="p-6 rounded-2xl bg-surface border border-gray-100 space-y-4">
                            <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-gray-100 pb-3 gap-2">
                                <div>
                                    <span class="font-bold text-xs text-gray-500">{{ $isEn ? 'Visit & Sample Code:' : 'كود الزيارة والعينة:' }}</span>
                                    <span class="font-black text-sm text-accent dir-ltr inline-block {{ $isEn ? 'ml-2' : 'mr-2' }}">{{ $sample->visit_code }}</span>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-800 text-xs font-bold border border-blue-200">
                                        {{ $isEn ? 'Current Status:' : 'حالة العينة:' }} {{ $sample->sample_status }}
                                    </span>

                                    @if($sample->medicalReport && in_array($sample->sample_status, ['result_ready', 'report_uploaded', 'delivered']))
                                        <a href="{{ route('medical-reports.download', $sample->medicalReport->id) }}" target="_blank" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold text-xs shadow-sm transition-all flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                            <span>{{ $isEn ? 'Download PDF Report' : 'تحميل النتيجة PDF' }}</span>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            {{-- Visual Tracking Workflow (9 Stages) --}}
                            @php
                                $sampleSteps = $isEn ? [
                                    'registered' => '1. Registered',
                                    'assigned' => '2. Assigned',
                                    'sample_collected' => '3. Collected',
                                    'sent_to_lab' => '4. Sent to Lab',
                                    'received_by_lab' => '5. Received',
                                    'processing' => '6. Processing',
                                    'result_ready' => '7. Result Ready',
                                    'report_uploaded' => '8. Uploaded',
                                    'delivered' => '9. Delivered'
                                ] : [
                                    'registered' => '1. تسجيل العينة',
                                    'assigned' => '2. إسناد الفني',
                                    'sample_collected' => '3. تم سحب العينة',
                                    'sent_to_lab' => '4. إرسال للمختبر',
                                    'received_by_lab' => '5. استلام المختبر',
                                    'processing' => '6. جاري الفحص',
                                    'result_ready' => '7. النتيجة جاهزة',
                                    'report_uploaded' => '8. تم الرفع',
                                    'delivered' => '9. تم التسليم'
                                ];
                                $sampleLevels = [
                                    'registered' => 1, 'assigned' => 2, 'sample_collected' => 3, 
                                    'sent_to_lab' => 4, 'received_by_lab' => 5, 'processing' => 6, 
                                    'result_ready' => 7, 'report_uploaded' => 8, 'delivered' => 9
                                ];
                                $currSampleLevel = $sampleLevels[$sample->sample_status] ?? 1;
                            @endphp

                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-9 gap-1.5 text-center pt-2">
                                @foreach($sampleSteps as $sKey => $sLabel)
                                    @php $sLvl = $sampleLevels[$sKey]; @endphp
                                    <div class="p-2 rounded-xl border text-[10px] font-bold space-y-1
                                        @if($sLvl <= $currSampleLevel) bg-emerald-50 border-emerald-300 text-emerald-900 @else bg-gray-50 border-gray-200 text-gray-400 opacity-50 @endif">
                                        <span class="block leading-tight">{{ $sLabel }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-xs text-gray-400 font-bold">{{ $isEn ? 'No registered lab samples currently' : 'لا توجد عينات مخبرية مسجلة لحسابك حالياً' }}</div>
                    @endforelse
                </div>
            </div>


            {{-- TAB 6: SAVED ADDRESSES --}}
            <div x-show="activeTab === 'addresses'" class="space-y-6">
                
                {{-- Address Form --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-lg text-primary border-b border-gray-100 pb-3">{{ $isEn ? 'Add New Home Visit Address' : 'إضافة عنوان زيارة منزلي جديد' }}</h3>
                    <form action="{{ route('addresses.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Address Label (Home/Work) *' : 'اسم العنوان (المنزل/العمل) *' }}</label>
                                <input type="text" name="label" required placeholder="{{ $isEn ? 'e.g. Main Residence' : 'مثال: المنزل الرئيسي' }}" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'City *' : 'المدينة *' }}</label>
                                <input type="text" name="city" required value="{{ $isEn ? 'Riyadh' : 'الرياض' }}" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'District' : 'الحي' }}</label>
                                <input type="text" name="district" placeholder="{{ $isEn ? 'District name' : 'اسم الحي' }}" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Street' : 'الشارع' }}</label>
                                <input type="text" name="street" placeholder="{{ $isEn ? 'Street name' : 'اسم الشارع' }}" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Building / Apt No' : 'رقم المبنى / الشقة' }}</label>
                                <input type="text" name="building_no" placeholder="{{ $isEn ? 'Building number' : 'رقم المبنى' }}" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">{{ $isEn ? 'Additional Details' : 'تفاصيل وملاحظات إضافية' }}</label>
                                <input type="text" name="additional_info" placeholder="{{ $isEn ? 'Near landmark...' : 'بجوار...' }}" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="is_default" value="1" id="is_default" class="rounded text-primary">
                            <label for="is_default" class="text-xs font-bold text-gray-700">{{ $isEn ? 'Set as default address for bookings & orders' : 'تعيين كعنوان افتراضي للزيارات والطلب' }}</label>
                        </div>

                        <button type="submit" class="px-8 py-3 bg-primary hover:bg-primary-hover text-white rounded-2xl font-black text-xs shadow-md">{{ $isEn ? 'Save New Address' : 'حفظ العنوان الجديد' }}</button>
                    </form>
                </div>

                {{-- Addresses List --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-lg text-primary border-b border-gray-100 pb-3">{{ $isEn ? 'Saved Addresses List' : 'قائمة العناوين المحفوظة' }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($addresses as $addr)
                            <div class="p-5 rounded-2xl bg-surface border border-gray-100 space-y-3">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-black text-sm text-primary">{{ $addr->label }}</h4>
                                    @if($addr->is_default)
                                        <span class="px-2.5 py-0.5 rounded bg-emerald-100 text-emerald-800 text-[10px] font-bold">{{ $isEn ? 'Default' : 'افتراضي' }}</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-600 leading-relaxed">{{ $addr->city }} - {{ $addr->district }} - {{ $addr->street }} {{ $addr->building_no ? ($isEn ? 'Bldg ' : 'مبنى ') . $addr->building_no : '' }}</p>
                                <p class="text-[11px] text-gray-400">{{ $addr->additional_info }}</p>

                                <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                    @if(!$addr->is_default)
                                        <form action="{{ route('addresses.set-default', $addr->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-[11px] text-primary font-bold hover:underline">{{ $isEn ? 'Set Default' : 'جعله افتراضي' }}</button>
                                        </form>
                                    @else
                                        <div></div>
                                    @endif

                                    <form action="{{ route('addresses.destroy', $addr->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[11px] text-rose-600 font-bold hover:underline">{{ $isEn ? 'Delete Address' : 'حذف العنوان' }}</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-xs text-gray-400 font-bold col-span-2">{{ $isEn ? 'No saved addresses found' : 'لا توجد عناوين محفوظة حالياً' }}</div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- TAB 7: WISHLIST --}}
            <div x-show="activeTab === 'wishlist'" class="space-y-4">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-lg text-primary">{{ $isEn ? 'Saved Wishlist Products' : 'المنتجات المحفوظة في المفضلة' }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @forelse($wishlistItems as $wItem)
                            <div class="p-4 rounded-2xl bg-surface border border-gray-100 space-y-3 text-center">
                                <h4 class="font-black text-xs text-primary">{{ $wItem->product ? $wItem->product->name : ($isEn ? 'Medical Product' : 'منتج طبي') }}</h4>
                                <span class="font-black text-accent text-xs dir-ltr block">{{ number_format($wItem->product ? $wItem->product->price : 0, 2) }} {{ __('products.sar') }}</span>
                                <a href="{{ route('products') }}" class="block px-4 py-2 bg-primary text-white rounded-xl text-xs font-bold">{{ $isEn ? 'View in Store' : 'عرض بالمتجر' }}</a>
                            </div>
                        @empty
                            <div class="text-center py-12 text-xs text-gray-400 font-bold col-span-3">{{ $isEn ? 'No wishlist items currently' : 'لا توجد منتجات بالمفضلة حالياً' }}</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- TAB: INVOICES & PAYMENTS --}}
            <div x-show="activeTab === 'billing'" class="space-y-6" x-data="{ openRefundModal: false, selectedPaymentId: null, selectedAmount: 0 }">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-6">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <h3 class="font-black text-lg text-primary">{{ $isEn ? 'My Tax Invoices & ZATCA Receipts' : 'فواتيري الضريبية وسندات الدفع المعتمدة' }}</h3>
                    </div>

                    {{-- Invoices Table --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }}">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 font-extrabold border-b border-gray-100">
                                    <th class="p-3">#</th>
                                    <th class="p-3">{{ $isEn ? 'Invoice #' : 'رقم الفاتورة' }}</th>
                                    <th class="p-3">{{ $isEn ? 'Date' : 'التاريخ' }}</th>
                                    <th class="p-3">{{ $isEn ? 'Payment Status' : 'حالة الدفع' }}</th>
                                    <th class="p-3">{{ $isEn ? 'Total (SAR)' : 'المجموع' }}</th>
                                    <th class="p-3 text-center">{{ $isEn ? 'Download' : 'تحميل PDF' }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($userInvoices as $inv)
                                    <tr>
                                        <td class="p-3 font-bold text-gray-400">{{ $inv->id }}</td>
                                        <td class="p-3 font-black text-primary dir-ltr">{{ $inv->invoice_number }}</td>
                                        <td class="p-3 font-medium text-gray-600 dir-ltr">{{ $inv->issue_date->format('Y-m-d') }}</td>
                                        <td class="p-3 font-bold">
                                            @if($inv->payment_status === 'paid')
                                                <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-700 rounded-full text-[10px]">مسددة</span>
                                            @else
                                                <span class="px-2.5 py-0.5 bg-amber-50 text-amber-700 rounded-full text-[10px]">غير مسددة</span>
                                            @endif
                                        </td>
                                        <td class="p-3 font-black text-gray-900 dir-ltr">{{ number_format($inv->total_amount, 2) }} ر.س</td>
                                        <td class="p-3 text-center">
                                            <a href="{{ route('invoices.download', $inv->id) }}" target="_blank" class="px-3 py-1 bg-emerald-600 text-white font-bold rounded-xl text-[10px]">
                                                تحميل الفاتورة PDF
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-6 text-center text-gray-400 font-bold">{{ $isEn ? 'No invoices issued yet.' : 'لا توجد فواتير صادرة لحسابك حتى الآن.' }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Payments & Refund Form --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <h3 class="font-black text-base text-primary border-b border-gray-100 pb-3">{{ $isEn ? 'Payments History & Refund Requests' : 'سجل المدفوعات وطلبات الاسترجاع' }}</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs {{ $isEn ? 'text-left' : 'text-right' }}">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 font-extrabold border-b border-gray-100">
                                    <th class="p-3">#</th>
                                    <th class="p-3">{{ $isEn ? 'Payment Number' : 'رقم عملية الدفع' }}</th>
                                    <th class="p-3">{{ $isEn ? 'Method' : 'طريقة الدفع' }}</th>
                                    <th class="p-3">{{ $isEn ? 'Amount' : 'المبلغ' }}</th>
                                    <th class="p-3">{{ $isEn ? 'Status' : 'الحالة' }}</th>
                                    <th class="p-3 text-center">{{ $isEn ? 'Receipt & Refund' : 'سند القبض والطلب' }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($userPayments as $pay)
                                    <tr>
                                        <td class="p-3 font-bold text-gray-400">{{ $pay->id }}</td>
                                        <td class="p-3 font-black text-primary dir-ltr">{{ $pay->payment_number }}</td>
                                        <td class="p-3 font-bold text-gray-700">{{ \App\Services\PaymentGatewayService::SUPPORTED_METHODS[$pay->payment_method] ?? $pay->payment_method }}</td>
                                        <td class="p-3 font-black text-gray-900 dir-ltr">{{ number_format($pay->amount, 2) }} ر.س</td>
                                        <td class="p-3 font-bold">
                                            @if($pay->status === 'completed')
                                                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 rounded-full text-[10px]">مكتملة</span>
                                            @else
                                                <span class="px-2 py-0.5 bg-rose-100 text-rose-800 rounded-full text-[10px]">{{ $pay->status }}</span>
                                            @endif
                                        </td>
                                        <td class="p-3 flex items-center justify-center gap-2">
                                            <a href="{{ route('receipts.download', $pay->id) }}" target="_blank" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-[10px]">
                                                سند القبض
                                            </a>
                                            @if($pay->status === 'completed')
                                                <button @click="openRefundModal = true; selectedPaymentId = {{ $pay->id }}; selectedAmount = {{ $pay->amount }}" class="px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-[10px]">
                                                    طلب استرجاع
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-6 text-center text-gray-400 font-bold">{{ $isEn ? 'No payment transactions found.' : 'لا توجد عمليات دفع سابقة.' }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Refund Request Modal --}}
                <div x-show="openRefundModal" x-cloak class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-3 sm:p-6 overflow-y-auto">
                    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative border border-gray-100 space-y-4 text-right">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                            <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Submit Refund Request' : 'تقديم طلب استرجاع مالي' }}</h3>
                            <button @click="openRefundModal = false" class="text-gray-400 hover:text-gray-600">✕</button>
                        </div>
                        <form action="{{ route('refunds.store') }}" method="POST" class="space-y-3">
                            @csrf
                            <input type="hidden" name="payment_id" :value="selectedPaymentId">
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">المبلغ المطلوب استرجاعه (ر.س)</label>
                                <input type="text" readonly :value="selectedAmount + ' ر.س'" class="w-full bg-gray-100 border border-gray-200 rounded-xl p-2.5 text-xs font-black dir-ltr">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-700 block mb-1">سبب الاسترجاع والتفاصيل *</label>
                                <textarea name="reason" rows="3" required placeholder="اذكر سبب طلب الاسترجاع والتفاصيل..." class="w-full bg-gray-50 border border-gray-200 rounded-xl p-2.5 text-xs font-bold resize-none"></textarea>
                            </div>
                            <div class="pt-2 flex justify-end gap-2 border-t border-gray-100">
                                <button type="button" @click="openRefundModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-xl text-xs">إلغاء</button>
                                <button type="submit" class="px-5 py-2 bg-amber-600 text-white font-extrabold rounded-xl text-xs">تأكيد إرسال الطلب</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- TAB 8: EDIT PROFILE & PASSWORD --}}
            <div x-show="activeTab === 'info'" class="space-y-6">

                
                {{-- Profile Info Form --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-5">
                    <h3 class="font-black text-lg text-primary border-b border-gray-100 pb-3">{{ $isEn ? 'Update Personal Profile & Identification' : 'تحديث البيانات الشخصية الهوية' }}</h3>

                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Full Name *' : 'الاسم الكامل *' }}</label>
                                <input type="text" name="name" value="{{ $user->name }}" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Email Address *' : 'البريد الإلكتروني *' }}</label>
                                <input type="email" name="email" value="{{ $user->email }}" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Contact Phone *' : 'رقم الجوال للتواصل *' }}</label>
                                <input type="text" name="phone" value="{{ $user->phone }}" placeholder="05XXXXXXXX" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold {{ $isEn ? 'text-left' : 'dir-ltr text-right' }}">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Patient ID Type' : 'نوع الهوية للمريض' }}</label>
                                <select name="identification_type" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                                    <option value="saudi_id" {{ $user->identification_type === 'saudi_id' ? 'selected' : '' }}>{{ $isEn ? 'Saudi National ID' : 'هوية وطنية سعودية' }}</option>
                                    <option value="iqama" {{ $user->identification_type === 'iqama' ? 'selected' : '' }}>{{ $isEn ? 'Resident Iqama' : 'إقامة مقيم' }}</option>
                                    <option value="border_number" {{ $user->identification_type === 'border_number' ? 'selected' : '' }}>{{ $isEn ? 'Border Number' : 'رقم حدود' }}</option>
                                    <option value="gcc_id" {{ $user->identification_type === 'gcc_id' ? 'selected' : '' }}>{{ $isEn ? 'GCC National ID' : 'هوية مواطن خليجي' }}</option>
                                </select>
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'National ID / Iqama Number' : 'رقم الهوية الوطنية / الإقامة' }}</label>
                                <input type="text" name="identification_number" value="{{ $user->identification_number }}" placeholder="10XXXXXXXX" class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold {{ $isEn ? 'text-left' : 'dir-ltr text-right' }}">
                            </div>
                        </div>

                        <button type="submit" class="px-8 py-3 bg-primary hover:bg-primary-hover text-white rounded-2xl font-black text-xs shadow-md">{{ $isEn ? 'Save Profile Changes' : 'حفظ التعديلات' }}</button>
                    </form>
                </div>

                {{-- Password Form --}}
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-5">
                    <h3 class="font-black text-lg text-primary border-b border-gray-100 pb-3">{{ $isEn ? 'Change Account Password' : 'تغيير كلمة المرور' }}</h3>

                    <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Current Password *' : 'كلمة المرور الحالية *' }}</label>
                                <input type="password" name="current_password" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'New Password *' : 'كلمة المرور الجديدة *' }}</label>
                                <input type="password" name="new_password" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 mb-1">{{ $isEn ? 'Confirm New Password *' : 'تأكيد كلمة المرور الجديدة *' }}</label>
                                <input type="password" name="new_password_confirmation" required class="w-full h-11 px-4 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold">
                            </div>
                        </div>

                        <button type="submit" class="px-8 py-3 bg-accent hover:bg-accent-hover text-white rounded-2xl font-black text-xs shadow-md">{{ $isEn ? 'Update Password' : 'تحديث كلمة السر' }}</button>
                    </form>
                </div>

            </div>

        </div>
    </section>

</x-app-layout>
