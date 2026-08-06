<x-app-layout title="{{ app()->getLocale()=='en' ? 'Corporate Medical Services & Contracts | Sema Al-Khalij' : 'الخدمات الطبية للشركات والتعاقدات | سيما الخليج' }}">
    @php
        $isEn = app()->getLocale() == 'en';
    @endphp

    <div class="py-12 bg-surface min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16 {{ $isEn ? 'text-left dir-ltr' : 'text-right dir-rtl' }}">
            
            {{-- Hero Banner --}}
            <div class="bg-gradient-to-r from-primary via-[#0a3428] to-[#071f18] rounded-3xl p-8 sm:p-12 text-white shadow-2xl relative overflow-hidden flex flex-col lg:flex-row items-center justify-between gap-8 border border-white/10">
                <div class="space-y-4 max-w-2xl">
                    <span class="px-4 py-1.5 rounded-full bg-accent/20 text-accent font-black text-xs border border-accent/30 inline-block">
                        {{ $isEn ? 'Integrated Healthcare Solutions for Enterprises' : 'حلول الرعاية الطبية المتكاملة للشركات والمنشآت' }}
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-black leading-tight">
                        {{ $isEn ? 'Your Trusted Medical Partner for Employee & Beneficiary Care in KSA' : 'شريككم الطبي الموثوق لرعاية الموظفين والمستفيدين في المملكة' }}
                    </h1>
                    <p class="text-sm text-medical-200 leading-relaxed">
                        {{ $isEn ? 'We provide our public and private sector partners with customized contract packages including home doctor visits, direct nursing, periodic health screenings, field medical surveys, and lab tests with corporate pricing and professional beneficiary management.' : 'نقدم لشركائنا من القطاعين الحكومي والخاص باقات تعاقدية مخصصة تشمل الزيارات المنزلية، التمريض المباشر، الفحوصات الدورية، المسح الطبي الميداني، والتحاليل المخبرية بأسعار خاصة وإدارة مستفيدين احترافية.' }}
                    </p>
                    <div class="pt-2 flex flex-wrap gap-4">
                        <a href="#contract-request-form" class="px-8 py-4 bg-accent hover:bg-accent-hover text-white rounded-2xl font-black text-sm shadow-xl transition-all">
                            {{ $isEn ? 'Request New Contract' : 'طلب تعاقد جديد' }}
                        </a>
                        <a href="#contract-mechanism" class="px-8 py-4 bg-white/10 hover:bg-white/20 text-white rounded-2xl font-bold text-sm transition-all">
                            {{ $isEn ? 'Contracting Mechanism' : 'التعرف على آلية التعاقد' }}
                        </a>
                    </div>
                </div>
                <div class="w-full lg:w-1/3 flex justify-center">
                    <div class="w-48 h-48 rounded-3xl bg-white/10 backdrop-blur-md p-6 border border-white/20 flex flex-col items-center justify-center text-center space-y-3">
                        <svg class="w-16 h-16 text-accent" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span class="font-black text-xs text-white">
                            {{ $isEn ? 'Flexible Management & Unlimited Beneficiaries' : 'إدارة تعاقدات مرنة ومستفيدين بلا حدود' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Corporate Advantages Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-black text-lg text-primary">
                        {{ $isEn ? 'Custom Contract Pricing' : 'أسعار تعاقدية مخصصة (Contract Pricing)' }}
                    </h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        {{ $isEn ? 'Special volume discounts and custom rates designed for each contract based on staff count and required medical services.' : 'خصومات خاصة وأسعار تفضيلية مستهدفة لكل عقد حسب عدد المستفيدين ونوعية الخدمات الطبية المطلوبة دون التأثير على الأسعار العامة.' }}
                    </p>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="font-black text-lg text-primary">
                        {{ $isEn ? 'Flexible Payment Terms & Invoicing' : 'شروط دفع وفواتير دورية مرنة' }}
                    </h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        {{ $isEn ? 'Flexible billing options including Monthly Invoicing, Net 30 payment terms, or direct settlement per approved terms.' : 'خيارات سداد مرنة تشمل الفوترة الشهرية (Monthly Invoice)، شروط Net 30، أو الدفع الفوري بحسب بنود العقد المعتمد.' }}
                    </p>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h3 class="font-black text-lg text-primary">
                        {{ $isEn ? 'Dedicated Beneficiary Portal' : 'بوابة مستقلة لمتابعة المستفيدين' }}
                    </h3>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        {{ $isEn ? 'Independent secure portal for your enterprise to manage staff lists, define coverage caps, request medical visits, and track status live.' : 'لوحة تحكم آمنة ومستقلة بشركتكم لإضافة المستفيدين وتحديد التغطيات وطلب الخدمات ومتابعة حالة الزيارات فورياً.' }}
                    </p>
                </div>
            </div>

            {{-- Contracting Mechanism Workflow --}}
            <div id="contract-mechanism" class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 sm:p-12 space-y-8">
                <div class="border-b border-gray-100 pb-6 text-center space-y-2">
                    <h2 class="text-2xl font-black text-primary">
                        {{ $isEn ? 'Contracting Workflow & Execution Phases' : 'آلية التعاقد ومراحل التنفيذ التشغيلي' }}
                    </h2>
                    <p class="text-xs text-gray-400">
                        {{ $isEn ? '4 simple steps from request submission to live management of your company medical visits' : '4 خطوات بسيطة تبدأ من تقديم الطلب وتتيح لشركتكم إدارة كافة الزيارات الطبية للموظفين والمستفيدين' }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                    <div class="p-6 bg-surface rounded-2xl border border-gray-100 space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-primary text-white font-black text-base flex items-center justify-center mx-auto">1</div>
                        <h4 class="font-black text-sm text-primary">
                            {{ $isEn ? 'Submit Contract Request' : 'تقديم طلب التعاقد' }}
                        </h4>
                        <p class="text-xs text-gray-500">
                            {{ $isEn ? 'Fill the application form detailing expected staff count and required services.' : 'تعبئة نموذج طلب التعاقد وتحديد حجم المستفيدين والخدمات المطلوبة.' }}
                        </p>
                    </div>

                    <div class="p-6 bg-surface rounded-2xl border border-gray-100 space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-primary text-white font-black text-base flex items-center justify-center mx-auto">2</div>
                        <h4 class="font-black text-sm text-primary">
                            {{ $isEn ? 'Review & Custom Quote' : 'دراسة وتحديد الأسعار الخاصة' }}
                        </h4>
                        <p class="text-xs text-gray-500">
                            {{ $isEn ? 'Our team evaluates your needs and assigns a custom package with flexible terms.' : 'دراسة طلبكم وتعيين باقة تفضيلية بشروط دفع مرنة وتغطية مخصصة.' }}
                        </p>
                    </div>

                    <div class="p-6 bg-surface rounded-2xl border border-gray-100 space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-primary text-white font-black text-base flex items-center justify-center mx-auto">3</div>
                        <h4 class="font-black text-sm text-primary">
                            {{ $isEn ? 'Contract Approval & Portal Account' : 'اعتماد العقد وبوابة الشركة' }}
                        </h4>
                        <p class="text-xs text-gray-500">
                            {{ $isEn ? 'Finalize contract terms and set up corporate portal account for beneficiary management.' : 'تفعيل العقد وإنشاء حساب بوابة الشركة لإضافة قائمة الموظفين والمستفيدين.' }}
                        </p>
                    </div>

                    <div class="p-6 bg-surface rounded-2xl border border-gray-100 space-y-3">
                        <div class="w-10 h-10 rounded-xl bg-primary text-white font-black text-base flex items-center justify-center mx-auto">4</div>
                        <h4 class="font-black text-sm text-primary">
                            {{ $isEn ? 'Book Services & Track Visits' : 'طلب الخدمات ومتابعة الزيارات' }}
                        </h4>
                        <p class="text-xs text-gray-500">
                            {{ $isEn ? 'Request visits at contract rates, assign clinical staff, and review live reports.' : 'طلب الزيارات الطبية بأسعار العقد، إسناد الأطباء، ومتابعة النتائج المعتمدة.' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Contract Request Form --}}
            <div id="contract-request-form" class="bg-white rounded-3xl border border-gray-100 shadow-xl p-8 sm:p-12 space-y-8">
                <div class="border-b border-gray-100 pb-6 text-center space-y-2">
                    <h2 class="text-2xl font-black text-primary">
                        {{ $isEn ? 'Submit New Corporate Contract Application' : 'تقديم طلب تعاقد طبي جديد للشركات' }}
                    </h2>
                    <p class="text-xs text-gray-400">
                        {{ $isEn ? 'Please fill out the form below and a Medical Relations manager will reach out within 24 hours.' : 'يرجى تعبئة البيانات التالية وسيتم التواصل معكم من قِبل مسؤول العلاقات الطبية خلال 24 ساعة' }}
                    </p>
                </div>

                @if(session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold space-y-1">
                        <span class="block font-black">{{ $isEn ? 'Please correct the following errors:' : 'يرجى تصحيح الأخطاء التالية في النموذج:' }}</span>
                        <ul class="list-disc list-inside text-[11px] space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('corporate-services.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-2">
                                {{ $isEn ? 'Company / Enterprise Name' : 'اسم الشركة / المنشأة' }} <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="company_name" value="{{ old('company_name') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-xs font-bold focus:outline-none focus:border-primary">
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-2">
                                {{ $isEn ? 'Commercial Registration (CR) No. (Optional)' : 'رقم السجل التجاري (اختياري)' }}
                            </label>
                            <input type="text" name="cr_number" value="{{ old('cr_number') }}" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-2">
                                {{ $isEn ? 'Contact Person Name' : 'اسم المسؤول المباشر' }} <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="contact_person" value="{{ old('contact_person') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-xs font-bold focus:outline-none focus:border-primary">
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-2">
                                {{ $isEn ? 'Contact Phone Number' : 'رقم جوال التواصل' }} <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-2">
                                {{ $isEn ? 'Corporate Email Address' : 'البريد الإلكتروني للشركة' }} <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-2">
                                {{ $isEn ? 'City / Headquarters Location' : 'المدينة / المقر الرئيسي' }} <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="city" value="{{ old('city') }}" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-xs font-bold focus:outline-none focus:border-primary">
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-2">
                                {{ $isEn ? 'Estimated Number of Beneficiaries / Staff' : 'العدد التقديري للمستفيدين / الموظفين' }} <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="expected_beneficiaries" min="1" value="{{ old('expected_beneficiaries', 50) }}" required class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-xs font-bold focus:outline-none focus:border-primary dir-ltr {{ $isEn ? 'text-left' : 'text-right' }}">
                        </div>

                        <div>
                            <label class="text-xs font-bold text-gray-700 block mb-2">
                                {{ $isEn ? 'Requested Medical Services' : 'الخدمات الطبية المطلوبة' }}
                            </label>
                            <input type="text" name="requested_services" value="{{ old('requested_services') }}" placeholder="{{ $isEn ? 'e.g. Home Doctor Visits, Sample Collection, Checkups' : 'مثال: زيارات منزلية، سحب عينات، فحوصات دورية' }}" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-xs font-bold focus:outline-none focus:border-primary">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-2">
                            {{ $isEn ? 'Additional Requirements or Notes' : 'ملاحظات أو متطلبات إضافية' }}
                        </label>
                        <textarea name="notes" rows="3" class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 text-xs font-bold focus:outline-none focus:border-primary">{{ old('notes') }}</textarea>
                    </div>

                    <div class="text-center pt-4">
                        <button type="submit" class="px-10 py-4 bg-primary hover:bg-primary-hover text-white rounded-2xl font-black text-sm shadow-xl transition-all">
                            {{ $isEn ? 'Submit Contract Request Now' : 'إرسال طلب التعاقد الآن' }}
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
