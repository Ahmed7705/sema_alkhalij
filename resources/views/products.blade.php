<x-app-layout title="متجر الأجهزة والمستلزمات الطبية | سيما الخليج">

    {{-- =================== HERO STORE BANNER =================== --}}
    <section class="relative py-16 sm:py-20 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/3 -translate-y-1/2 w-96 h-96 bg-accent/10 rounded-full blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 32px 32px;"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-4">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-xs font-bold text-medical-100">
                <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                <span>متجر سيما الخليج الطبي الرسمي</span>
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black tracking-tight leading-tight">
                الأجهزة والمستلزمات الطبية <span class="text-accent">المنزلية المعتمدة</span>
            </h1>

            <p class="text-medical-200 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed">
                تصفح أفضل الأجهزة والمستلزمات الطبية المنزلية المعتمدة بأسعار تنافسية وضمان رسمي مع توصيل سريع لجميع مدن المملكة.
            </p>
        </div>
    </section>

    {{-- =================== E-STORE PRODUCTS CATALOG =================== --}}
    <section class="py-12 lg:py-16 bg-surface" x-data="{ 
        activeTab: 'all', 
        search: '',
        modalProduct: null,
        modalQty: 1,
        openModal(p) { this.modalProduct = p; this.modalQty = 1; }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Filter & Search Bar --}}
            <div class="bg-white p-4 rounded-2xl shadow-soft border border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
                
                {{-- Category Tabs --}}
                <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                    <button @click="activeTab = 'all'" :class="activeTab === 'all' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">جميع المنتجات (8)</button>
                    <button @click="activeTab = 'monitors'" :class="activeTab === 'monitors' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">أجهزة قياس</button>
                    <button @click="activeTab = 'respiratory'" :class="activeTab === 'respiratory' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">أجهزة تنفس وبخار</button>
                    <button @click="activeTab = 'mobility'" :class="activeTab === 'mobility' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">كراسي وأسرة</button>
                    <button @click="activeTab = 'firstaid'" :class="activeTab === 'firstaid' ? 'bg-primary text-white shadow-sm' : 'bg-gray-50 hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-xl text-xs font-bold transition-all">تعقيم وإسعافات</button>
                </div>

                {{-- Search Box --}}
                <div class="relative w-full md:w-64">
                    <svg class="absolute right-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" x-model="search" placeholder="ابحث عن جهاز أو مستلزم..." class="w-full pr-10 pl-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:outline-none focus:border-primary focus:bg-white transition-all">
                </div>

            </div>

            @php
            $products = [
                [
                    'id' => 1,
                    'cat' => 'monitors',
                    'cat_label' => 'أجهزة قياس',
                    'title' => 'جهاز قياس ضغط الدم الذكي (Omron)',
                    'price' => 280,
                    'old_price' => 350,
                    'rating' => 5,
                    'img' => 'prod-bp.png',
                    'badge' => 'خصم 20%',
                    'desc' => 'جهاز قياس ضغط الدم الرقمي من الذراع بدقة عالية وشاشة LCD مضاءة وذاكرة لتخزين قراءات مستخدمين.',
                    'specs' => ['دقة قراءة معتمدة طبياً', 'ذاكرة تحفظ 100 قراءة', 'شاشة عرض كبيرة وسهلة القراءة', 'ضمان رسمي سنتين']
                ],
                [
                    'id' => 2,
                    'cat' => 'monitors',
                    'cat_label' => 'أجهزة قياس',
                    'title' => 'جهاز قياس الأكسجين ومعدل النبض (Pulse Oximeter)',
                    'price' => 120,
                    'rating' => 5,
                    'img' => 'prod-oximeter.png',
                    'badge' => 'الأكثر مبيعاً',
                    'desc' => 'جهاز صغير يوضع بالإصبع لقياس نسبة الأكسجين بالدم SpO2 ونبضات القلب فورياً بشاشة ملونة OLED.',
                    'specs' => ['قراءة فورية خلال 3 ثوانٍ', 'شاشة ملونة OLED واضحة', 'إيقاف تشغيل تلقائي لتوفير البطارية', 'مناسب لجميع الأعمار']
                ],
                [
                    'id' => 3,
                    'cat' => 'respiratory',
                    'cat_label' => 'أجهزة تنفس وبخار',
                    'title' => 'جهاز استنشاق البخار والنيبولايزر المنزلي',
                    'price' => 210,
                    'old_price' => 250,
                    'rating' => 5,
                    'img' => 'prod-nebulizer.png',
                    'badge' => 'ضمان سنتين',
                    'desc' => 'جهاز نيبولايزر ضاغط مخصص لمرضى الحساسية والربو مع كمامات مناسبة للكبار والأطفال.',
                    'specs' => ['محرك قوي وهادئ الصوت', 'يشمل كمامة كبار وكمامة أطفال', 'سريع تحويل الدواء لبخار ناعم', 'سهل التنظيف والتعقيم']
                ],
                [
                    'id' => 4,
                    'cat' => 'monitors',
                    'cat_label' => 'أجهزة قياس',
                    'title' => 'جهاز فحص السكر الذكي (يشمل 50 شريطاً)',
                    'price' => 150,
                    'rating' => 4,
                    'img' => 'prod-glucometer.png',
                    'badge' => 'عرض خاص',
                    'desc' => 'جهاز فحص سكر الدم السريع بدون ألم، يعطي النتيجة في 5 ثوانٍ مع ذاكرة 500 قراءة.',
                    'specs' => ['عينة دم ميكرو صغيرة جداً', 'نتيجة فائقة السرعة في 5 ثوانٍ', 'يشمل 50 شريط فحص + قلم الوخز', 'ربط إلكتروني بالتطبيق']
                ],
                [
                    'id' => 5,
                    'cat' => 'mobility',
                    'cat_label' => 'كراسي وأسرة',
                    'title' => 'كرسي متحرك خفيف الوزن قابل للطي لكبار السن',
                    'price' => 550,
                    'rating' => 5,
                    'img' => 'prod-wheelchair.png',
                    'badge' => 'شحن مجاني',
                    'desc' => 'كرسي متحرك مريح ومصنوع من الألومنيوم الخفيف، سهل الطي والنقل بالسيارة مع فرامل أمان مزدوجة.',
                    'specs' => ['هيكل ألومنيوم خفيف متين', 'مقعد مبطن ومقاوم للماء', 'عجلات خلفية كبيرة لسهولة الدفع', 'سهل الطي والتخزين بالسيارة']
                ],
                [
                    'id' => 6,
                    'cat' => 'firstaid',
                    'cat_label' => 'تعقيم وإسعافات',
                    'img' => 'prod-firstaid.png',
                    'title' => 'حقيبة الإسعافات الأولية والتطهير المنزلية',
                    'price' => 95,
                    'rating' => 5,
                    'badge' => 'مستلزم يومي',
                    'desc' => 'حقيبة متكاملة تحتوي على شاش معقم، أربطة ضاغطة، مطهرات جروح، ومسكنات طوارئ.',
                    'specs' => ['تجهيز إسعافي شامل للطوارئ', 'أربطة ومطهرات معقمة طبياً', 'حقيبة منظمة وسهلة الحمل', 'مطابقة لمعايير السلامة']
                ],
                [
                    'id' => 7,
                    'cat' => 'mobility',
                    'cat_label' => 'كراسي وأسرة',
                    'img' => 'prod-bed.png',
                    'title' => 'سرير طبي كهربائي 3 حركات للرعاية المنزلية',
                    'price' => 2800,
                    'rating' => 5,
                    'badge' => 'تركيب مجاني',
                    'desc' => 'سرير طبي كهربائي بموتور ألماني لضبط مستوى الظهر والأرجل مع حواجز حماية جانبية ومرتبة طبية معقمة.',
                    'specs' => ['تحكم كهربائي بالريموت 3 حركات', 'حواجز حماية جانبية للأمان', 'يشمل مرتبة طبية لمنع قرح الفراش', 'توصيل وتركيب مجاني بالمنزل']
                ],
                [
                    'id' => 8,
                    'cat' => 'firstaid',
                    'cat_label' => 'مستلزمات تمريض',
                    'img' => 'prod-supplies.png',
                    'title' => 'حقيبة التمريض والعناية بالجروح المتكاملة',
                    'price' => 180,
                    'rating' => 5,
                    'badge' => 'معقم بالكامل',
                    'desc' => 'مجموعة أدوات ومستلزمات الغيار الطبي المخصصة للممرضين والمرضى بالمنزل.',
                    'specs' => ['مجموعات غيار جروح معقمة', 'قفازات وأقنعة طبية ذات استخدام واحد', 'محلول ملحي ومطهرات طبية', 'أدوات قص وتضميد احترافية']
                ],
            ];
            @endphp

            {{-- Products 8 Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $p)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-soft hover:shadow-card transition-all duration-300 overflow-hidden flex flex-col justify-between group"
                     x-show="(activeTab === 'all' || activeTab === '{{ $p['cat'] }}') && (search.trim() === '' || '{{ $p['title'] }} {{ $p['desc'] }}'.includes(search.trim()))">
                    
                    <div>
                        {{-- Image Container --}}
                        <div class="relative h-48 sm:h-52 bg-white border-b border-gray-50 overflow-hidden p-3 flex items-center justify-center">
                            <img src="{{ asset('images/' . $p['img']) }}" alt="{{ $p['title'] }}" class="w-full h-full object-cover rounded-xl group-hover:scale-105 transition-transform duration-500">
                            
                            @if(isset($p['badge']))
                            <span class="absolute top-4 right-4 px-2.5 py-1 bg-accent text-white font-bold text-[10px] rounded-lg shadow-md border border-white/20">
                                {{ $p['badge'] }}
                            </span>
                            @endif

                            <span class="absolute bottom-4 left-4 px-2.5 py-1 bg-white/90 backdrop-blur-md text-primary font-bold text-[10px] rounded-lg shadow-sm border border-gray-100">
                                {{ $p['cat_label'] }}
                            </span>
                        </div>

                        {{-- Card Details --}}
                        <div class="p-5 space-y-2">
                            <div class="flex items-center text-amber-400 text-xs">
                                ★★★★★ <span class="text-gray-400 text-[10px] font-bold mr-1.5">(5.0)</span>
                            </div>

                            <h3 class="font-bold text-primary text-sm group-hover:text-accent transition-colors leading-snug h-10 overflow-hidden">{{ $p['title'] }}</h3>
                            <p class="text-xs text-gray-500 leading-relaxed truncate">{{ $p['desc'] }}</p>

                            <div class="pt-2 flex items-baseline gap-2">
                                <span class="text-base font-black text-accent">{{ $p['price'] }} ر.س</span>
                                @if(isset($p['old_price']))
                                <span class="text-xs text-gray-400 line-through">{{ $p['old_price'] }} ر.س</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="p-5 pt-0 grid grid-cols-2 gap-2">
                        <button @click="openModal({{ json_encode($p) }})" class="w-full btn-outline py-2.5 rounded-xl text-xs font-bold transition-all">التفاصيل</button>
                        <button @click="addToCart({{ json_encode($p) }})" class="w-full btn-accent py-2.5 rounded-xl text-xs font-bold shadow-sm hover:shadow-md transition-all flex items-center justify-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            <span>أضف للسلة</span>
                        </button>
                    </div>

                </div>
                @endforeach
            </div>

            {{-- Quick View Product Modal --}}
            <div x-show="modalProduct !== null" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="modalProduct !== null" @click="modalProduct = null" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                    <div x-show="modalProduct !== null" class="inline-block align-bottom bg-white rounded-3xl text-right overflow-hidden shadow-floating transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100">
                        <template x-if="modalProduct !== null">
                            <div>
                                {{-- Modal Header --}}
                                <div class="bg-primary px-6 py-4 text-white flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold text-accent bg-white/10 px-2.5 py-0.5 rounded-full" x-text="modalProduct.cat_label"></span>
                                        <span class="text-xs text-medical-200" x-text="modalProduct.badge || 'ضمان رسمي'"></span>
                                    </div>
                                    <button @click="modalProduct = null" class="text-medical-200 hover:text-white transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>

                                {{-- Modal Body --}}
                                <div class="p-6 space-y-6">
                                    <div class="grid grid-cols-1 sm:grid-cols-12 gap-6 items-start">
                                        
                                        {{-- Product Image --}}
                                        <div class="sm:col-span-5 bg-white border border-gray-100 rounded-2xl p-2 h-56 overflow-hidden flex items-center justify-center shadow-sm">
                                            <img :src="'/images/' + modalProduct.img" :alt="modalProduct.title" class="w-full h-full object-cover rounded-xl">
                                        </div>

                                        {{-- Product Details --}}
                                        <div class="sm:col-span-7 space-y-4 text-right">
                                            <h3 class="font-black text-lg text-primary leading-tight" x-text="modalProduct.title"></h3>
                                            <p class="text-xs text-gray-600 leading-relaxed" x-text="modalProduct.desc"></p>

                                            {{-- Specs List --}}
                                            <div class="space-y-1.5 pt-1 border-t border-gray-100">
                                                <span class="block text-[11px] font-bold text-gray-400 mb-1">المواصفات الرئيسية:</span>
                                                <template x-for="spec in modalProduct.specs || []" :key="spec">
                                                    <div class="flex items-center gap-2 text-xs text-gray-700">
                                                        <svg class="w-3.5 h-3.5 text-accent shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                        <span x-text="spec"></span>
                                                    </div>
                                                </template>
                                            </div>

                                            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                                                <div>
                                                    <span class="block text-[10px] text-gray-400 font-bold">السعر النهائي</span>
                                                    <span class="text-xl font-black text-accent" x-text="modalProduct.price + ' ر.س'"></span>
                                                </div>

                                                {{-- Quantity Selector --}}
                                                <div class="flex items-center gap-2 bg-surface p-1.5 rounded-xl border border-gray-200">
                                                    <button @click="modalQty = Math.max(1, modalQty - 1)" class="w-7 h-7 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-xs font-bold hover:bg-gray-100">-</button>
                                                    <span class="text-xs font-bold text-primary px-2" x-text="modalQty"></span>
                                                    <button @click="modalQty++" class="w-7 h-7 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-xs font-bold hover:bg-gray-100">+</button>
                                                </div>
                                            </div>

                                            {{-- Add Button --}}
                                            <button @click="addToCart({ ...modalProduct, qty: modalQty }); modalProduct = null" class="w-full btn-accent py-3.5 rounded-xl font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                                <span>إضافة إلى سلة التسوق الآن</span>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

        </div>
    </section>

</x-app-layout>
