@php
    $isEn = app()->getLocale() == 'en';
@endphp
<x-admin-layout title="{{ $isEn ? 'Live Analytics & Statistics Dashboard' : 'لوحة التحليلات والإحصائيات المباشرة' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Live Analytics & Statistics Dashboard' : 'لوحة التحليلات والإحصائيات المباشرة' }}</x-slot>

    {{-- STATS CARDS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        {{-- Total Revenue --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500">{{ $isEn ? 'Total Revenue (Services + Store)' : 'إجمالي الإيرادات (خدمات + منتجات)' }}</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold border border-emerald-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                {{ number_format($totalRevenue, 2) }} <span class="text-xs font-bold text-accent">{{ $isEn ? 'SAR' : 'ر.س' }}</span>
            </div>
            <div class="text-[11px] text-gray-400 font-bold flex items-center gap-1">
                <span>{{ $isEn ? 'Services:' : 'خدمات:' }} {{ number_format($servicesRevenue, 0) }} {{ $isEn ? 'SAR' : 'ر.س' }}</span>
                <span>•</span>
                <span>{{ $isEn ? 'Store:' : 'منتجات:' }} {{ number_format($ordersRevenue, 0) }} {{ $isEn ? 'SAR' : 'ر.س' }}</span>
            </div>
        </div>

        {{-- Bookings Count --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500">{{ $isEn ? 'Total Medical Bookings' : 'إجمالي الحجوزات والزيارات' }}</span>
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold border border-teal-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                {{ $totalBookingsCount }} <span class="text-xs font-bold text-gray-400">{{ $isEn ? 'visits' : 'زيارة' }}</span>
            </div>
            <div class="text-[11px] text-emerald-600 font-bold">
                {{ $isEn ? 'Home Medical Visits & Consultations' : 'حجوزات الزيارات الطبية الكشفية' }}
            </div>
        </div>

        {{-- Orders Count --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500">{{ $isEn ? 'Total Store Orders' : 'إجمالي طلبات المتجر' }}</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold border border-blue-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                {{ $totalOrdersCount }} <span class="text-xs font-bold text-gray-400">{{ $isEn ? 'orders' : 'طلب' }}</span>
            </div>
            <div class="text-[11px] text-blue-600 font-bold">
                {{ $isEn ? 'Medical Devices & Supplies Orders' : 'طلبات الأجهزة والمستلزمات الطبية' }}
            </div>
        </div>

        {{-- Total Users --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-500">{{ $isEn ? 'Registered Customers' : 'المستخدمين المسجلين' }}</span>
                <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold border border-purple-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                {{ $totalUsersCount }} <span class="text-xs font-bold text-gray-400">{{ $isEn ? 'users' : 'عميل' }}</span>
            </div>
            <div class="text-[11px] text-purple-600 font-bold">
                {{ $isEn ? 'Registered Patient & Customer Accounts' : 'حسابات المرضى والعملاء المسجلة' }}
            </div>
        </div>

    </div>

    {{-- CHART.JS LIVE REVENUE GRAPH --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
        <h3 class="font-black text-sm text-primary {{ $isEn ? 'text-left' : 'text-right' }}">
            {{ $isEn ? 'Monthly Revenue Analytics Chart (Services & Store)' : 'المخطط البياني للإيرادات الشهرية (خدمات ومبيعات متجر)' }}
        </h3>
        <div class="h-64 relative">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- RECENT TABLES GRID --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        {{-- Recent Bookings --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Recent Medical Home Bookings' : 'أحدث الحجوزات الطبية المنزلية' }}</h3>
                <a href="{{ route('admin.bookings.index') }}" class="text-xs font-bold text-accent hover:underline flex items-center gap-1">
                    <span>{{ $isEn ? 'View All' : 'عرض الكل' }}</span>
                    <svg class="w-3.5 h-3.5 {{ $isEn ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
            </div>

            <div class="space-y-3">
                @foreach($recentBookings as $b)
                    <div class="p-3 bg-surface rounded-xl border border-gray-100 flex items-center justify-between text-xs">
                        <div class="space-y-1">
                            <strong class="text-primary font-black block">{{ $b->service->title ?? ($isEn ? 'Home Visit' : 'زيارة منزلية') }}</strong>
                            <span class="text-gray-500 block">{{ $isEn ? 'Date:' : 'الموعد:' }} {{ $b->booking_date }} ({{ $b->booking_time }})</span>
                        </div>
                        <div class="text-left font-black text-accent dir-ltr">
                            {{ number_format($b->total_price, 0) }} {{ $isEn ? 'SAR' : 'ر.س' }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h3 class="font-black text-sm text-primary">{{ $isEn ? 'Recent Store & Product Orders' : 'أحدث طلبات المتجر والمنتجات' }}</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-accent hover:underline flex items-center gap-1">
                    <span>{{ $isEn ? 'View All' : 'عرض الكل' }}</span>
                    <svg class="w-3.5 h-3.5 {{ $isEn ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
            </div>

            <div class="space-y-3">
                @foreach($recentOrders as $o)
                    <div class="p-3 bg-surface rounded-xl border border-gray-100 flex items-center justify-between text-xs">
                        <div class="space-y-1">
                            <strong class="text-primary font-black block">{{ $isEn ? 'Order #' : 'طلب رقم:' }} {{ $o->order_number }}</strong>
                            <span class="text-gray-500 block">{{ $isEn ? 'Customer:' : 'العميل:' }} {{ $o->customer_name ?? ($isEn ? 'Customer' : 'عميل') }} ({{ $o->city }})</span>
                        </div>
                        <div class="text-left font-black text-accent dir-ltr">
                            {{ number_format($o->total_price, 0) }} {{ $isEn ? 'SAR' : 'ر.س' }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- CHART.JS SCRIPT INITIALIZATION --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartMonths),
                    datasets: [
                        {
                            label: "{{ $isEn ? 'Services Revenue (SAR)' : 'إيرادات الحجوزات والخدمات (ر.س)' }}",
                            data: @json($chartDataServices),
                            borderColor: '#0F4C3A',
                            backgroundColor: 'rgba(15, 76, 58, 0.1)',
                            fill: true,
                            tension: 0.3
                        },
                        {
                            label: "{{ $isEn ? 'Store Products Revenue (SAR)' : 'إيرادات المتجر والمنتجات (ر.س)' }}",
                            data: @json($chartDataProducts),
                            borderColor: '#3CA96B',
                            backgroundColor: 'rgba(60, 169, 107, 0.1)',
                            fill: true,
                            tension: 0.3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' }
                    }
                }
            });
        });
    </script>

</x-admin-layout>
