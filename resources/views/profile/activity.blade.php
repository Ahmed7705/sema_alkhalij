@extends('layouts.app')

@section('title', __('سجل النشاط والعمليات التاريخية'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold font-alexandria text-slate-900">{{ __('سجل النشاط والعمليات التاريخية') }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ __('جدول زمني يوثق جميع التفاعلات والعمليات والحجوزات والتقارير') }}</p>
        </div>
        <a href="{{ route('profile') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-slate-100 px-4 py-2 rounded-xl">
            &larr; {{ __('الملف الشخصي') }}
        </a>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-6">
        <div class="relative border-r border-slate-200 pr-6 space-y-6" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
            @forelse($activities as $activity)
                @php
                    $isEn = app()->getLocale() == 'en';
                    $desc = $isEn ? ($activity->description_en ?? $activity->description_ar) : $activity->description_ar;
                @endphp
                <div class="relative flex items-start justify-between gap-4">
                    <div class="absolute -right-[31px] top-1 w-3 h-3 rounded-full bg-blue-600 ring-4 ring-blue-100"></div>
                    <div class="space-y-1">
                        <span class="text-[10px] font-mono uppercase bg-slate-100 text-slate-600 px-2 py-0.5 rounded">{{ $activity->activity_type }}</span>
                        <h4 class="text-sm font-bold text-slate-900 mt-1">{{ $desc }}</h4>
                        @if($activity->ip_address)
                            <p class="text-[10px] text-slate-400 font-mono">IP: {{ $activity->ip_address }}</p>
                        @endif
                    </div>
                    <span class="text-[10px] text-slate-400 shrink-0 font-medium">{{ $activity->created_at->format('Y-m-d H:i') }}</span>
                </div>
            @empty
                <div class="text-center text-slate-400 py-8 text-xs">
                    {{ __('لا يوجد نشاط تاريخي مسجل بعد.') }}
                </div>
            @endforelse
        </div>

        <div class="pt-4 border-t border-slate-100">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection
