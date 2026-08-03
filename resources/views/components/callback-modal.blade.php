<div x-show="callbackModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        
        <!-- Backdrop -->
        <div x-show="callbackModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="callbackModalOpen = false" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal Card -->
        <div x-show="callbackModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-3xl text-right overflow-hidden shadow-floating transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
            
            <!-- Header Banner -->
            <div class="bg-primary px-6 py-5 text-white flex items-center justify-between relative overflow-hidden">
                <div class="relative z-10">
                    <span class="inline-block text-xs font-bold text-accent bg-white/10 px-2.5 py-0.5 rounded-full mb-1">حجز سريع</span>
                    <h3 class="text-xl font-bold">طلب خدمة طبية</h3>
                    <p class="text-xs text-medical-200 mt-1">أدخل بياناتك وسيتواصل معك الفريق الطبي فوراً لتأكيد طلبك</p>
                </div>
                <button @click="callbackModalOpen = false" class="text-medical-200 hover:text-white transition-colors p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Form Content -->
            <form action="#" method="POST" @submit.prevent="alert('تم استلام طلب الخدمة بنجاح! سيتواصل معك فريق سيما الخليج فورًا.'); callbackModalOpen = false;" class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">الاسم الكريم <span class="text-red-500">*</span></label>
                    <input type="text" required placeholder="مثال: عبد الله أحمد" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">رقم الجوال <span class="text-red-500">*</span></label>
                    <input type="tel" required placeholder="05xxxxxxxx" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:bg-white transition-all dir-ltr text-right">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1.5">نوع الخدمة المطلوبة</label>
                    <select x-model="selectedService" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:bg-white transition-all cursor-pointer">
                        <option value="">اختر نوع الخدمة (اختياري)</option>
                        <option value="الرعاية الصحية المنزلية">الرعاية الصحية المنزلية</option>
                        <option value="الزيارات الطبية المنزلية">الزيارات الطبية المنزلية</option>
                        <option value="التمريض المنزلي 24/7">التمريض المنزلي 24/7</option>
                        <option value="العلاج الطبيعي والتأهيل">العلاج الطبيعي والتأهيل</option>
                        <option value="سحب العينات المنزلي">سحب العينات المنزلي</option>
                        <option value="الفحوصات المخبرية الشاملة">الفحوصات المخبرية الشاملة</option>
                        <option value="الفحوصات الجينية والوراثية">الفحوصات الجينية والوراثية</option>
                        <option value="الاستشارات الطبية">الاستشارات الطبية</option>
                        <option value="خدمات الرعاية للشركات">خدمات الرعاية للشركات</option>
                    </select>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full btn-accent py-3.5 rounded-xl font-bold text-sm shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <span>إرسال طلب الخدمة الآن</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>

                <p class="text-[11px] text-gray-400 text-center">
                    نلتزم بالحفاظ على سرية وخصوصية كافة بياناتك الطبية والشخصية وفقًا لنظام PDPL.
                </p>
            </form>

        </div>
    </div>
</div>
