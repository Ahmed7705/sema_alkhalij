@extends('layouts.app')

@section('title', __('مركز الإشعارات والتنبيهات'))

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
        <div>
            <h1 class="text-2xl font-bold font-alexandria text-slate-900">{{ __('مركز الإشعارات والتنبيهات') }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ __('تتبع التحديثات الطبية، الفواتير، وحالة الخدمات الخاصة بك') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('notifications.preferences') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 text-slate-700 hover:bg-slate-200 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>{{ __('إعدادات الإشعارات') }}</span>
            </a>
            @if($unreadCount > 0)
                <form action="{{ route('notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-emerald-600 text-white hover:bg-emerald-500 transition shadow">
                        {{ __('تعيين الكل كمقروء') }} ({{ $unreadCount }})
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 text-emerald-800 rounded-2xl border border-emerald-200 text-xs font-bold">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter & Search Bar --}}
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row gap-4 items-center justify-between">
        <form action="{{ route('notifications.index') }}" method="GET" class="flex items-center gap-3 w-full sm:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('بحث في الإشعارات...') }}" class="border-slate-200 rounded-xl text-xs p-2.5 w-64">
            <select name="category" onchange="this.form.submit()" class="border-slate-200 rounded-xl text-xs p-2.5">
                <option value="">{{ __('جميع الفئات') }}</option>
                <option value="booking_created" {{ request('category') == 'booking_created' ? 'selected' : '' }}>الحجوزات</option>
                <option value="visit_status_changed" {{ request('category') == 'visit_status_changed' ? 'selected' : '' }}>الزيارات</option>
                <option value="medical_report_uploaded" {{ request('category') == 'medical_report_uploaded' ? 'selected' : '' }}>التقارير الطبية</option>
                <option value="invoice_created" {{ request('category') == 'invoice_created' ? 'selected' : '' }}>الفواتير</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-bold">{{ __('بحث') }}</button>
        </form>
    </div>

    {{-- Notifications List --}}
    <div class="space-y-3">
        @forelse($notifications as $notification)
            @php
                $data = $notification->data;
                $isUnread = is_null($notification->read_at);
                $isEn = app()->getLocale() == 'en';
                $title = $isEn ? ($data['title_en'] ?? $data['title_ar'] ?? '') : ($data['title_ar'] ?? '');
                $msg = $isEn ? ($data['message_en'] ?? $data['message_ar'] ?? '') : ($data['message_ar'] ?? '');
            @endphp
            <div class="bg-white p-5 rounded-2xl border {{ $isUnread ? 'border-blue-200 bg-blue-50/30' : 'border-slate-100' }} shadow-sm flex items-start justify-between gap-4 transition hover:border-slate-200">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 {{ $isUnread ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-500' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-bold text-slate-900">{{ $title }}</h3>
                            @if($isUnread)
                                <span class="bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ __('جديد') }}</span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">{{ $msg }}</p>
                        <span class="text-[10px] text-slate-400 block pt-1">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    @if($isUnread)
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-bold text-blue-600 hover:underline">{{ __('تحديد كمقروء') }}</button>
                        </form>
                    @endif
                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('{{ __('هل أنت تأكد من حذف الإشعار؟') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-red-500 hover:text-red-700 p-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white p-12 rounded-3xl text-center text-slate-400 border border-slate-100">
                {{ __('لا توجد إشعارات مسجلة بعد.') }}
            </div>
        @endforelse
    </div>

    <div class="pt-4">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
