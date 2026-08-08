@extends('layouts.admin')

@section('title', 'مراقبة صحة النظام والمهام الجانبية Queue Monitoring')

@section('content')
<div class="space-y-6" dir="rtl">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold font-alexandria text-slate-900">مراقبة صحة النظام والـ Queues والرسائل</h1>
            <p class="text-xs text-slate-500 mt-1">لوحة متابعة أداء المهام الجانبية، الإشعارات، وسجل التواصل والـ Webhooks</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.system.queues') }}" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow">
                إدارة الـ Queues والوظائف
            </a>
            <a href="{{ route('admin.system.webhooks') }}" class="bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold px-4 py-2.5 rounded-xl shadow">
                إدارة Webhooks
            </a>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <span class="text-xs text-slate-500 font-bold">المهام الفاشلة Failed Jobs</span>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-black {{ $failedJobsCount > 0 ? 'text-red-600' : 'text-slate-800' }}">{{ $failedJobsCount }}</span>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $failedJobsCount > 0 ? 'bg-red-100 text-red-700' : 'bg-emerald-100 text-emerald-700' }}">
                    {{ $failedJobsCount > 0 ? 'يتطلب انتباه' : 'سليم 100%' }}
                </span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <span class="text-xs text-slate-500 font-bold">المهام المنتظرة Pending Queue</span>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-black text-slate-800">{{ $pendingJobsCount }}</span>
                <span class="text-[10px] font-bold bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">معالجة خلفية</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <span class="text-xs text-slate-500 font-bold">إجمالي الرسائل المرُسلة</span>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-black text-emerald-600">{{ $totalNotificationsSent }}</span>
                <span class="text-[10px] font-bold bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full">Multi-Channel</span>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
            <span class="text-xs text-slate-500 font-bold">روابط الـ Webhooks</span>
            <div class="flex items-center justify-between">
                <span class="text-2xl font-black text-purple-600">{{ $webhooksCount }}</span>
                <span class="text-[10px] font-bold bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full">Active Drivers</span>
            </div>
        </div>
    </div>

    {{-- Channel Breakdown --}}
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-base font-bold text-slate-900">توزيع قنوات التواصل (Communication Channels)</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                <span class="text-xs text-slate-500 font-bold block">البريد الإلكتروني Email</span>
                <span class="text-xl font-bold text-slate-800 mt-1 block">{{ $emailCount }}</span>
            </div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                <span class="text-xs text-slate-500 font-bold block">رسائل النصية SMS</span>
                <span class="text-xl font-bold text-slate-800 mt-1 block">{{ $smsCount }}</span>
            </div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                <span class="text-xs text-slate-500 font-bold block">واتساب WhatsApp</span>
                <span class="text-xl font-bold text-slate-800 mt-1 block">{{ $whatsAppCount }}</span>
            </div>
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                <span class="text-xs text-slate-500 font-bold block">إشعارات Push</span>
                <span class="text-xl font-bold text-slate-800 mt-1 block">{{ $pushCount }}</span>
            </div>
        </div>
    </div>

    {{-- Recent Communication Log Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden space-y-4 p-6">
        <h3 class="text-base font-bold text-slate-900">سجل عمليات التوصيل الحديثة (Communication Logs)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold">
                    <tr>
                        <th class="p-3">القناة Channel</th>
                        <th class="p-3">المستلم</th>
                        <th class="p-3">الموضوع / العنوان</th>
                        <th class="p-3">المزود Driver</th>
                        <th class="p-3">الحالة</th>
                        <th class="p-3">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentCommunicationLogs as $log)
                        <tr>
                            <td class="p-3 font-mono font-bold uppercase text-slate-700">{{ $log->channel }}</td>
                            <td class="p-3 font-bold text-slate-800">{{ $log->recipient }}</td>
                            <td class="p-3 text-slate-600">{{ $log->subject ?? mb_substr($log->message, 0, 30) }}...</td>
                            <td class="p-3 font-mono text-slate-500">{{ $log->provider }}</td>
                            <td class="p-3">
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $log->status }}</span>
                            </td>
                            <td class="p-3 text-slate-400 font-mono">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-400">لا تتوفر سجلات توصيل حديثة.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
