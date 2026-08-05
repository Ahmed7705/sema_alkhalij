<footer class="bg-primary text-white pt-12 pb-6 border-t-4 border-accent relative overflow-hidden">
    {{-- Background Ornament --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-accent/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 pb-10 border-b border-white/10">
            
            {{-- Column 1: Brand & Bio (2 cols) --}}
            <div class="lg:col-span-2 space-y-4">
                <a href="{{ url('/') }}" class="inline-block">
                    <img src="{{ asset($siteSettings['site_logo'] ?? 'images/logo.png') }}" alt="{{ $siteSettings['site_title'] ?? 'سيما الخليج' }}" class="h-14 w-auto bg-white/10 p-2 rounded-xl backdrop-blur-sm object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                    <div class="hidden items-center gap-2">
                        <div class="w-10 h-10 rounded-xl bg-accent text-white flex items-center justify-center font-black text-xl">S</div>
                        <div>
                            <h3 class="font-bold text-lg text-white">سيما الخليج</h3>
                            <p class="text-[11px] text-medical-300">للخدمات الطبية المنزلية</p>
                        </div>
                    </div>
                </a>
                <p class="text-medical-200 text-xs sm:text-sm leading-relaxed max-w-md">
                    شركة سيما الخليج للخدمات الطبية تُقدّم منظومة رعاية صحية منزلية متكاملة وفق أرفع معايير الجودة والنظافة والسلامة، بفرُق طبية وتمريضية مؤهلة لتلبية احتياجاتك في راحتك وبأحدث التقنيات.
                </p>
                <div class="space-y-2 pt-1 text-xs sm:text-sm">
                    <a href="tel:+966545880082" class="flex items-center gap-2.5 text-medical-100 hover:text-accent transition-colors">
                        <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-accent shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <span class="font-bold dir-ltr">+966 54 588 0082</span>
                    </a>
                    <a href="mailto:c.care@s-sema.com" class="flex items-center gap-2.5 text-medical-100 hover:text-accent transition-colors">
                        <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-accent shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <span>c.care@s-sema.com</span>
                    </a>
                    <div class="flex items-center gap-2.5 text-medical-100">
                        <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-accent shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        </div>
                        <span>جدة، حي الرويس، طريق المدينة المنورة</span>
                    </div>
                </div>
            </div>

            {{-- Column 2: Company Links --}}
            <div class="space-y-3">
                <h4 class="text-sm font-bold text-white border-r-3 border-accent pr-2.5">روابط الشركة</h4>
                <ul class="space-y-2 text-xs sm:text-sm text-medical-200">
                    <li><a href="{{ url('/') }}" class="hover:text-accent transition-colors">الرئيسية</a></li>
                    <li><a href="{{ url('/about') }}" class="hover:text-accent transition-colors">من نحن</a></li>
                    <li><a href="{{ url('/services') }}" class="hover:text-accent transition-colors">الخدمات الطبية</a></li>
                    <li><a href="{{ url('/products') }}" class="hover:text-accent transition-colors">المتجر والمستلزمات</a></li>
                    <li><a href="{{ url('/blog') }}" class="hover:text-accent transition-colors">المدونة الطبية</a></li>
                    <li><a href="{{ url('/contact') }}" class="hover:text-accent transition-colors">اتصل بنا</a></li>
                </ul>
            </div>

            {{-- Column 3: Medical Services --}}
            <div class="space-y-3">
                <h4 class="text-sm font-bold text-white border-r-3 border-accent pr-2.5">خدماتنا الطبية</h4>
                <ul class="space-y-2 text-xs sm:text-sm text-medical-200">
                    <li><a href="{{ url('/services') }}" class="hover:text-accent transition-colors">التمريض المنزلي</a></li>
                    <li><a href="{{ url('/services') }}" class="hover:text-accent transition-colors">الزيارات الطبية المنزلية</a></li>
                    <li><a href="{{ url('/services') }}" class="hover:text-accent transition-colors">العلاج الطبيعي التأهيلي</a></li>
                    <li><a href="{{ url('/services') }}" class="hover:text-accent transition-colors">سحب العينات والفحوصات</a></li>
                    <li><a href="{{ url('/services') }}" class="hover:text-accent transition-colors">الفحوصات الجينية والمخبرية</a></li>
                    <li><a href="{{ url('/services') }}" class="hover:text-accent transition-colors">خدمات الرعاية للشركات</a></li>
                </ul>
            </div>

            {{-- Column 4: Newsletter & Policies --}}
            <div class="space-y-3">
                <h4 class="text-sm font-bold text-white border-r-3 border-accent pr-2.5">النشرة والسياسات</h4>
                <p class="text-[11px] text-medical-200 leading-relaxed">اشترك في النشرة للحصول على إرشادات صحية وعروض حصرية.</p>
                
                <form action="#" method="POST" class="space-y-2" @submit.prevent>
                    <div class="relative">
                        <input type="email" placeholder="أدخل بريدك الإلكتروني" class="w-full bg-white/10 border border-white/20 rounded-xl py-2 px-3 text-xs text-white placeholder-medical-300 focus:outline-none focus:border-accent">
                        <button type="submit" class="absolute left-1 top-1 bottom-1 px-3 bg-accent text-white rounded-lg text-[11px] font-bold hover:bg-accent-hover transition-colors">اشترك</button>
                    </div>
                </form>

                <div class="pt-1">
                    <ul class="space-y-1.5 text-[11px] text-medical-300">
                        <li><a href="{{ url('/privacy-policy') }}" class="hover:text-accent transition-colors">سياسة الخصوصية</a></li>
                        <li><a href="{{ url('/terms') }}" class="hover:text-accent transition-colors">الشروط والأحكام</a></li>
                        <li><a href="{{ url('/patient-rights') }}" class="hover:text-accent transition-colors">حقوق المرضى</a></li>
                        <li><a href="{{ url('/quality-policy') }}" class="hover:text-accent transition-colors">سياسة الجودة والسلامة</a></li>
                    </ul>
                </div>
            </div>

        </div>

        {{-- Footer Bottom Bar --}}
        <div class="pt-6 flex flex-col items-center justify-center text-center gap-3 text-xs text-medical-300">
            <div>
                © {{ date('Y') }} <strong>شركة سيما الخليج للخدمات الطبية</strong>. جميع الحقوق محفوظة.
            </div>

            {{-- Social Icons --}}
            <div class="flex items-center gap-2">
                <a href="https://wa.me/966545880082" target="_blank" class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center hover:bg-accent hover:text-white transition-all" title="واتساب"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.157 4.228 4.305-1.129z"/></svg></a>
                <a href="#" class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center hover:bg-accent hover:text-white transition-all" title="لينكد إن"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></a>
                <a href="#" class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center hover:bg-accent hover:text-white transition-all" title="إنستغرام"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                <a href="#" class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center hover:bg-accent hover:text-white transition-all" title="إكس / تويتر"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
            </div>
        </div>
    </div>
</footer>
