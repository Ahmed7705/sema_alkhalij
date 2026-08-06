<x-app-layout title="{{ app()->getLocale()=='en' ? 'Medical Blog & Health Guides | Sema Al-Khalij' : 'المدونة الطبية والإرشادية | سيما الخليج' }}">

    @php
        $isEn = app()->getLocale() == 'en';

        $featured = [
            'badge' => $isEn ? 'Featured Article' : 'المقال المميز',
            'cat' => $isEn ? 'Elderly Care' : 'رعاية كبار السن',
            'date' => $isEn ? 'July 15, 2026' : '15 يوليو 2026',
            'read_time' => $isEn ? '5 min read' : 'قراءة 5 دقائق',
            'title' => $isEn ? 'Importance of Home Healthcare for Seniors and Maintaining Their Well-being' : 'أهمية الرعاية الصحية المنزلية لكبار السن وكيف تحافظ على سلامتهم النفسية والجسدية',
            'excerpt' => $isEn ? 'Home nursing provides a comfortable environment boosting senior mental stability, reducing hospital admissions.' : 'يوفر التمريض المنزلي بيئة مريحة تعزز الاستقرار النفسي للمسنين، حيث تساهم المتابعة الطبية اليومية في الاكتشاف المبكر للمضاعفات والحد من مخاطر التنويم المستشفي.',
            'author' => $isEn ? 'Dr. Abdulrahman Al-Ghamdi' : 'د. عبد الرحمن الغامدي',
            'read_btn' => $isEn ? 'Read Article' : 'اقرأ المقال',
        ];

        $posts = [
            [
                'cat' => 'elderly',
                'cat_label' => $isEn ? 'Elderly Care' : 'رعاية كبار السن',
                'img' => 'blog-elderly.png',
                'title' => $isEn ? 'How to Choose the Right Home Nursing Program for Elderly Family Members' : 'كيف تختار برنامج التمريض المنزلي المناسب لأحد كبار السن من أفراد أسرتك؟',
                'excerpt' => $isEn ? 'Essential factors to consider when selecting home nursing staff for safety and professionalism.' : 'عوامل أساسية يجب مراعاتها عند اختيار الكادر التمريضي المنزلي لضمان الأمان والاحترافية.',
                'date' => '2026-07-20',
                'author' => $isEn ? 'Dr. Sarah Al-Shehri' : 'د. سارة الشهري',
                'time' => $isEn ? '4 min read' : '4 دقائق'
            ],
            [
                'cat' => 'prevention',
                'cat_label' => $isEn ? 'Prevention & Home Health' : 'وقاية وصحة منزلية',
                'img' => 'blog-diabetes.png',
                'title' => $isEn ? 'Tips for Diabetes Prevention and Home Blood Glucose Monitoring' : 'نصائح وإرشادات الوقاية من السكري ومتابعة مستويات السكر بالمنزل',
                'excerpt' => $isEn ? 'Practical daily steps to maintain balanced blood sugar levels and accurate self-testing.' : 'خطوات عملية يومية للمحافظة على مستويات السكر المتوازنة وإرشادات الفحص الذاتي الدقيق.',
                'date' => '2026-07-18',
                'author' => $isEn ? 'Dr. Khalid Al-Mutairi' : 'د. خالد المطيري',
                'time' => $isEn ? '6 min read' : '6 دقائق'
            ],
            [
                'cat' => 'physio',
                'cat_label' => $isEn ? 'Physical Therapy' : 'علاج طبيعي',
                'img' => 'service-physio.png',
                'title' => $isEn ? 'Benefits of Post-Surgery Home Physical Therapy and Rehabilitation' : 'فوائد جلسات العلاج الطبيعي والتأهيل الحركي بالمنزل بعد العمليات الجراحية',
                'excerpt' => $isEn ? 'How home rehab sessions help regain mobility faster and safely without commute stress.' : 'كيف تساعد الجلسات المنزلية في استعادة الحركة بشكل أسرع وآمن بدون إجهاد للتنقل.',
                'date' => '2026-07-12',
                'author' => $isEn ? 'Physio. Ahmed Al-Otaibi' : 'أخصائي أحمد العتيبي',
                'time' => $isEn ? '5 min read' : '5 دقائق'
            ],
            [
                'cat' => 'labs',
                'cat_label' => $isEn ? 'Tests & Genetics' : 'فحوصات وجينات',
                'img' => 'service-dna.png',
                'title' => $isEn ? 'Guide to Early Genetic Testing and Family Inherited Disease Prevention' : 'دليل الفحوصات الجينية المبكرة والوقاية من الأمراض الوراثية العائلية',
                'excerpt' => $isEn ? 'Importance of DNA testing in discovering hereditary predisposition and preventive protocols.' : 'أهمية تحاليل البصمة الجينية وDNA في اكتشاف الاستعداد الوراثي ووضع بروتوكولات وقائية.',
                'date' => '2026-07-08',
                'author' => $isEn ? 'Dr. Maryam Al-Saeed' : 'د. مريم السعيد',
                'time' => $isEn ? '7 min read' : '7 دقائق'
            ],
            [
                'cat' => 'labs',
                'cat_label' => $isEn ? 'Tests & Genetics' : 'فحوصات وجينات',
                'img' => 'service-lab.png',
                'title' => $isEn ? 'Importance of Annual Comprehensive Laboratory Health Screenings' : 'أهمية إجراء الفحوصات المخبرية الشاملة بشكل دوري سنوياً',
                'excerpt' => $isEn ? 'Understand vital lab indicators (liver/kidney functions, vitamins, lipid panel) and interpretation.' : 'تعرف على القراءات المخبرية المهمة (وظائف الكبد، الكلى، الفيتامينات، والدهون) وكيف تفسرها.',
                'date' => '2026-07-04',
                'author' => $isEn ? 'Dr. Fahad Al-Dossary' : 'د. فهد الدوسري',
                'time' => $isEn ? '5 min read' : '5 دقائق'
            ],
            [
                'cat' => 'prevention',
                'cat_label' => $isEn ? 'Prevention & Home Health' : 'وقاية وصحة منزلية',
                'img' => 'service-telehealth.png',
                'title' => $isEn ? 'Role of Virtual Tele-consultations in Saving Time and Rapid Response' : 'دور الاستشارات الطبية الافتراضية في توفير الوقت وضمان الاستجابة السريعة',
                'excerpt' => $isEn ? 'When video consultations are the ideal option for quick medical guidance.' : 'متى تكون الاستشارة عبر الاتصال المرئي خياراً مثالياً للحصول على توجيه طبي سريع.',
                'date' => '2026-06-29',
                'author' => $isEn ? 'Dr. Abdullah Al-Malki' : 'د. عبد الله المالكي',
                'time' => $isEn ? '4 min read' : '4 دقائق'
            ],
        ];
    @endphp

    {{-- =================== HERO BANNER =================== --}}
    <section class="relative py-16 sm:py-20 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/3 -translate-y-1/2 w-96 h-96 bg-accent/10 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 32px 32px;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-4">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-bold text-medical-100">
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <span>{{ __('blog.badge') }}</span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                {{ $isEn ? 'Medical Blog & Health Guides' : 'المدونة الطبية والإرشادية' }}
            </h1>

            <p class="text-medical-200 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                {{ __('blog.text') }}
            </p>
        </div>
    </section>

    {{-- =================== FEATURED & ARTICLES CATALOG =================== --}}
    <section class="py-12 lg:py-16 bg-surface" x-data="{ activeTab: 'all', search: '' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            {{-- Category Filter Tabs & Search Bar --}}
            <div class="bg-white p-4 rounded-2xl shadow-soft border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
                
                {{-- Category Tabs --}}
                <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                    <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">{{ __('blog.all') }}</button>
                    <button @click="activeTab = 'elderly'" :class="activeTab === 'elderly' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">{{ __('blog.elderly') }}</button>
                    <button @click="activeTab = 'prevention'" :class="activeTab === 'prevention' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">{{ __('blog.prevention') }}</button>
                    <button @click="activeTab = 'physio'" :class="activeTab === 'physio' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">{{ __('blog.physio') }}</button>
                    <button @click="activeTab = 'labs'" :class="activeTab === 'labs' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">{{ __('blog.labs') }}</button>
                </div>

                {{-- Search Box --}}
                <div class="relative w-full md:w-64">
                    <svg class="absolute {{ $isEn ? 'left-3.5' : 'right-3.5' }} top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" x-model="search" placeholder="{{ __('blog.search_placeholder') }}" class="w-full {{ $isEn ? 'pl-10 pr-4' : 'pr-10 pl-4' }} py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary focus:bg-white transition-all">
                </div>

            </div>

            {{-- Featured Main Article Card --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-soft overflow-hidden grid grid-cols-1 lg:grid-cols-12 gap-0 group">
                <div class="lg:col-span-6 relative h-64 sm:h-80 lg:h-auto overflow-hidden">
                    <img src="{{ asset('images/blog-elderly.png') }}" alt="{{ $featured['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/70 via-transparent to-transparent lg:hidden"></div>
                    <span class="absolute top-4 {{ $isEn ? 'left-4' : 'right-4' }} bg-accent text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-md">{{ $featured['badge'] }}</span>
                </div>
                <div class="lg:col-span-6 p-6 sm:p-8 lg:p-10 flex flex-col justify-between space-y-4 {{ $isEn ? 'text-left' : 'text-right' }}">
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 text-xs text-gray-400">
                            <span class="font-bold text-accent">{{ $featured['cat'] }}</span>
                            <span>•</span>
                            <span>{{ $featured['date'] }}</span>
                            <span>•</span>
                            <span>{{ $featured['read_time'] }}</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-primary group-hover:text-accent transition-colors leading-snug">
                            {{ $featured['title'] }}
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                            {{ $featured['excerpt'] }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-primary text-white font-bold text-xs flex items-center justify-center">D</div>
                            <span class="text-xs font-bold text-gray-700">{{ $featured['author'] }}</span>
                        </div>
                        <a href="#" class="btn-primary py-2 px-5 rounded-xl text-xs font-bold">{{ $featured['read_btn'] }}</a>
                    </div>
                </div>
            </div>

            {{-- 6 Blog Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                <article class="bg-white rounded-2xl border border-gray-100 shadow-soft hover:shadow-card transition-all duration-300 overflow-hidden flex flex-col justify-between group"
                         x-show="(activeTab === 'all' || activeTab === '{{ $post['cat'] }}') && (search.trim() === '' || '{{ $post['title'] }} {{ $post['excerpt'] }}'.includes(search.trim()))">
                    
                    <div>
                        {{-- Image Banner --}}
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ asset('images/' . $post['img']) }}" alt="{{ $post['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" style="object-position: center 25%;">
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/75 to-transparent"></div>
                            
                            <span class="absolute top-3 {{ $isEn ? 'left-3' : 'right-3' }} px-3 py-1 bg-white/90 backdrop-blur-md text-primary font-bold text-[10px] rounded-lg shadow-sm">
                                {{ $post['cat_label'] }}
                            </span>
                        </div>

                        {{-- Content --}}
                        <div class="p-5 space-y-3 {{ $isEn ? 'text-left' : 'text-right' }}">
                            <div class="flex items-center gap-2 text-[11px] text-gray-400">
                                <span>{{ $post['date'] }}</span>
                                <span>•</span>
                                <span>{{ $post['time'] }}</span>
                            </div>

                            <h3 class="font-bold text-primary text-base group-hover:text-accent transition-colors leading-snug">{{ $post['title'] }}</h3>
                            <p class="text-xs text-gray-500 leading-relaxed">{{ $post['excerpt'] }}</p>
                        </div>
                    </div>

                    {{-- Footer Author & Link --}}
                    <div class="px-5 pb-5 pt-3 border-t border-gray-50 flex items-center justify-between">
                        <span class="text-[11px] font-bold text-gray-600">{{ $post['author'] }}</span>
                        <a href="#" class="text-xs font-bold text-accent hover:text-primary transition-colors flex items-center gap-1">
                            <span>{{ $isEn ? 'Read More' : 'اقرأ المزيد' }}</span>
                            <svg class="w-3.5 h-3.5 {{ $isEn ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                    </div>

                </article>
                @endforeach
            </div>

            {{-- Newsletter Box --}}
            <div class="bg-gradient-to-r from-primary via-primary-hover to-primary text-white p-8 rounded-3xl shadow-floating text-center space-y-4">
                <div class="w-12 h-12 mx-auto rounded-2xl bg-white/10 flex items-center justify-center text-accent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-xl sm:text-2xl font-black">{{ $isEn ? 'Subscribe to Educational Health Newsletter' : 'اشترك في النشرة الطبية التثقيفية' }}</h3>
                <p class="text-xs sm:text-sm text-medical-200 max-w-md mx-auto">{{ $isEn ? 'Receive the latest trusted medical articles and guides directly to your inbox weekly.' : 'احصل على أحدث المقالات والإرشادات الطبية الموثوقة مباشرة في بريدك الإلكتروني أسبوعياً.' }}</p>
                <form action="#" method="POST" class="max-w-md mx-auto flex flex-col sm:flex-row gap-2" @submit.prevent="alert('{{ $isEn ? 'Successfully subscribed to health newsletter!' : 'تم اشتراكك في النشرة الطبية بنجاح!' }}')">
                    <input type="email" required placeholder="{{ $isEn ? 'Enter your email address' : 'أدخل بريدك الإلكتروني' }}" class="flex-1 px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-xs text-white placeholder-medical-300 focus:outline-none focus:border-accent">
                    <button type="submit" class="btn-accent py-3 px-6 rounded-xl font-bold text-xs shadow-md whitespace-nowrap">{{ $isEn ? 'Subscribe Now' : 'اشترك الآن' }}</button>
                </form>
            </div>

        </div>
    </section>

</x-app-layout>
