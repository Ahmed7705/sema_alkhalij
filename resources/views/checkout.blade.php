<x-app-layout title="إتمام الشراء والفوترة | سيما الخليج">

    {{-- Header --}}
    <section class="py-12 bg-gradient-to-br from-[#071f18] via-primary to-[#0a3428] text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-2">
            <h1 class="text-3xl font-black">إتمام طلب الشراء والفوترة الإلكترونية</h1>
            <p class="text-xs text-medical-200">أدخل عنوان الشحن واختر طريقة الدفع لإتمام الطلب وإصدار الفاتورة المعتمدة</p>
        </div>
    </section>

    {{-- Livewire Checkout Component --}}
    @livewire('checkout')

</x-app-layout>
