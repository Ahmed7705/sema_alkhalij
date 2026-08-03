<x-admin-layout title="نظام التحليلات والتقارير - Phase 13">
    <x-slot name="headerTitle">مركز التحليلات المتقدمة والتقارير الشاملة - Phase 13</x-slot>

    <div class="space-y-8 text-right">
        
        {{-- TOP FILTER BAR & DATE RANGE SELECTION --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="font-black text-lg text-primary flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>لوحة تحليلات الأداء والتقارير المالية</span>
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">اختر الفترة الزمنية لتصفية إحصائيات المبيعات، الزوار، الحجوزات، والمنتجات</p>
            </div>

            {{-- Filter Form --}}
            <form action="{{ route('admin.analytics.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <div class="flex items-center gap-1 bg-gray-100 p-1 rounded-2xl text-xs font-bold">
                    <a href="{{ route('admin.analytics.index', ['period' => 'today']) }}" class="px-3 py-2 rounded-xl transition-all {{ $data['period'] == 'today' ? 'bg-primary text-white shadow' : 'text-gray-600 hover:text-primary' }}">اليوم</a>
                    <a href="{{ route('admin.analytics.index', ['period' => 'weekly']) }}" class="px-3 py-2 rounded-xl transition-all {{ $data['period'] == 'weekly' ? 'bg-primary text-white shadow' : 'text-gray-600 hover:text-primary' }}">أسبوعي</a>
                    <a href="{{ route('admin.analytics.index', ['period' => 'monthly']) }}" class="px-3 py-2 rounded-xl transition-all {{ $data['period'] == 'monthly' ? 'bg-primary text-white shadow' : 'text-gray-600 hover:text-primary' }}">شهري</a>
                    <a href="{{ route('admin.analytics.index', ['period' => 'yearly']) }}" class="px-3 py-2 rounded-xl transition-all {{ $data['period'] == 'yearly' ? 'bg-primary text-white shadow' : 'text-gray-600 hover:text-primary' }}">سنوي</a>
                </div>

                {{-- Custom Date Picker Inputs --}}
                <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 p-1.5 rounded-2xl text-xs">
                    <input type="hidden" name="period" value="custom">
                    <input type="date" name="start_date" value="{{ $data['startDate'] }}" class="bg-transparent border-0 font-bold text-gray-700 text-xs focus:outline-none">
                    <span class="text-gray-400 font-bold">إلى</span>
                    <input type="date" name="end_date" value="{{ $data['endDate'] }}" class="bg-transparent border-0 font-bold text-gray-700 text-xs focus:outline-none">
                    <button type="submit" class="bg-accent hover:bg-accent-hover text-white px-3 py-1.5 rounded-xl font-bold transition-colors">
                        تطبيق
                    </button>
                </div>
            </form>
        </div>

        {{-- 1. DASHBOARD METRICS GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- Total Revenue --}}
            <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm space-y-3 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-gray-500">إجمالي الإيرادات المركبة</span>
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-black text-primary dir-ltr text-right">{{ number_format($data['metrics']['totalRevenue'], 2) }} <span class="text-xs font-bold text-accent">ر.س</span></div>
                    <p class="text-[11px] text-gray-400">خدمات طبية: {{ number_format($data['metrics']['totalBookingRevenue'], 0) }} | متجر: {{ number_format($data['metrics']['totalOrderRevenue'], 0) }}</p>
                </div>
            </div>

            {{-- Store Orders & Average Order Value (AOV) --}}
            <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-gray-500">متوسط قيمة الطلب (AOV)</span>
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-black text-primary dir-ltr text-right">{{ number_format($data['metrics']['averageOrderValue'], 2) }} <span class="text-xs font-bold text-accent">ر.س</span></div>
                    <p class="text-[11px] text-gray-400">عدد طلبيات المتجر: {{ $data['metrics']['totalOrdersCount'] }} طلب</p>
                </div>
            </div>

            {{-- Visitors Analytics --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-gray-500">الزوار والزيارات الفريدة</span>
                    <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-black text-primary dir-ltr text-right">{{ number_format($data['metrics']['totalVisitors']) }} <span class="text-xs font-bold text-gray-400">زائر</span></div>
                    <p class="text-[11px] text-gray-400">زيارات فريدة (Unique): {{ number_format($data['metrics']['uniqueVisitors']) }}</p>
                </div>
            </div>

            {{-- User Retention (New vs Returning) --}}
            <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-gray-500">المستخدمين الجدد والراجعين</span>
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-black text-primary dir-ltr text-right">+{{ $data['metrics']['newUsers'] }} <span class="text-xs font-bold text-accent">مستخدم جديد</span></div>
                    <p class="text-[11px] text-gray-400">مستخدمين عائدين (Returning): {{ $data['metrics']['returningUsers'] }}</p>
                </div>
            </div>
        </div>

        {{-- 2. CHARTS SECTION (REVENUE TREND & BOOKINGS OVERVIEW) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Revenue Trend Chart --}}
            <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <div>
                        <h4 class="font-black text-base text-primary">المخطط البياني المقارن للإيرادات</h4>
                        <p class="text-xs text-gray-400">توزيع أداء المبيعات بين الخدمات الطبية المنزلية ومستلزمات المتجر</p>
                    </div>
                    <span class="text-xs font-bold text-accent bg-accent/10 px-3 py-1 rounded-full">تحديث فوري</span>
                </div>
                
                <div class="h-72 w-full">
                    <canvas id="analyticsRevenueChart"></canvas>
                </div>
            </div>

            {{-- Bookings Status Distribution --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
                <div class="border-b border-gray-100 pb-4">
                    <h4 class="font-black text-base text-primary">تحليلات حالة الحجوزات</h4>
                    <p class="text-xs text-gray-400">إجمالي الحجوزات الطبية حسب الحالة</p>
                </div>

                <div class="space-y-4">
                    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-800">الحجوزات المكتملة</span>
                        <span class="text-lg font-black text-emerald-700 dir-ltr">{{ $data['bookingsStatus']['completed'] }}</span>
                    </div>

                    <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-blue-800">الحجوزات المؤكدة</span>
                        <span class="text-lg font-black text-blue-700 dir-ltr">{{ $data['bookingsStatus']['confirmed'] }}</span>
                    </div>

                    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-amber-800">قيد الانتظار والمعالجة</span>
                        <span class="text-lg font-black text-amber-700 dir-ltr">{{ $data['bookingsStatus']['pending'] }}</span>
                    </div>

                    <div class="p-4 bg-rose-50 rounded-2xl border border-rose-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-rose-800">الحجوزات المأخوذة أو الملقاة</span>
                        <span class="text-lg font-black text-rose-700 dir-ltr">{{ $data['bookingsStatus']['cancelled'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. PRODUCTS & SERVICES ANALYTICS REPORTS --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- Top Products & Low Stock Alerts --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <h4 class="font-black text-base text-primary flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span>أفضل المنتجات وتنبيهات نواقص المخزون</span>
                    </h4>
                    <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-full">تنبه مخزون</span>
                </div>

                {{-- Low Stock Items Alert --}}
                @if(count($data['products']['lowStock']) > 0)
                    <div class="p-4 bg-rose-50 border border-rose-200/80 rounded-2xl space-y-2">
                        <span class="text-xs font-black text-rose-800 block">⚠️ منتجات على وشك النفاد (مخزون حرج):</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach($data['products']['lowStock'] as $lowItem)
                                <span class="px-2.5 py-1 bg-white rounded-lg border border-rose-200 text-[11px] font-bold text-rose-700">
                                    {{ $lowItem->title }} (المتبقي: {{ $lowItem->stock }})
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Best Selling Products Table --}}
                <div class="space-y-3">
                    <span class="text-xs font-black text-gray-700 block">أفضل المنتجات والأجهزة الطبية مبيعاً:</span>
                    <div class="space-y-2">
                        @foreach($data['products']['bestSelling'] as $prod)
                            <div class="p-3 bg-surface rounded-2xl border border-gray-100 flex items-center justify-between text-xs">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-white border border-gray-200 flex items-center justify-center p-1">
                                        <img src="{{ asset('images/prod-bp.png') }}" class="max-h-full object-contain">
                                    </div>
                                    <div>
                                        <strong class="text-primary font-black block">{{ $prod->title }}</strong>
                                        <span class="text-gray-400 text-[10px]">SKU: {{ $prod->sku }}</span>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <span class="font-black text-primary block dir-ltr">{{ number_format($prod->price, 0) }} ر.س</span>
                                    <span class="text-[10px] font-bold text-emerald-600">متوفر بالمستودع: {{ $prod->stock }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Top Services & Most Booked Reports --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <h4 class="font-black text-base text-primary flex items-center gap-2">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <span>أكثر الخدمات الطبية طلباً وحجزاً</span>
                    </h4>
                    <span class="text-xs font-bold text-primary bg-primary/10 px-2.5 py-1 rounded-full">أعلى طلباً</span>
                </div>

                <div class="space-y-3">
                    @foreach($data['services']['mostBooked'] as $serv)
                        <div class="p-3.5 bg-surface rounded-2xl border border-gray-100 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <strong class="text-primary font-black block text-sm">{{ $serv->title }}</strong>
                                    <span class="text-gray-500 text-[11px] block">{{ $serv->short_description }}</span>
                                </div>
                            </div>
                            <div class="text-left shrink-0">
                                <span class="font-black text-accent block text-sm dir-ltr">{{ number_format($serv->price, 0) }} ر.س</span>
                                <span class="text-[10px] text-gray-400 font-bold">{{ $serv->duration_minutes }} دقيقة</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

    {{-- CHART.JS INITIALIZATION --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('analyticsRevenueChart');
            if (!ctx) return;

            const chartLabels = {!! json_encode($data['charts']['monthlyRevenue']['labels']) !!};
            const servicesData = {!! json_encode($data['charts']['monthlyRevenue']['services']) !!};
            const storeData = {!! json_encode($data['charts']['monthlyRevenue']['store']) !!};

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [
                        {
                            label: 'إيرادات الخدمات الطبية (ر.س)',
                            data: servicesData,
                            borderColor: '#0F4C3A',
                            backgroundColor: 'rgba(15, 76, 58, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 4,
                            pointBackgroundColor: '#0F4C3A',
                        },
                        {
                            label: 'مبيعات المتجر الطبي (ر.س)',
                            data: storeData,
                            borderColor: '#3CA96B',
                            backgroundColor: 'rgba(60, 169, 107, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 4,
                            pointBackgroundColor: '#3CA96B',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            rtl: true,
                            labels: {
                                font: { family: 'Tajawal', size: 12, weight: 'bold' }
                            }
                        },
                        tooltip: {
                            rtl: true,
                            bodyFont: { family: 'Tajawal' },
                            titleFont: { family: 'Tajawal', weight: 'bold' }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#E2E8F0' },
                            ticks: { font: { family: 'Tajawal', size: 10 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Tajawal', size: 11, weight: 'bold' } }
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
