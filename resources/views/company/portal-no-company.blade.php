@php
    $isEn = app()->getLocale() == 'en';
@endphp

<x-admin-layout title="{{ $isEn ? 'Corporate Portal — No Companies' : 'بوابة الشركات — لا توجد شركات' }}">
    <x-slot name="headerTitle">{{ $isEn ? 'Corporate Portal' : 'بوابة الشركات والتعاقدات' }}</x-slot>

    <div class="flex items-center justify-center min-h-[60vh] {{ $isEn ? 'dir-ltr text-left' : 'dir-rtl text-right' }}">
        <div class="text-center max-w-lg mx-auto space-y-6 px-4">

            {{-- Icon --}}
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gray-100 text-gray-400 mx-auto">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                </svg>
            </div>

            {{-- Title --}}
            <div class="space-y-2">
                <h1 class="text-2xl font-black text-gray-800">
                    {{ $isEn ? 'No Corporate Entities Found' : 'لا توجد شركات متعاقدة في النظام' }}
                </h1>
                <p class="text-sm text-gray-500 font-medium leading-relaxed">
                    {{ $isEn
                        ? 'The system has no registered corporate entities yet. Please create the first company to enable the corporate services portal.'
                        : 'لم يتم تسجيل أي شركة متعاقدة في النظام حتى الآن. يرجى إنشاء الشركة الأولى لتفعيل بوابة الخدمات التعاقدية.' }}
                </p>
            </div>

            {{-- Alert --}}
            <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl" dir="{{ $isEn ? 'ltr' : 'rtl' }}">
                <p class="text-xs font-bold text-amber-700 {{ $isEn ? 'text-left' : 'text-right' }}">
                    {{ $isEn
                        ? '⚠️ This portal requires at least one active corporate entity and one active contract to function. No data is auto-generated.'
                        : '⚠️ هذه البوابة تتطلب وجود شركة نشطة وعقد ساري فعلي. لا يتم إنشاء بيانات وهمية تلقائيًا.' }}
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('admin.companies.create') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-[#006C35] hover:bg-[#00572B] text-white font-extrabold text-sm rounded-2xl shadow-lg transition-all hover:scale-[1.02]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    {{ $isEn ? 'Create First Corporate Entity' : 'إنشاء أول شركة متعاقدة' }}
                </a>
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-sm rounded-2xl transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    {{ $isEn ? 'Back to Dashboard' : 'العودة للوحة التحكم' }}
                </a>
            </div>

        </div>
    </div>
</x-admin-layout>
