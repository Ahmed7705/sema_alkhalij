<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-sm transition-all duration-300" x-data="{ mobileMenuOpen: false, corporateDropdownOpen: false, scrolled: false }" @scroll.window="scrolled = (window.scrollY > 20)">

    {{-- Main Navigation Bar --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-[72px]">

            {{-- Logo --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="سيما الخليج للخدمات الطبية" class="h-12 sm:h-14 w-auto object-contain transition-transform duration-300 group-hover:scale-105" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                    <div class="hidden items-center gap-2">
                        <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center font-black text-xl">S</div>
                        <div class="flex flex-col">
                            <span class="font-bold text-lg text-primary leading-tight">سيما الخليج</span>
                            <span class="text-xs text-accent font-medium">للخدمات الطبية</span>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Desktop Menu Links --}}
            <nav class="hidden lg:flex items-center gap-1">
                <a href="{{ url('/') }}" class="px-3 py-2 text-sm font-bold text-primary hover:text-accent rounded-lg hover:bg-medical-50 transition-all">الرئيسية</a>
                <a href="{{ url('/about') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">من نحن</a>
                <a href="{{ url('/services') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">الخدمات الطبية</a>

                {{-- Corporate Services Real Dropdown --}}
                <div class="relative" @mouseleave="corporateDropdownOpen = false">
                    <button @click="corporateDropdownOpen = !corporateDropdownOpen" @mouseenter="corporateDropdownOpen = true" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all flex items-center gap-1">
                        <span>خدمات الشركات</span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="corporateDropdownOpen ? 'rotate-180 text-primary' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div x-show="corporateDropdownOpen" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-1 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 text-right space-y-1">
                        <a href="{{ route('corporate-services') }}" class="block px-4 py-2.5 text-xs font-bold text-gray-700 hover:bg-medical-50 hover:text-primary transition-all">حلول خدمات الشركات</a>
                        <a href="{{ route('corporate-services') }}" class="block px-4 py-2.5 text-xs font-bold text-gray-700 hover:bg-medical-50 hover:text-primary transition-all">الخدمات الطبية للشركات</a>
                        <a href="{{ url('/corporate-services#contract-request-form') }}" class="block px-4 py-2.5 text-xs font-bold text-accent hover:bg-accent/10 transition-all">طلب تعاقد جديد</a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <a href="{{ route('login') }}" class="block px-4 py-2.5 text-xs font-bold text-primary hover:bg-primary/5 transition-all">دخول بوابة الشركات</a>
                    </div>
                </div>

                <a href="{{ url('/products') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">المتجر الطبي</a>
                <a href="{{ url('/blog') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">المدونة</a>
                <a href="{{ url('/contact') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">تواصل معنا</a>
            </nav>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-1.5 sm:gap-3">
                
                {{-- Role-Based Dashboard Shortcut (Visible ONLY to Authorized Roles) --}}
                @auth
                    @if(in_array(Auth::user()->role, ['admin', 'super_admin', 'manager']))
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-1.5 px-3 py-2 text-xs font-black text-white bg-primary hover:bg-primary-hover rounded-xl shadow-sm transition-all" title="لوحة الإدارة">
                            <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span class="hidden sm:inline">لوحة الإدارة</span>
                        </a>
                    @elseif(in_array(Auth::user()->role, ['doctor', 'nurse', 'physio', 'lab_tech']))
                        <a href="{{ route('staff.dashboard') }}" class="flex items-center gap-1.5 px-3 py-2 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition-all" title="بوابة الكادر الطبي">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span class="hidden sm:inline">بوابة الكادر</span>
                        </a>
                    @elseif(in_array(Auth::user()->role, ['company_admin', 'company_operator']))
                        <a href="{{ route('company.portal') }}" class="flex items-center gap-1.5 px-3 py-2 text-xs font-black text-white bg-purple-600 hover:bg-purple-700 rounded-xl shadow-sm transition-all" title="بوابة الشركة">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            <span class="hidden sm:inline">بوابة الشركة</span>
                        </a>
                    @endif
                @endauth

                {{-- User Profile / Login Button --}}
                @guest
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-primary bg-medical-50 hover:bg-primary hover:text-white rounded-xl transition-all border border-primary/15" title="تسجيل الدخول">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span>تسجيل الدخول</span>
                    </a>
                @else
                    <a href="{{ route('profile') }}" class="flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-gray-700 hover:text-primary hover:bg-medical-50 rounded-xl transition-all" title="حسابي والبروفايل">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>حسابي</span>
                    </a>
                @endguest

                {{-- Cart Badge Component --}}
                @livewire('cart-badge')

                {{-- Service Request Button --}}
                <button @click="callbackModalOpen = true" class="hidden lg:inline-flex items-center gap-2 px-5 py-2.5 bg-accent text-white text-xs font-bold rounded-xl shadow-md hover:bg-accent-hover transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    طلب خدمة
                </button>

                {{-- Mobile Menu Trigger --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-gray-700 hover:bg-medical-50 rounded-xl transition-all">
                    <svg class="w-6 h-6" x-show="!mobileMenuOpen" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg class="w-6 h-6" x-show="mobileMenuOpen" x-cloak fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Mobile Drawer Menu --}}
            <div x-show="mobileMenuOpen" x-cloak
                 class="absolute top-full right-0 left-0 bg-white border-b border-gray-200 shadow-xl lg:hidden py-4 px-6 space-y-3">
                <a href="{{ url('/') }}" class="block text-sm font-bold text-primary">الرئيسية</a>
                <a href="{{ url('/about') }}" class="block text-sm font-bold text-gray-700">من نحن</a>
                <a href="{{ url('/services') }}" class="block text-sm font-bold text-gray-700">الخدمات الطبية</a>
                <a href="{{ route('corporate-services') }}" class="block text-sm font-bold text-accent">خدمات الشركات</a>
                <a href="{{ url('/products') }}" class="block text-sm font-bold text-gray-700">المتجر الطبي</a>
                <a href="{{ url('/blog') }}" class="block text-sm font-bold text-gray-700">المدونة</a>
                <a href="{{ url('/contact') }}" class="block text-sm font-bold text-gray-700">تواصل معنا</a>
            </div>

        </div>
    </div>
</header>
