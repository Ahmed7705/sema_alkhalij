@extends('layouts.app')

@section('title', __('تفضيلات الإشعارات والتواصل'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold font-alexandria text-slate-900">{{ __('تفضيلات الإشعارات والتواصل') }}</h1>
            <p class="text-xs text-slate-500 mt-1">{{ __('حدد القنوات المفضلة لاستلام التنبيهات الخاصة بكل حدث') }}</p>
        </div>
        <a href="{{ route('notifications.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-slate-100 px-4 py-2 rounded-xl">
            &larr; {{ __('العودة للإشعارات') }}
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 text-emerald-800 rounded-2xl border border-emerald-200 text-xs font-bold">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('notifications.preferences.update') }}" method="POST" class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-6">
        @csrf
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-500 uppercase tracking-wider font-bold">
                        <th class="p-3">{{ __('نوع الحدث') }}</th>
                        <th class="p-3 text-center">In-App</th>
                        <th class="p-3 text-center">Email</th>
                        <th class="p-3 text-center">SMS</th>
                        <th class="p-3 text-center">WhatsApp</th>
                        <th class="p-3 text-center">Push</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($events as $eventKey => $eventLabel)
                        @php
                            $pref = $preferences[$eventKey] ?? null;
                            $inApp = $pref ? $pref->in_app : true;
                            $email = $pref ? $pref->email : true;
                            $sms = $pref ? $pref->sms : true;
                            $whatsapp = $pref ? $pref->whatsapp : true;
                            $push = $pref ? $pref->push : true;
                        @endphp
                        <tr>
                            <td class="p-3 font-bold text-slate-800">{{ $eventLabel }}</td>
                            <td class="p-3 text-center">
                                <input type="checkbox" name="preferences[{{ $eventKey }}][in_app]" value="1" {{ $inApp ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600">
                            </td>
                            <td class="p-3 text-center">
                                <input type="checkbox" name="preferences[{{ $eventKey }}][email]" value="1" {{ $email ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600">
                            </td>
                            <td class="p-3 text-center">
                                <input type="checkbox" name="preferences[{{ $eventKey }}][sms]" value="1" {{ $sms ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600">
                            </td>
                            <td class="p-3 text-center">
                                <input type="checkbox" name="preferences[{{ $eventKey }}][whatsapp]" value="1" {{ $whatsapp ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600">
                            </td>
                            <td class="p-3 text-center">
                                <input type="checkbox" name="preferences[{{ $eventKey }}][push]" value="1" {{ $push ? 'checked' : '' }} class="rounded border-slate-300 text-blue-600">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition shadow">
                {{ __('حفظ التفضيلات') }}
            </button>
        </div>
    </form>
</div>
@endsection
