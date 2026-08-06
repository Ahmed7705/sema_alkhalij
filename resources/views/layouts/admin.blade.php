@php
    $isEn = app()->getLocale() == 'en';
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isEn ? 'ltr' : 'rtl' }}" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? ($isEn ? 'Admin Dashboard' : 'لوحة تحكم الأدمن') }} | {{ $isEn ? 'Sema Al-Khalij Medical Services' : 'سيما الخليج للخدمات الطبية' }}</title>
    
    {{-- Google Fonts: Tajawal & Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    
    {{-- Tailwind CSS, AlpineJS & Chart.js --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#006C35',
                        'primary-hover': '#00572B',
                        accent: '#3CA96B',
                        'accent-hover': '#318F59',
                        surface: '#F8FAFC',
                    },
                    fontFamily: {
                        sans: ['Tajawal', 'Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 10px 30px -5px rgba(15, 76, 58, 0.05)',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-[#F6F9F7] font-sans text-gray-800 antialiased h-screen overflow-hidden flex" x-data="{ sidebarOpen: false }">

    {{-- MOBILE BACKDROP OVERLAY --}}
    <div x-show="sidebarOpen" x-cloak 
         @click="sidebarOpen = false" 
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden"></div>

    {{-- FIXED STICKY SIDEBAR NAVIGATION --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '{{ $isEn ? '-translate-x-full lg:translate-x-0' : 'translate-x-full lg:translate-x-0' }}'"
           class="fixed inset-y-0 {{ $isEn ? 'left-0 border-r' : 'right-0 border-l' }} z-50 w-72 lg:w-64 bg-gradient-to-b from-[#005E2E] via-[#007C3D] to-[#005028] text-white flex flex-col shrink-0 h-screen border-white/10 shadow-2xl transition-transform duration-300 ease-in-out lg:sticky lg:top-0 lg:z-auto">
        
        {{-- Sidebar Logo Header --}}
        <div class="p-5 border-b border-white/10 flex items-center justify-between shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-white p-1 flex items-center justify-center shrink-0 shadow-md">
                    <img src="{{ asset($siteSettings['site_logo'] ?? 'images/logo.png') }}" alt="{{ $siteSettings['site_title'] ?? 'سيما الخليج' }}" class="max-h-full max-w-full object-contain">
                </div>
                <div class="space-y-0.5">
                    <h2 class="font-black text-sm text-white leading-tight">{{ $isEn ? 'Sema Al-Khalij' : 'سيما الخليج' }}</h2>
                    <span class="text-[10px] text-accent font-bold block">{{ $isEn ? 'Admin Control Panel' : 'لوحة التحكم الإدارية' }}</span>
                </div>
            </a>

            {{-- Close Button for Mobile --}}
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-300 hover:text-white p-2 rounded-xl hover:bg-white/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Nav Links (Categorized Sectional Tree Sidebar) --}}
        <nav class="p-4 space-y-4 flex-1 overflow-y-auto">
            
            {{-- Section 1: Dashboard --}}
            <div class="space-y-1">
                <span class="px-3 text-[10px] font-black text-accent tracking-wider uppercase block mb-1">
                    {{ $isEn ? 'MAIN & ANALYTICS' : 'الرئيسية والتحليلات' }}
                </span>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>{{ $isEn ? 'Overview Dashboard' : 'الرئيسية ونظرة عامة' }}</span>
                </a>
                <a href="{{ route('admin.analytics.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.analytics.*') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>{{ $isEn ? 'Analytics & Reports' : 'مركز التحليلات والتقارير' }}</span>
                </a>
            </div>

            {{-- Section 2: Medical Operations --}}
            <div class="space-y-1 pt-2 border-t border-white/10">
                <span class="px-3 text-[10px] font-black text-accent tracking-wider uppercase block mb-1">
                    {{ $isEn ? 'MEDICAL OPERATIONS' : 'العمليات والزيارات الطبية' }}
                </span>
                <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.bookings.*') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ $isEn ? 'Service Bookings & Visits' : 'طلبات الخدمات والزيارات' }}</span>
                </a>
                <a href="{{ route('admin.operations.search') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.operations.search') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>{{ $isEn ? 'Advanced Operational Search' : 'البحث التشغيلي المتقدم' }}</span>
                </a>
            </div>

            {{-- Section 3: CRM & Corporate --}}
            <div class="space-y-1 pt-2 border-t border-white/10">
                <span class="px-3 text-[10px] font-black text-accent tracking-wider uppercase block mb-1">
                    {{ $isEn ? 'CORPORATE & PORTALS' : 'إدارة الشركات والتعاقدات' }}
                </span>
                <a href="{{ route('company.portal') }}" target="_blank" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-xs font-bold transition-all text-medical-200 hover:bg-white/10 hover:text-white">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>{{ $isEn ? 'Corporate Portal' : 'بوابة الشركات والمستفيدين' }}</span>
                </a>
                <a href="{{ route('staff.dashboard') }}" target="_blank" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-xs font-bold transition-all text-medical-200 hover:bg-white/10 hover:text-white">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>{{ $isEn ? 'Medical Staff Portal' : 'بوابة الكادر الطبي' }}</span>
                </a>
            </div>

            {{-- Section 4: Store & Invoicing --}}
            <div class="space-y-1 pt-2 border-t border-white/10">
                <span class="px-3 text-[10px] font-black text-accent tracking-wider uppercase block mb-1">
                    {{ $isEn ? 'STORE & INVOICING' : 'المتجر والفوترة' }}
                </span>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.products.*') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span>{{ $isEn ? 'Products & Devices' : 'إدارة المنتجات والأجهزة' }}</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.orders.*') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>{{ $isEn ? 'Orders & Invoices' : 'طلبات الشراء والفوترة' }}</span>
                </a>
            </div>

            {{-- Section 5: Content & System --}}
            <div class="space-y-1 pt-2 border-t border-white/10">
                <span class="px-3 text-[10px] font-black text-accent tracking-wider uppercase block mb-1">
                    {{ $isEn ? 'CONTENT & SYSTEM' : 'المحتوى والإعدادات والنظام' }}
                </span>
                <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.services.*') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span>{{ $isEn ? 'Medical Services' : 'إدارة الخدمات الطبية' }}</span>
                </a>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>{{ $isEn ? 'CMS & System Settings' : 'معدّل CMS والإعدادات' }}</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.users.*') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span>{{ $isEn ? 'Users & Permissions' : 'إدارة المستخدمين والصلاحيات' }}</span>
                </a>
                <a href="{{ route('admin.audit.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-xs font-bold transition-all {{ request()->routeIs('admin.audit.*') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>{{ $isEn ? 'Audit Logs & Security' : 'سجل العمليات والأمان' }}</span>
                </a>
            </div>
        </nav>

        {{-- Footer Link --}}
        <div class="p-4 border-t border-white/10 shrink-0">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-4 py-3 rounded-2xl bg-white/10 hover:bg-white/20 text-xs font-bold text-white transition-all group">
                <span>{{ $isEn ? 'Return to Website' : 'العودة للواجهة الرئيسية' }}</span>
                <svg class="w-4 h-4 text-accent group-hover:translate-x-[-2px] transition-transform {{ $isEn ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </aside>

    {{-- MAIN CONTENT AREA WITH INDEPENDENT SCROLL --}}
    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
        
        {{-- TOP BAR (FIXED STICKY) --}}
        <header class="bg-white/95 backdrop-blur-md border-b border-gray-200/80 h-16 sm:h-20 px-4 sm:px-8 flex items-center justify-between shrink-0 shadow-sm sticky top-0 z-30">
            
            <div class="flex items-center gap-3 flex-1 max-w-lg">
                {{-- Hamburger Button for Mobile screens --}}
                <button @click="sidebarOpen = true" class="lg:hidden p-2 text-gray-700 hover:bg-gray-100 rounded-xl transition-colors shrink-0">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                {{-- Global Search Bar --}}
                <form action="{{ route('admin.search') }}" method="GET" class="w-full relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $isEn ? 'Search across system...' : 'بحث شامل في النظام...' }}" 
                           class="w-full h-10 sm:h-11 {{ $isEn ? 'pl-9 sm:pl-10 pr-3 sm:pr-4' : 'pr-9 sm:pr-10 pl-3 sm:pl-4' }} bg-gray-50 border border-gray-200/80 rounded-xl sm:rounded-2xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary transition-all shadow-inner">
                    <svg class="w-4 h-4 text-gray-400 absolute top-3 sm:top-3.5 {{ $isEn ? 'left-3 sm:left-3.5' : 'right-3 sm:right-3.5' }} pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </form>
            </div>

            {{-- Admin Profile & Language Badge --}}
            <div class="flex items-center gap-3 shrink-0">
                {{-- Language Switcher in Admin --}}
                @if($isEn)
                    <a href="{{ route('lang.switch', 'ar') }}" title="العربية" class="flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold text-gray-600 hover:text-primary bg-gray-100 rounded-lg border border-gray-200">
                        <span>عر</span>
                    </a>
                @else
                    <a href="{{ route('lang.switch', 'en') }}" title="English" class="flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold text-gray-600 hover:text-primary bg-gray-100 rounded-lg border border-gray-200">
                        <span>EN</span>
                    </a>
                @endif

                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-primary text-white font-black text-xs flex items-center justify-center border border-accent/30 shadow-md shrink-0">
                        {{ mb_substr(auth()->user()->name ?? ($isEn ? 'Admin' : 'مدير'), 0, 2) }}
                    </div>
                    <div class="{{ $isEn ? 'text-left' : 'text-right' }} leading-tight hidden sm:block">
                        <span class="block text-xs font-black text-primary">{{ auth()->user()->name ?? ($isEn ? 'System Admin' : 'مدير النظام') }}</span>
                        <span class="inline-block text-[10px] text-accent font-extrabold bg-accent/10 px-2 py-0.5 rounded-full mt-0.5">Super Admin</span>
                    </div>
                </div>
            </div>
        </header>

        {{-- FLASH MESSAGES --}}
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border-b border-emerald-100 text-emerald-800 text-xs font-bold px-4 sm:px-8 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        {{-- INDEPENDENT SCROLL CONTENT BODY --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto space-y-6 sm:space-y-8">
            {{ $slot }}
        </main>
    </div>

</body>
</html>
