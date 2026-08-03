<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-sm transition-all duration-300" x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.scrollY > 20)">

    {{-- Main Navigation Bar --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-[72px]">

            {{-- Logo --}}
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

            {{-- Desktop Menu Links --}}
            <nav class="hidden lg:flex items-center gap-1">
                <a href="{{ url('/') }}" class="px-3 py-2 text-sm font-bold text-primary hover:text-accent rounded-lg hover:bg-medical-50 transition-all">الرئيسية</a>
                <a href="{{ url('/about') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">من نحن</a>
                <a href="{{ url('/services') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">الخدمات الطبية</a>
                <a href="{{ url('/products') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">المتجر الطبي</a>
                <a href="{{ url('/blog') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">المدونة</a>
                <a href="{{ url('/contact') }}" class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all">تواصل معنا</a>
            </nav>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-2 sm:gap-3">
                {{-- WhatsApp Quick --}}
                <a href="https://wa.me/966545880082" target="_blank" class="hidden md:flex items-center gap-1.5 px-3 py-2 text-[12px] font-bold text-[#25D366] bg-[#25D366]/10 rounded-lg hover:bg-[#25D366]/20 transition-all" title="واتساب">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.157 4.228 4.305-1.129z"/></svg>
                    <span>واتساب</span>
                </a>

                {{-- Phone Quick --}}
                <a href="tel:+966545880082" class="hidden sm:flex items-center gap-1.5 px-3 py-2 text-[12px] font-bold text-primary bg-medical-50 rounded-lg hover:bg-medical-100 transition-all dir-ltr" title="اتصل بنا">
                    <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span>0545880082</span>
                </a>

                {{-- Cart Button (Livewire Reactive) --}}
                @livewire('cart-badge')

                @if(Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->isSuperAdmin()))
                    <a href="{{ route('admin.dashboard') }}" class="hidden md:flex items-center gap-1.5 px-3.5 py-2 text-xs font-black text-white bg-primary hover:bg-primary-hover rounded-xl shadow-sm transition-all border border-white/20" title="لوحة الأدمن">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>لوحة الأدمن</span>
                    </a>
                @endif

                {{-- User Account --}}
                <a href="{{ route('profile') }}" class="hidden sm:flex p-2.5 text-gray-500 hover:text-primary hover:bg-medical-50 rounded-xl transition-all" title="حسابي والبروفايل">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </a>

                {{-- CTA Button --}}
                <button @click="callbackModalOpen = true" class="hidden lg:inline-flex items-center gap-2 px-5 py-2.5 bg-accent text-white text-xs font-bold rounded-xl shadow-md hover:bg-accent-hover hover:shadow-lg transition-all duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    اطلب اتصالًا
                </button>

                {{-- Mobile Menu Button --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2.5 text-gray-700 hover:bg-medical-50 rounded-xl transition-all">
                    <svg class="w-6 h-6" x-show="!mobileMenuOpen" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg class="w-6 h-6" x-show="mobileMenuOpen" x-cloak fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Mobile Drawer Menu --}}
            <div x-show="mobileMenuOpen" x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 class="absolute top-full right-0 left-0 bg-white border-b border-gray-200 shadow-xl lg:hidden py-4 px-6 space-y-3">
                <a href="{{ url('/') }}" class="block py-2.5 text-base font-bold text-primary border-b border-gray-50">الرئيسية</a>
                <a href="{{ url('/about') }}" class="block py-2.5 text-base font-bold text-gray-700 hover:text-primary border-b border-gray-50">من نحن</a>
                <a href="{{ url('/services') }}" class="block py-2.5 text-base font-bold text-gray-700 hover:text-primary border-b border-gray-50">الخدمات الطبية</a>
                <a href="{{ url('/products') }}" class="block py-2.5 text-base font-bold text-gray-700 hover:text-primary border-b border-gray-50">المتجر الطبي</a>
                <a href="{{ url('/blog') }}" class="block py-2.5 text-base font-bold text-gray-700 hover:text-primary border-b border-gray-50">المدونة الطبية</a>
                <a href="{{ url('/faq') }}" class="block py-2.5 text-base font-bold text-gray-700 hover:text-primary border-b border-gray-50">الأسئلة الشائعة</a>
                <a href="{{ url('/contact') }}" class="block py-2.5 text-base font-bold text-gray-700 hover:text-primary border-b border-gray-50">تواصل معنا</a>

                {{-- Mobile Quick Info --}}
                <div class="pt-3 space-y-2">
                    <a href="tel:+966545880082" class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span class="dir-ltr font-bold">+966 54 588 0082</span>
                    </a>
                    <a href="mailto:c.care@s-sema.com" class="flex items-center gap-2 text-sm text-gray-600">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>c.care@s-sema.com</span>
                    </a>
                </div>

                <div class="pt-3 flex flex-col gap-2">
                    <button @click="callbackModalOpen = true; mobileMenuOpen = false" class="w-full btn-accent py-3 rounded-xl font-bold text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        اطلب معاودة اتصال
                    </button>
                    <a href="https://wa.me/966545880082" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-3 bg-[#25D366] text-white rounded-xl font-bold text-sm">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654z"/></svg>
                        واتساب
                    </a>
                </div>
            </div>

        </div>
    </div>
</header>
