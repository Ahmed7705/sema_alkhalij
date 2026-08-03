<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'لوحة تحكم الأدمن' }} | سيما الخليج للخدمات الطبية</title>
    
    {{-- Google Fonts: Tajawal --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    
    {{-- Tailwind CSS & Chart.js --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0F4C3A',
                        'primary-hover': '#0A372A',
                        accent: '#3CA96B',
                        'accent-hover': '#318F59',
                        surface: '#F6F9F7',
                    },
                    fontFamily: {
                        sans: ['Tajawal', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans text-gray-800 antialiased min-h-screen flex">

    {{-- SIDEBAR NAVIGATION --}}
    <aside class="w-64 bg-gradient-to-b from-[#071f18] via-primary to-[#0a3428] text-white flex flex-col shrink-0 min-h-screen">
        
        {{-- Sidebar Logo Header --}}
        <div class="p-6 border-b border-white/10 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-accent text-white font-black text-xl flex items-center justify-center shadow-md">
                    S
                </div>
                <div class="space-y-0.5">
                    <h2 class="font-black text-sm text-white">سيما الخليج</h2>
                    <span class="text-[10px] text-accent font-bold">لوحة التحكم الإدارية</span>
                </div>
            </div>
        </div>

        {{-- Nav Links --}}
        <nav class="p-4 space-y-1.5 flex-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span>الرئيسية والتحليلات</span>
            </a>

            <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.services.*') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span>إدارة الخدمات الطبية</span>
            </a>

            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.products.*') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span>إدارة المتجر والمنتجات</span>
            </a>

            <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.bookings.*') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>إدارة الحجوزات والزيارات</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.orders.*') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>طلبات الشراء والفوترة</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.settings.*') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>معدّل CMS والإعدادات</span>
            </a>

            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.users.*') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span>إدارة المستخدمين والصلاحيات</span>
            </a>

            <a href="{{ route('admin.audit.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold transition-all {{ request()->routeIs('admin.audit.*') ? 'bg-accent text-white shadow-md' : 'text-medical-200 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                <span>سجل العمليات والأمان (Audit Logs)</span>
            </a>
        </nav>

        {{-- Footer Link --}}
        <div class="p-4 border-t border-white/10">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-bold text-white transition-all">
                <span>زيارة الواجهة العامة للموقع</span>
                <span>↗</span>
            </a>
        </div>
    </aside>

    {{-- MAIN CONTENT WRAPPER --}}
    <div class="flex-1 flex flex-col min-w-0">
        
        {{-- TOP BAR WITH GLOBAL SEARCH --}}
        <header class="bg-white border-b border-gray-200 h-16 px-6 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-4 flex-1 max-w-lg">
                <form action="{{ route('admin.search') }}" method="GET" class="w-full relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="بحث شامل بالموقع (عملاء، طلبات، حجوزات، منتجات)..." 
                           class="w-full h-10 pr-9 pl-4 bg-gray-50 border border-gray-200 rounded-xl text-xs text-gray-800 font-bold focus:outline-none focus:border-primary">
                    <svg class="w-4 h-4 text-gray-400 absolute top-3 right-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </form>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3 text-left">
                    <div class="w-9 h-9 rounded-xl bg-primary text-white font-black text-sm flex items-center justify-center">
                        {{ mb_substr(auth()->user()->name ?? 'م', 0, 2) }}
                    </div>
                    <div class="text-right">
                        <span class="block text-xs font-bold text-gray-800">{{ auth()->user()->name ?? 'المدير' }}</span>
                        <span class="block text-[10px] text-accent font-extrabold">Super Admin</span>
                    </div>
                </div>
            </div>
        </header>

        {{-- FLASH MESSAGES --}}
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border-b border-emerald-100 text-emerald-700 text-xs font-bold px-6 flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <span>✓</span>
            </div>
        @endif

        {{-- CONTENT BODY --}}
        <main class="flex-1 p-6 overflow-y-auto space-y-6">
            {{ $slot }}
        </main>
    </div>

</body>
</html>
