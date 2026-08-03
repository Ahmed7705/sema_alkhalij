<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-sm transition-all duration-300" x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.scrollY > 20)">

    {{-- Main Navigation Bar --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-[72px]">

            {{-- Logo --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('images/logo.png') }}" alt="سيما الخليج للخدمات الطبية" class="h-11 sm:h-13 w-auto object-contain transition-transform duration-300 group-hover:scale-105" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                    <div class="hidden items-center gap-2">
                        <div class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center font-black text-lg">S</div>
                        <div class="flex flex-col">
                            <span class="font-bold text-base text-primary leading-tight">سيما الخليج</span>
                            <span class="text-[10px] text-accent font-medium">للخدمات الطبية</span>
                        </div>
                    </div>
                </a>
            </div>

            {{-- Desktop Menu Links --}}
            <nav class="hidden lg:flex items-center gap-0.5 xl:gap-1">
                <a href="{{ url('/') }}" class="px-2.5 py-1.5 text-xs xl:text-sm font-bold text-primary hover:text-accent rounded-lg hover:bg-medical-50 transition-all whitespace-nowrap">الرئيسية</a>
                <a href="{{ url('/about') }}" class="px-2.5 py-1.5 text-xs xl:text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all whitespace-nowrap">من نحن</a>
                <a href="{{ url('/services') }}" class="px-2.5 py-1.5 text-xs xl:text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all whitespace-nowrap">الخدمات الطبية</a>
                <a href="{{ url('/products') }}" class="px-2.5 py-1.5 text-xs xl:text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all whitespace-nowrap">المتجر الطبي</a>
                <a href="{{ url('/blog') }}" class="px-2.5 py-1.5 text-xs xl:text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all whitespace-nowrap">المدونة</a>
                <a href="{{ url('/contact') }}" class="px-2.5 py-1.5 text-xs xl:text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all whitespace-nowrap">تواصل معنا</a>
            </nav>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-1.5 sm:gap-2 xl:gap-3 shrink-0">
                
                {{-- WhatsApp Quick --}}
                <a href="https://wa.me/966545880082" target="_blank" class="hidden 2xl:flex items-center gap-1.5 px-2.5 py-1.5 text-[11px] font-bold text-[#25D366] bg-[#25D366]/10 rounded-lg hover:bg-[#25D366]/20 transition-all" title="واتساب">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.157 4.228 4.305-1.129z"/></svg>
                    <span>واتساب</span>
                </a>

                {{-- Phone Quick --}}
                <a href="tel:+966545880082" class="hidden xl:flex items-center gap-1 px-2.5 py-1.5 text-[11px] font-bold text-primary bg-medical-50 rounded-lg hover:bg-medical-100 transition-all dir-ltr" title="اتصل بنا">
                    <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span>0545880082</span>
                </a>

                {{-- Cart Button (Livewire Reactive) --}}
                @livewire('cart-badge')

                {{-- Clean Authentication & Admin Buttons --}}
                @auth
                    @if(Auth::user()->role === 'admin' || Auth::user()->isSuperAdmin())
                        {{-- If Admin: Show Only 'لوحة الأدمن' --}}
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-black text-white bg-primary hover:bg-primary-hover rounded-xl shadow-sm transition-all border border-white/20" title="لوحة تحكم الأدمن">
                            <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>لوحة الأدمن</span>
                        </a>
                    @else
                        {{-- If Customer: Show Profile Name Button --}}
                        <a href="{{ route('profile') }}" class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-primary bg-medical-50 hover:bg-medical-100 rounded-xl transition-all border border-primary/10 shadow-sm" title="البروفايل">
                            <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                    @endif
                @else
                    {{-- Prominent Login Button for Visitor/Guest --}}
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-bold text-white bg-primary hover:bg-primary-hover rounded-xl shadow-sm transition-all border border-primary/20 group">
                        <svg class="w-4 h-4 text-accent group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span>تسجيل الدخول</span>
                    </a>
                @endauth

                {{-- Request Callback CTA Button --}}
                <button @click="callbackModalOpen = true" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 bg-accent text-white text-xs font-bold rounded-xl shadow-md hover:bg-accent-hover hover:shadow-lg transition-all duration-300">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span class="whitespace-nowrap">اطلب اتصالاً</span>
                </button>

                {{-- Mobile Menu Button --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-gray-700 hover:bg-medical-50 rounded-xl transition-all">
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

                {{-- Mobile Auth Quick Action --}}
                <div class="pb-3 border-b border-gray-100">
                    @auth
                        @if(Auth::user()->role === 'admin' || Auth::user()->isSuperAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="w-full flex items-center justify-between p-3 bg-primary text-white rounded-xl font-bold text-sm shadow-sm">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    <span>لوحة الأدمن والإدارة</span>
                                </div>
                                <span class="text-xs text-accent">دخول ↗</span>
                            </a>
                        @else
                            <a href="{{ route('profile') }}" class="w-full flex items-center justify-between p-3 bg-medical-50 text-primary rounded-xl font-bold text-sm">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    <span>{{ Auth::user()->name }}</span>
                                </div>
                                <span class="text-xs text-accent">الملف الطبي ↗</span>
                            </a>
                        @endif
                    @else
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{ route('login') }}" class="btn-accent py-2.5 rounded-xl font-bold text-xs flex items-center justify-center gap-1.5 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                <span>تسجيل الدخول</span>
                            </a>
                            <a href="{{ route('register') }}" class="btn-outline py-2.5 rounded-xl font-bold text-xs flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                <span>حساب جديد</span>
                            </a>
                        </div>
                    @endauth
                </div>

                <a href="{{ url('/') }}" class="block py-2 text-sm font-bold text-primary border-b border-gray-50">الرئيسية</a>
                <a href="{{ url('/about') }}" class="block py-2 text-sm font-bold text-gray-700 hover:text-primary border-b border-gray-50">من نحن</a>
                <a href="{{ url('/services') }}" class="block py-2 text-sm font-bold text-gray-700 hover:text-primary border-b border-gray-50">الخدمات الطبية</a>
                <a href="{{ url('/products') }}" class="block py-2 text-sm font-bold text-gray-700 hover:text-primary border-b border-gray-50">المتجر الطبي</a>
                <a href="{{ url('/blog') }}" class="block py-2 text-sm font-bold text-gray-700 hover:text-primary border-b border-gray-50">المدونة الطبية</a>
                <a href="{{ url('/faq') }}" class="block py-2 text-sm font-bold text-gray-700 hover:text-primary border-b border-gray-50">الأسئلة الشائعة</a>
                <a href="{{ url('/contact') }}" class="block py-2 text-sm font-bold text-gray-700 hover:text-primary border-b border-gray-50">تواصل معنا</a>

                {{-- Mobile Quick Info --}}
                <div class="pt-2 space-y-2">
                    <a href="tel:+966545880082" class="flex items-center gap-2 text-xs text-gray-600 font-bold">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span class="dir-ltr">+966 54 588 0082</span>
                    </a>
                </div>

                <div class="pt-2 flex flex-col gap-2">
                    <button @click="callbackModalOpen = true; mobileMenuOpen = false" class="w-full btn-accent py-2.5 rounded-xl font-bold text-xs flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span>اطلب معاودة اتصال</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</header>
