
@php
    $isEn = app()->getLocale() == 'en';

    $productTitles = [
        'كرسي متحرك طبي خفيف الوزن قابل للطي' => 'Lightweight Folding Medical Wheelchair',
        'سرير طبي كهربائي 3 حركات للرعاية المنزلية' => '3-Function Electric Medical Bed',
        'جهاز استنشاق البخار الطبي (نيبولايزر) للربو والحساسية' => 'Medical Respiratory Nebulizer Inhaler',
        'جهاز قياس ضغط الدم الرقمي الذكي' => 'Smart Digital Blood Pressure Monitor',
        'ميزان حرارة عن بعد بالأشعة تحت الحمراء (بدون تلامس)' => 'Non-Contact Infrared Forehead Thermometer',
    ];

    $serviceTitles = [
        'الرعاية الصحية المنزلية' => 'Home Healthcare Programs',
        'الزيارات الطبية المنزلية' => 'Home Medical Doctor Visits',
        'التمريض المنزلي 24/7' => '24/7 Home Nursing Care',
        'العلاج الطبيعي والتأهيل' => 'Physical Therapy & Rehabilitation',
        'سحب العينات المنزلي' => 'Home Blood & Sample Collection',
    ];

    $serviceDescs = [
        'برامج مخصصة لكبار السن وأصحاب الأمراض المزمنة في بيئة منزلية دافئة وآمنة.' => 'Dedicated programs for seniors and chronic care in a safe home environment.',
        'أطباء واستشاريون لمعاينة المريض، التشخيص الدقيق، ووصف العلاج في المنزل.' => 'Doctors and consultants for home examination, diagnosis, and treatment.',
        'رعاية تمريضية متواصلة، متابعة العلامات الحيوية، العناية بالجروح والمغذيات.' => 'Continuous nursing care, vital signs monitoring, wound care, and IV drips.',
        'جلسات تأهيلية مخصصة لما بعد العمليات والجلطات وإصابات العظام والعضلات.' => 'Post-op, stroke, and musculoskeletal rehabilitation sessions at home.',
        'أخصائي سحب عينات يحضر لمنزلك بأدوات معقمة مع نتائج إلكترونية سريعة.' => 'Sterile lab sample collection specialist at your home with fast digital results.',
    ];
@endphp
<x-admin-layout title="{{ $isEn ? 'Analytics & Financial Reports System' : 'نظام التحليلات والتقارير المالية' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Advanced Analytics & Financial Reports Center' : 'مركز التحليلات المتقدمة والتقارير الشاملة' }}</x-slot>

    <div class="space-y-8 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
        
        {{-- TOP FILTER BAR & DATE RANGE SELECTION --}}
        <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="font-black text-lg text-primary flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span>{{ $isEn ? 'Performance Analytics & Financial Reports' : 'لوحة تحليلات الأداء والتقارير المالية' }}</span>
                </h3>
                <p class="text-xs text-gray-500 mt-0.5">{{ $isEn ? 'Select time period to filter sales, visitors, bookings, and product stats' : 'اختر الفترة الزمنية لتصفية إحصائيات المبيعات، الزوار، الحجوزات، والمنتجات' }}</p>
            </div>

            {{-- Filter Form --}}
            <form action="{{ route('admin.analytics.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <div class="flex items-center gap-1 bg-gray-100 p-1 rounded-2xl text-xs font-bold">
                    <a href="{{ route('admin.analytics.index', ['period' => 'today']) }}" class="px-3 py-2 rounded-xl transition-all {{ $data['period'] == 'today' ? 'bg-primary text-white shadow' : 'text-gray-600 hover:text-primary' }}">{{ $isEn ? 'Today' : 'اليوم' }}</a>
                    <a href="{{ route('admin.analytics.index', ['period' => 'weekly']) }}" class="px-3 py-2 rounded-xl transition-all {{ $data['period'] == 'weekly' ? 'bg-primary text-white shadow' : 'text-gray-600 hover:text-primary' }}">{{ $isEn ? 'Weekly' : 'أسبوعي' }}</a>
                    <a href="{{ route('admin.analytics.index', ['period' => 'monthly']) }}" class="px-3 py-2 rounded-xl transition-all {{ $data['period'] == 'monthly' ? 'bg-primary text-white shadow' : 'text-gray-600 hover:text-primary' }}">{{ $isEn ? 'Monthly' : 'شهري' }}</a>
                    <a href="{{ route('admin.analytics.index', ['period' => 'yearly']) }}" class="px-3 py-2 rounded-xl transition-all {{ $data['period'] == 'yearly' ? 'bg-primary text-white shadow' : 'text-gray-600 hover:text-primary' }}">{{ $isEn ? 'Yearly' : 'سنوي' }}</a>
                </div>

                {{-- Custom Date Picker Inputs --}}
                <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 p-1.5 rounded-2xl text-xs">
                    <input type="hidden" name="period" value="custom">
                    <input type="date" name="start_date" value="{{ $data['startDate'] }}" class="bg-transparent border-0 font-bold text-gray-700 text-xs focus:outline-none">
                    <span class="text-gray-400 font-bold">{{ $isEn ? 'to' : 'إلى' }}</span>
                    <input type="date" name="end_date" value="{{ $data['endDate'] }}" class="bg-transparent border-0 font-bold text-gray-700 text-xs focus:outline-none">
                    <button type="submit" class="bg-accent hover:bg-accent-hover text-white px-3 py-1.5 rounded-xl font-bold transition-colors">
                        {{ $isEn ? 'Apply' : 'تطبيق' }}
                    </button>
                </div>
            </form>
        </div>

        {{-- 1. DASHBOARD METRICS GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- Total Revenue --}}
            <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm space-y-3 relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-gray-500">{{ $isEn ? 'Total Compound Revenue' : 'إجمالي الإيرادات المركبة' }}</span>
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($data['metrics']['totalRevenue'], 2) }} <span class="text-xs font-bold text-accent">{{ $isEn ? 'SAR' : 'ر.س' }}</span></div>
                    <p class="text-[11px] text-gray-400">{{ $isEn ? 'Medical Services:' : 'خدمات طبية:' }} {{ number_format($data['metrics']['totalBookingRevenue'], 0) }} | {{ $isEn ? 'Store:' : 'متجر:' }} {{ number_format($data['metrics']['totalOrderRevenue'], 0) }}</p>
                </div>
            </div>

            {{-- Store Orders & Average Order Value (AOV) --}}
            <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-gray-500">{{ $isEn ? 'Average Order Value (AOV)' : 'متوسط قيمة الطلب (AOV)' }}</span>
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($data['metrics']['averageOrderValue'], 2) }} <span class="text-xs font-bold text-accent">{{ $isEn ? 'SAR' : 'ر.س' }}</span></div>
                    <p class="text-[11px] text-gray-400">{{ $isEn ? 'Store Orders Count:' : 'عدد طلبيات المتجر:' }} {{ $data['metrics']['totalOrdersCount'] }} {{ $isEn ? 'orders' : 'طلب' }}</p>
                </div>
            </div>

            {{-- Visitors Analytics --}}
            <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-gray-500">{{ $isEn ? 'Visitors & Unique Visits' : 'الزوار والزيارات الفريدة' }}</span>
                    <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">{{ number_format($data['metrics']['totalVisitors']) }} <span class="text-xs font-bold text-gray-400">{{ $isEn ? 'visitors' : 'زائر' }}</span></div>
                    <p class="text-[11px] text-gray-400">{{ $isEn ? 'Unique Visitors:' : 'زيارات فريدة (Unique):' }} {{ number_format($data['metrics']['uniqueVisitors']) }}</p>
                </div>
            </div>

            {{-- User Retention (New vs Returning) --}}
            <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-extrabold text-gray-500">{{ $isEn ? 'New & Returning Users' : 'المستخدمين الجدد والراجعين' }}</span>
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                </div>
                <div class="space-y-1">
                    <div class="text-2xl font-black text-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">+{{ $data['metrics']['newUsers'] }} <span class="text-xs font-bold text-accent">{{ $isEn ? 'new users' : 'مستخدم جديد' }}</span></div>
                    <p class="text-[11px] text-gray-400">{{ $isEn ? 'Returning Users:' : 'مستخدمين عائدين (Returning):' }} {{ $data['metrics']['returningUsers'] }}</p>
                </div>
            </div>
        </div>

        {{-- 2. CHARTS SECTION (REVENUE TREND & BOOKINGS OVERVIEW) --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Revenue Trend Chart --}}
            <div class="lg:col-span-2 bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
                <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                    <div>
                        <h4 class="font-black text-base text-primary">{{ $isEn ? 'Comparative Revenue Analytics Chart' : 'المخطط البياني المقارن للإيرادات' }}</h4>
                        <p class="text-xs text-gray-400">{{ $isEn ? 'Distribution of sales performance between home medical services and store supplies' : 'توزيع أداء المبيعات بين الخدمات الطبية المنزلية ومستلزمات المتجر' }}</p>
                    </div>
                    <span class="text-xs font-bold text-accent bg-accent/10 px-3 py-1 rounded-full">{{ $isEn ? 'Live Update' : 'تحديث فوري' }}</span>
                </div>
                
                <div class="h-72 w-full">
                    <canvas id="analyticsRevenueChart"></canvas>
                </div>
            </div>

            {{-- Bookings Status Distribution --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-gray-200 shadow-sm space-y-6">
                <div class="border-b border-gray-100 pb-4">
                    <h4 class="font-black text-base text-primary">{{ $isEn ? 'Bookings Status Analytics' : 'تحليلات حالة الحجوزات' }}</h4>
                    <p class="text-xs text-gray-400">{{ $isEn ? 'Total medical bookings grouped by status' : 'إجمالي الحجوزات الطبية حسب الحالة' }}</p>
                </div>

                <div class="space-y-4">
                    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-800">{{ $isEn ? 'Completed Bookings' : 'الحجوزات المكتملة' }}</span>
                        <span class="text-lg font-black text-emerald-700 dir-ltr">{{ $data['bookingsStatus']['completed'] }}</span>
                    </div>

                    <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-blue-800">{{ $isEn ? 'Confirmed Bookings' : 'الحجوزات المؤكدة' }}</span>
                        <span class="text-lg font-black text-blue-700 dir-ltr">{{ $data['bookingsStatus']['confirmed'] }}</span>
                    </div>

                    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-amber-800">{{ $isEn ? 'Pending & Processing' : 'قيد الانتظار والمعالجة' }}</span>
                        <span class="text-lg font-black text-amber-700 dir-ltr">{{ $data['bookingsStatus']['pending'] }}</span>
                    </div>

                    <div class="p-4 bg-rose-50 rounded-2xl border border-rose-100 flex items-center justify-between">
                        <span class="text-xs font-bold text-rose-800">{{ $isEn ? 'Cancelled Bookings' : 'الحجوزات المأخوذة أو الملقاة' }}</span>
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
                        <span>{{ $isEn ? 'Top Products & Low Stock Alerts' : 'أفضل المنتجات وتنبيهات نواقص المخزون' }}</span>
                    </h4>
                    <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-full">{{ $isEn ? 'Stock Alert' : 'تنبه مخزون' }}</span>
                </div>

                {{-- Low Stock Items Alert --}}
                @if(count($data['products']['lowStock']) > 0)
                    <div class="p-4 bg-rose-50 border border-rose-200/80 rounded-2xl space-y-2">
                        <span class="text-xs font-black text-rose-800 block">{{ $isEn ? '⚠️ Products Near Stock Out (Critical Inventory):' : '⚠️ منتجات على وشك النفاد (مخزون حرج):' }}</span>
                        <div class="flex flex-wrap gap-2">
                            @foreach($data['products']['lowStock'] as $lowItem)
                                <span class="px-2.5 py-1 bg-white rounded-lg border border-rose-200 text-[11px] font-bold text-rose-700">
                                    {{ $isEn ? ($productTitles[$lowItem->title] ?? $lowItem->title) : $lowItem->title }} ({{ $isEn ? 'Remaining:' : 'المتبقي:' }} {{ $lowItem->stock }})
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Best Selling Products Table --}}
                <div class="space-y-3">
                    <span class="text-xs font-black text-gray-700 block">{{ $isEn ? 'Top Selling Medical Products & Devices:' : 'أفضل المنتجات والأجهزة الطبية مبيعاً:' }}</span>
                    <div class="space-y-2">
                        @foreach($data['products']['bestSelling'] as $prod)
                            <div class="p-3 bg-surface rounded-2xl border border-gray-100 flex items-center justify-between text-xs">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-white border border-gray-200 flex items-center justify-center p-1">
                                        <img src="{{ asset('images/prod-bp.png') }}" class="max-h-full object-contain">
                                    </div>
                                    <div>
                                        <strong class="text-primary font-black block">{{ $isEn ? ($productTitles[$prod->title] ?? $prod->title) : $prod->title }}</strong>
                                        <span class="text-gray-400 text-[10px]">SKU: {{ $prod->sku }}</span>
                                    </div>
                                </div>
                                <div class="{{ $isEn ? 'text-right' : 'text-left' }}">
                                    <span class="font-black text-primary block dir-ltr">{{ number_format($prod->price, 0) }} {{ $isEn ? 'SAR' : 'ر.س' }}</span>
                                    <span class="text-[10px] font-bold text-emerald-600">{{ $isEn ? 'In Stock:' : 'متوفر بالمستودع:' }} {{ $prod->stock }}</span>
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
                        <span>{{ $isEn ? 'Most Booked Medical Services' : 'أكثر الخدمات الطبية طلباً وحجزاً' }}</span>
                    </h4>
                    <span class="text-xs font-bold text-primary bg-primary/10 px-2.5 py-1 rounded-full">{{ $isEn ? 'Top Demand' : 'أعلى طلباً' }}</span>
                </div>

                <div class="space-y-3">
                    @foreach($data['services']['mostBooked'] as $serv)
                        <div class="p-3.5 bg-surface rounded-2xl border border-gray-100 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center font-bold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <strong class="text-primary font-black block text-sm">{{ $isEn ? ($serviceTitles[$serv->title] ?? $serv->title) : $serv->title }}</strong>
                                    <span class="text-gray-500 text-[11px] block">{{ $isEn ? ($serviceDescs[$serv->short_description] ?? $serv->short_description) : $serv->short_description }}</span>
                                </div>
                            </div>
                            <div class="{{ $isEn ? 'text-right' : 'text-left' }} shrink-0">
                                <span class="font-black text-accent block text-sm dir-ltr">{{ number_format($serv->price, 0) }} {{ $isEn ? 'SAR' : 'ر.س' }}</span>
                                <span class="text-[10px] text-gray-400 font-bold">{{ $serv->duration_minutes }} {{ $isEn ? 'mins' : 'دقيقة' }}</span>
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
                            label: "{{ $isEn ? 'Medical Services Revenue (SAR)' : 'إيرادات الخدمات الطبية (ر.س)' }}",
                            data: servicesData,
                            borderColor: '#006C35',
                            backgroundColor: 'rgba(0, 108, 53, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 4,
                            pointBackgroundColor: '#006C35',
                        },
                        {
                            label: "{{ $isEn ? 'Medical Store Sales (SAR)' : 'مبيعات المتجر الطبي (ر.س)' }}",
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
                            rtl: {{ $isEn ? 'false' : 'true' }},
                            labels: {
                                font: { family: 'Tajawal', size: 12, weight: 'bold' }
                            }
                        },
                        tooltip: {
                            rtl: {{ $isEn ? 'false' : 'true' }},
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
