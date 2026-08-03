<x-app-layout title="المتجر الطبي | سيما الخليج">
    <section class="bg-gradient-to-br from-primary to-primary-dark text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="max-w-7xl mx-auto px-4 text-center relative z-10 space-y-4">
            <h1 class="text-4xl sm:text-5xl font-black">المتجر الطبي والمستلزمات</h1>
            <p class="text-medical-200 max-w-xl mx-auto">تسوق أحدث الأجهزة والمستلزمات الطبية المنزلية بأسعار تنافسية</p>
        </div>
    </section>
    <section class="py-16 bg-surface">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center py-20 space-y-4">
                <div class="w-20 h-20 mx-auto rounded-2xl bg-medical-50 text-accent flex items-center justify-center">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <h2 class="text-2xl font-bold text-primary">المتجر قيد الإعداد</h2>
                <p class="text-gray-500 text-sm max-w-md mx-auto">نعمل على إضافة المنتجات والمستلزمات الطبية. ترقبوا الإطلاق قريباً!</p>
                <a href="{{ url('/') }}" class="btn-primary py-3 px-6 rounded-xl text-sm inline-flex">العودة للرئيسية</a>
            </div>
        </div>
    </section>
</x-app-layout>
