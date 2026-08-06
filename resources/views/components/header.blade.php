<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-md shadow-sm transition-all duration-300"
        x-data="{ mobileMenuOpen: false, corporateDropdownOpen: false, scrolled: false }"
        @scroll.window="scrolled = (window.scrollY > 20)">

    {{-- Main Navigation Bar --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-[80px] gap-3">

            {{-- ═══ LOGO ═══ --}}
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}" class="flex items-center group">
                    <img src="{{ asset($siteSettings['site_logo'] ?? 'images/logo.png') }}"
                         alt="{{ $siteSettings['site_title'] ?? 'سيما الخليج' }}"
                         class="h-14 sm:h-16 lg:h-[68px] w-auto object-contain transition-transform duration-300 group-hover:scale-105"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                    {{-- Fallback --}}
                    <div class="hidden items-center gap-2">
                        <div class="w-9 h-9 rounded-xl bg-primary text-white flex items-center justify-center font-black text-lg">S</div>
                        <div class="flex flex-col">
                            <span class="font-bold text-base text-primary leading-tight">سيما الخليج</span>
                            <span class="text-[11px] text-accent font-medium">للخدمات الطبية</span>
                        </div>
                    </div>
                </a>
            </div>

            {{-- ═══ DESKTOP NAV ═══ --}}
            <nav class="hidden lg:flex items-center gap-0.5 flex-1 justify-center">
                <a href="{{ url('/') }}"
                   class="px-3 py-2 text-sm font-bold text-primary hover:text-accent rounded-lg hover:bg-medical-50 transition-all whitespace-nowrap">
                    {{ __('nav.home') }}
                </a>
                <a href="{{ url('/about') }}"
                   class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all whitespace-nowrap">
                    {{ __('nav.about') }}
                </a>
                <a href="{{ url('/services') }}"
                   class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all whitespace-nowrap">
                    {{ __('nav.services') }}
                </a>

                {{-- Corporate Dropdown --}}
                <div class="relative"
                     @mouseenter="corporateDropdownOpen = true"
                     @mouseleave="corporateDropdownOpen = false"
                     @click.outside="corporateDropdownOpen = false">
                    <button @click="corporateDropdownOpen = !corporateDropdownOpen"
                            class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all flex items-center gap-1 whitespace-nowrap">
                        <span>{{ __('nav.corporate') }}</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-200"
                             :class="corporateDropdownOpen ? 'rotate-180 text-primary' : ''"
                             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="corporateDropdownOpen" x-cloak
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-100"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute top-full pt-1.5 w-64 z-50
                                {{ app()->getLocale() == 'en' ? 'left-0' : 'right-0' }}">
                        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 py-2 {{ app()->getLocale() == 'en' ? 'text-left' : 'text-right' }}">
                            <a href="{{ route('corporate-services') }}" class="block px-4 py-2.5 text-xs font-bold text-gray-700 hover:bg-medical-50 hover:text-primary transition-all">{{ __('nav.corp_solutions') }}</a>
                            <a href="{{ route('corporate-services') }}" class="block px-4 py-2.5 text-xs font-bold text-gray-700 hover:bg-medical-50 hover:text-primary transition-all">{{ __('nav.corp_medical') }}</a>
                            <a href="{{ url('/corporate-services#contract-request-form') }}" class="block px-4 py-2.5 text-xs font-bold text-accent hover:bg-accent/10 transition-all">{{ __('nav.corp_new_contract') }}</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="{{ route('login') }}" class="block px-4 py-2.5 text-xs font-bold text-primary hover:bg-primary/5 transition-all">{{ __('nav.corp_login') }}</a>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/products') }}"
                   class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all whitespace-nowrap">
                    {{ __('nav.products') }}
                </a>
                <a href="{{ url('/blog') }}"
                   class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all whitespace-nowrap">
                    {{ __('nav.blog') }}
                </a>
                <a href="{{ url('/contact') }}"
                   class="px-3 py-2 text-sm font-bold text-gray-700 hover:text-primary rounded-lg hover:bg-medical-50 transition-all whitespace-nowrap">
                    {{ __('nav.contact') }}
                </a>
            </nav>

            {{-- ═══ ACTION BUTTONS ═══ --}}
            <div class="flex items-center gap-1.5 shrink-0">

                {{-- Language Switcher --}}
                @if(app()->getLocale() == 'ar')
                    <a href="{{ route('lang.switch', 'en') }}"
                       title="English"
                       class="flex items-center gap-1 px-2.5 py-2 text-xs font-bold text-gray-600 hover:text-primary hover:bg-medical-50 rounded-lg transition-all border border-gray-200 hover:border-primary/30 shrink-0">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                        <span class="hidden sm:inline font-bold">EN</span>
                    </a>
                @else
                    <a href="{{ route('lang.switch', 'ar') }}"
                       title="العربية"
                       class="flex items-center gap-1 px-2.5 py-2 text-xs font-bold text-gray-600 hover:text-primary hover:bg-medical-50 rounded-lg transition-all border border-gray-200 hover:border-primary/30 shrink-0">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                        <span class="hidden sm:inline font-bold">عر</span>
                    </a>
                @endif

                {{-- Role-Based Dashboard --}}
                @auth
                    @if(in_array(Auth::user()->role, ['admin', 'super_admin', 'manager']))
                        <a href="{{ route('admin.dashboard') }}"
                           title="{{ __('nav.admin_panel') }}"
                           class="flex items-center gap-1.5 px-3 py-2 text-xs font-black text-white bg-primary hover:bg-primary-hover rounded-xl shadow-sm transition-all whitespace-nowrap shrink-0">
                            <svg class="w-4 h-4 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span class="hidden sm:inline">{{ __('nav.admin_panel') }}</span>
                        </a>
                    @elseif(in_array(Auth::user()->role, ['doctor', 'nurse', 'physio', 'lab_tech']))
                        <a href="{{ route('staff.dashboard') }}"
                           title="{{ __('nav.staff_portal') }}"
                           class="flex items-center gap-1.5 px-3 py-2 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition-all shrink-0">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="hidden sm:inline">{{ __('nav.staff_portal') }}</span>
                        </a>
                    @elseif(in_array(Auth::user()->role, ['company_admin', 'company_operator']))
                        <a href="{{ route('company.portal') }}"
                           title="{{ __('nav.company_portal') }}"
                           class="flex items-center gap-1.5 px-3 py-2 text-xs font-black text-white bg-purple-600 hover:bg-purple-700 rounded-xl shadow-sm transition-all shrink-0">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span class="hidden sm:inline">{{ __('nav.company_portal') }}</span>
                        </a>
                    @endif
                @endauth

                {{-- User / Login --}}
                @guest
                    <a href="{{ route('login') }}"
                       title="{{ __('nav.login') }}"
                       class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-primary bg-medical-50 hover:bg-primary hover:text-white rounded-xl transition-all border border-primary/15 shrink-0">
                        <svg class="w-4 h-4 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden sm:inline whitespace-nowrap">{{ __('nav.login') }}</span>
                    </a>
                @else
                    <a href="{{ route('profile') }}"
                       title="{{ __('nav.my_account') }}"
                       class="flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-gray-700 hover:text-primary hover:bg-medical-50 rounded-xl transition-all shrink-0">
                        <svg class="w-5 h-5 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="hidden sm:inline whitespace-nowrap">{{ __('nav.my_account') }}</span>
                    </a>
                @endguest

                {{-- Cart --}}
                @livewire('cart-badge')

                {{-- Request Service CTA --}}
                <button @click="callbackModalOpen = true"
                        class="hidden lg:inline-flex items-center gap-2 px-4 py-2.5 bg-accent text-white text-xs font-bold rounded-xl shadow-md hover:bg-accent-hover transition-all whitespace-nowrap shrink-0">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ __('nav.request_service') }}
                </button>

                {{-- Mobile Hamburger --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="lg:hidden p-2 text-gray-700 hover:bg-medical-50 rounded-xl transition-all">
                    <svg class="w-6 h-6" x-show="!mobileMenuOpen" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg class="w-6 h-6" x-show="mobileMenuOpen" x-cloak fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- ═══ MOBILE DRAWER ═══ --}}
    <div x-show="mobileMenuOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="absolute top-full inset-x-0 bg-white border-b border-gray-200 shadow-xl lg:hidden py-4 px-5 space-y-1">
        <a href="{{ url('/') }}"        class="block text-sm font-bold text-primary py-2 px-3 rounded-xl hover:bg-medical-50 transition-all">{{ __('nav.home') }}</a>
        <a href="{{ url('/about') }}"    class="block text-sm font-bold text-gray-700 py-2 px-3 rounded-xl hover:bg-medical-50 transition-all">{{ __('nav.about') }}</a>
        <a href="{{ url('/services') }}" class="block text-sm font-bold text-gray-700 py-2 px-3 rounded-xl hover:bg-medical-50 transition-all">{{ __('nav.services') }}</a>
        <a href="{{ route('corporate-services') }}" class="block text-sm font-bold text-accent py-2 px-3 rounded-xl hover:bg-accent/10 transition-all">{{ __('nav.corporate') }}</a>
        <a href="{{ url('/products') }}" class="block text-sm font-bold text-gray-700 py-2 px-3 rounded-xl hover:bg-medical-50 transition-all">{{ __('nav.products') }}</a>
        <a href="{{ url('/blog') }}"     class="block text-sm font-bold text-gray-700 py-2 px-3 rounded-xl hover:bg-medical-50 transition-all">{{ __('nav.blog') }}</a>
        <a href="{{ url('/contact') }}"  class="block text-sm font-bold text-gray-700 py-2 px-3 rounded-xl hover:bg-medical-50 transition-all">{{ __('nav.contact') }}</a>
        <div class="pt-3 border-t border-gray-100">
            <button @click="callbackModalOpen = true; mobileMenuOpen = false"
                    class="w-full btn-accent py-3 rounded-xl font-bold text-sm">
                {{ __('nav.request_service') }}
            </button>
        </div>
    </div>

</header>
