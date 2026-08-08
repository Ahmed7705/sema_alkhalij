@extends('layouts.admin')

@section('title', 'إدارة المهام الجانبية والوظائف الفاشلة Queues & Failed Jobs')

@section('content')
<div class="space-y-6" dir="rtl">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold font-alexandria text-slate-900">إدارة الـ Queues والسجلات</h1>
            <p class="text-xs text-slate-500 mt-1">عرض الوظائف الفاشلة وإمكانية إعادة محاولة التشغيل ومتابعة التوصيل</p>
        </div>
        <a href="{{ route('admin.system.health') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900 bg-slate-100 px-4 py-2 rounded-xl">
            &larr; لوحة المراقبة
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 text-emerald-800 rounded-2xl border border-emerald-200 text-xs font-bold">
            {{ session('success') }}
        </div>
    @endif

    {{-- Communication Logs Table --}}
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-base font-bold text-slate-900">سجل عمليات التوصيل الكلي (Communication Logs)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">القناة Channel</th>
                        <th class="p-3">المستلم</th>
                        <th class="p-3">المحتوى</th>
                        <th class="p-3">المزود Provider</th>
                        <th class="p-3">المرجع Ref</th>
                        <th class="p-3">الحالة</th>
                        <th class="p-3">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($communicationLogs as $log)
                        <tr>
                            <td class="p-3 font-mono text-slate-400">#{{ $log->id }}</td>
                            <td class="p-3 font-bold uppercase text-slate-700">{{ $log->channel }}</td>
                            <td class="p-3 font-bold text-slate-900">{{ $log->recipient }}</td>
                            <td class="p-3 text-slate-600">{{ mb_substr($log->message, 0, 40) }}...</td>
                            <td class="p-3 font-mono text-slate-500">{{ $log->provider ?? 'System' }}</td>
                            <td class="p-3 font-mono text-slate-400">{{ $log->provider_ref }}</td>
                            <td class="p-3">
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $log->status }}</span>
                            </td>
                            <td class="p-3 text-slate-400 font-mono">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-6 text-center text-slate-400">لا توجد سجلات تواصل بعد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pt-4 border-t border-slate-100">
            {{ $communicationLogs->links() }}
        </div>
    </div>
</div>
@endsection
