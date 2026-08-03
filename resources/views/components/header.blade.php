<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm transition-all duration-300">
    <!-- Top Announcement Bar -->
    <div class="bg-primary text-white text-xs py-2 px-4 border-b border-primary-light/20">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <!-- Left Info -->
            <div class="flex items-center gap-6">
                <a href="tel:+966545880082" class="flex items-center gap-1.5 hover:text-accent transition-colors dir-ltr">
                    <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span class="font-bold">+966 54 588 0082</span>
                </a>
                <a href="mailto:c.care@s-sema.com" class="hidden md:flex items-center gap-1.5 hover:text-accent transition-colors">
                    <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>c.care@s-sema.com</span>
                </a>
                <span class="hidden lg:inline-flex items-center gap-1 text-medical-300">
                    <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    <span>جدة، حي الرويس، طريق المدينة المنورة</span>
                </span>
            </div>

            <!-- Right Actions: City & Language Switcher -->
            <div class="flex items-center gap-4">
                <!-- City Selector Badge -->
                <div class="hidden sm:flex items-center gap-1 text-medical-100 bg-white/10 px-2.5 py-0.5 rounded-full text-[11px]">
                    <svg class="w-3 h-3 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>المدينة المفضلة: <strong class="text-white">جدة</strong></span>
                </div>

                <!-- Language Switcher Button -->
                <a href="#" class="flex items-center gap-1 hover:text-accent font-bold transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                    <span>English</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20" x-data="{ mobileMenuOpen: false }">
            
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="سيما الخليج للخدمات الطبية" class="h-14 w-auto object-contain transition-transform duration-300 group-hover:scale-105" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                    <div class="hidden items-center gap-2">
                        <div class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center font-black text-xl">S</div>
                        <div class="flex flex-col">
                            <span class="font-bold text-lg text-primary leading-tight">سيما الخليج</span>
                            <span class="text-xs text-accent font-medium">للخدمات الطبية</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Desktop Menu Links -->
            <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                <a href="{{ url('/') }}" class="px-3 py-2 text-sm font-bold text-primary hover:text-accent rounded-lg hover:bg-medical-50 transition-all">الرئيسية</a>
                <a href="{{ url('/about') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">من نحن</a>
                <a href="{{ url('/services') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">الخدمات الطبية</a>
                <a href="{{ url('/products') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">المتجر الطبي</a>
                <a href="{{ url('/blog') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">المدونة الطبية</a>
                <a href="{{ url('/faq') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">الأسئلة الشائعة</a>
                <a href="{{ url('/contact') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">تواصل معنا</a>
            </nav>

            <!-- Action Buttons (Wishlist, Cart, User, Callback CTA) -->
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Search Button Trigger -->
                <button @click="searchOpen = true" class="p-2.5 text-gray-600 hover:text-primary hover:bg-medical-50 rounded-xl transition-all" title="بحث">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>

                <!-- Wishlist Button -->
                <a href="{{ url('/wishlist') }}" class="p-2.5 text-gray-600 hover:text-primary hover:bg-medical-50 rounded-xl transition-all relative" title="المفضلة">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-accent rounded-full"></span>
                </a>

                <!-- Cart Counter Button -->
                <a href="{{ url('/cart') }}" class="p-2.5 text-gray-600 hover:text-primary hover:bg-medical-50 rounded-xl transition-all relative" title="السلة">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span class="absolute -top-1 -right-1 bg-accent text-white font-bold text-[10px] w-5 h-5 rounded-full flex items-center justify-center border-2 border-white">0</span>
                </a>

                <!-- User Account Button -->
                <a href="{{ url('/login') }}" class="hidden sm:flex p-2.5 text-gray-600 hover:text-primary hover:bg-medical-50 rounded-xl transition-all" title="حسابي">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </a>

                <!-- Request Callback Button CTA -->
                <button @click="callbackModalOpen = true" class="hidden lg:inline-flex btn-primary text-xs py-2.5 px-4 rounded-xl font-bold shadow-soft hover:shadow-md">
                    <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span>اطلب اتصالًا</span>
                </button>

                <!-- Mobile Menu Button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2.5 text-gray-700 hover:bg-medical-50 rounded-xl transition-all">
                    <svg class="w-6 h-6" x-show="!mobileMenuOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg class="w-6 h-6" x-show="mobileMenuOpen" x-cloak fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Mobile Drawer Menu -->
            <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" class="absolute top-full right-0 left-0 bg-white border-b border-gray-200 shadow-xl md:hidden py-4 px-6 space-y-3">
                <a href="{{ url('/') }}" class="block py-2 text-base font-bold text-primary border-b border-gray-50">الرئيسية</a>
                <a href="{{ url('/about') }}" class="block py-2 text-base font-bold text-gray-700 hover:text-primary border-b border-gray-50">من نحن</a>
                <a href="{{ url('/services') }}" class="block py-2 text-base font-bold text-gray-700 hover:text-primary border-b border-gray-50">الخدمات الطبية المنزلية</a>
                <a href="{{ url('/products') }}" class="block py-2 text-base font-bold text-gray-700 hover:text-primary border-b border-gray-50">المتجر الطبي والمستلزمات</a>
                <a href="{{ url('/blog') }}" class="block py-2 text-base font-bold text-gray-700 hover:text-primary border-b border-gray-50">المدونة الطبية</a>
                <a href="{{ url('/faq') }}" class="block py-2 text-base font-bold text-gray-700 hover:text-primary border-b border-gray-50">الأسئلة الشائعة</a>
                <a href="{{ url('/contact') }}" class="block py-2 text-base font-bold text-gray-700 hover:text-primary border-b border-gray-50">تواصل معنا</a>
                
                <div class="pt-3 flex flex-col gap-2">
                    <button @click="callbackModalOpen = true; mobileMenuOpen = false" class="w-full btn-primary py-3 rounded-xl font-bold">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>اطلب معاودة اتصال</span>
                    </button>
                    <a href="{{ url('/login') }}" class="w-full btn-outline py-2.5 rounded-xl font-bold text-center">تسجيل الدخول / حسابي</a>
                </div>
            </div>

        </div>
    </div>
</header>
