<x-app-layout title="الملف الشخصي | سيما الخليج للخدمات الطبية">

    {{-- =================== PROFILE HERO HEADER =================== --}}
    <section class="relative py-12 sm:py-16 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                
                {{-- Avatar & Info --}}
                <div class="flex items-center gap-4 text-center sm:text-right">
                    <div class="relative">
                        <div class="w-20 h-20 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-accent font-black text-2xl flex items-center justify-center shadow-lg">
                            عأ
                        </div>
                        <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full bg-accent text-white flex items-center justify-center text-[10px] font-bold border-2 border-primary" title="حساب موثق">
                            ✓
                        </span>
                    </div>
                    
                    <div class="space-y-1">
                        <div class="flex items-center justify-center sm:justify-start gap-2">
                            <h1 class="text-2xl font-black">عبد الله أحمد الغامدي</h1>
                            <span class="px-2.5 py-0.5 rounded-full bg-accent/20 text-accent border border-accent/30 text-[10px] font-bold">عضوية مميزة</span>
                        </div>
                        <p class="text-xs text-medical-200">الرقم الطبي: #SA-884920 • جدة، حي الرويس</p>
                        <p class="text-[11px] text-medical-300">عضو منذ يوليو 2026</p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="btn-accent py-2.5 px-5 rounded-xl text-xs font-bold shadow-md">
                        طلب خدمة طبية جديدة
                    </a>
                    <a href="{{ route('login') }}" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 rounded-xl text-xs font-bold transition-all text-white">
                        تسجيل الخروج
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- =================== PROFILE DASHBOARD TABS =================== --}}
    <section class="py-12 bg-surface" x-data="{ activeTab: 'visits' }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Tabs Navigation --}}
            <div class="bg-white p-2 rounded-2xl shadow-soft border border-gray-100 flex flex-wrap items-center gap-2">
                <button @click="activeTab = 'visits'" :class="activeTab === 'visits' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>الزيارات والمواعيد (3)</span>
                </button>
                
                <button @click="activeTab = 'orders'" :class="activeTab === 'orders' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span>طلبات المستلزمات (2)</span>
                </button>

                <button @click="activeTab = 'reports'" :class="activeTab === 'reports' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>التقارير والنتائج المخبرية</span>
                </button>

                <button @click="activeTab = 'info'" :class="activeTab === 'info' ? 'bg-primary text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'" class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>البيانات الشخصية</span>
                </button>
            </div>

            {{-- TAB 1: VISITS & APPOINTMENTS --}}
            <div x-show="activeTab === 'visits'" class="space-y-4">
                <div class="bg-white p-6 rounded-3xl shadow-soft border border-gray-100 space-y-4">
                    <h3 class="font-black text-lg text-primary">المواعيد والزيارات المنزلية</h3>
                    
                    <div class="space-y-3">
                        {{-- Visit Item 1 --}}
                        <div class="p-4 rounded-2xl bg-surface border border-gray-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-accent/10 text-accent font-bold flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                </div>
                                <div>
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold mb-1">زيارة مؤكدة قادمة</span>
                                    <h4 class="font-bold text-sm text-primary">زيارة طبيب منزلية - الكشف العام الدوري</h4>
                                    <p class="text-xs text-gray-500">الأحد، 10 أغسطس 2026 • 04:00 مساءً • د. عبد الرحمن الغامدي</p>
                                </div>
                            </div>
                            <button @click="alert('تم إرسال تذكير الموعد للواتساب.')" class="btn-outline py-2 px-4 rounded-xl text-xs font-bold shrink-0">تأكيد الموعد</button>
                        </div>

                        {{-- Visit Item 2 --}}
                        <div class="p-4 rounded-2xl bg-surface border border-gray-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary font-bold flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                </div>
                                <div>
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[10px] font-bold mb-1">مكتملة</span>
                                    <h4 class="font-bold text-sm text-primary">سحب عينات وريد منزلية - تحاليل مخبرية شاملة</h4>
                                    <p class="text-xs text-gray-500">الثلاثاء، 28 يوليو 2026 • النتيجة جاهزة للتحميل</p>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-accent">مكتمل</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 2: STORE ORDERS --}}
            <div x-show="activeTab === 'orders'" x-cloak class="space-y-4">
                <div class="bg-white p-6 rounded-3xl shadow-soft border border-gray-100 space-y-4">
                    <h3 class="font-black text-lg text-primary">طلبات الأجهزة والمستلزمات الطبية</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-right text-xs">
                            <thead class="bg-surface text-gray-500 font-bold border-b border-gray-100">
                                <tr>
                                    <th class="p-3">رقم الطلب</th>
                                    <th class="p-3">التاريخ</th>
                                    <th class="p-3">المنتجات</th>
                                    <th class="p-3">المبلغ الإجمالي</th>
                                    <th class="p-3">الحالة</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-gray-700">
                                <tr>
                                    <td class="p-3 font-bold text-primary">#SA-99482</td>
                                    <td class="p-3">01 أغسطس 2026</td>
                                    <td class="p-3 font-bold">جهاز قياس ضغط الدم Omron + جهاز قياس الأكسجين</td>
                                    <td class="p-3 font-black text-accent">400 ر.س</td>
                                    <td class="p-3"><span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 font-bold text-[10px]">قيد التوصيل</span></td>
                                </tr>
                                <tr>
                                    <td class="p-3 font-bold text-primary">#SA-88310</td>
                                    <td class="p-3">15 يوليو 2026</td>
                                    <td class="p-3 font-bold">حقيبة إسعافات أولية منزلية</td>
                                    <td class="p-3 font-black text-accent">95 ر.س</td>
                                    <td class="p-3"><span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[10px]">تم التسليم</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- TAB 3: MEDICAL REPORTS --}}
            <div x-show="activeTab === 'reports'" x-cloak class="space-y-4">
                <div class="bg-white p-6 rounded-3xl shadow-soft border border-gray-100 space-y-4">
                    <h3 class="font-black text-lg text-primary">التقارير والنتائج المخبرية الرسمية</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-2xl bg-surface border border-gray-100 flex items-center justify-between">
                            <div class="space-y-1">
                                <h4 class="font-bold text-xs text-primary">تقرير الفحص المخبري الشامل (PDF)</h4>
                                <p class="text-[11px] text-gray-400">تاريخ الإصدار: 28 يوليو 2026 • معتمد طبياً</p>
                            </div>
                            <button @click="alert('جاري تحميل التقرير الطبي PDF...')" class="btn-accent py-2 px-3 rounded-xl text-xs font-bold">تحميل PDF</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TAB 4: PERSONAL INFO --}}
            <div x-show="activeTab === 'info'" x-cloak class="space-y-4">
                <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-soft border border-gray-100 space-y-6">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                        <h3 class="font-black text-lg text-primary">البيانات الشخصية والمسجلة</h3>
                        <button @click="alert('تم فتح وضع تعديل البيانات.')" class="btn-outline py-2 px-4 rounded-xl text-xs font-bold">تعديل البيانات</button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-xs">
                        <div>
                            <span class="block font-bold text-gray-400 mb-1">الاسم الكامل</span>
                            <span class="text-sm font-bold text-primary">عبد الله أحمد الغامدي</span>
                        </div>
                        <div>
                            <span class="block font-bold text-gray-400 mb-1">رقم الجوال</span>
                            <span class="text-sm font-bold text-primary dir-ltr text-right">0545880082</span>
                        </div>
                        <div>
                            <span class="block font-bold text-gray-400 mb-1">البريد الإلكتروني</span>
                            <span class="text-sm font-bold text-primary">a.alghamdi@example.com</span>
                        </div>
                        <div>
                            <span class="block font-bold text-gray-400 mb-1">العنوان والمدينة</span>
                            <span class="text-sm font-bold text-primary">جدة، حي الرويس، طريق المدينة</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</x-app-layout>
