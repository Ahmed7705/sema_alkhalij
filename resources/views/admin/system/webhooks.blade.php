@extends('layouts.admin')

@section('title', 'إدارة Webhooks وسجلات الاستدعاء الخارجية')

@section('content')
<div class="space-y-6" dir="rtl">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold font-alexandria text-slate-900">إدارة Webhooks وسجلات الأحداث External Webhooks</h1>
            <p class="text-xs text-slate-500 mt-1">تكوين ومتابعة مسارات الـ Incoming & Outgoing Webhooks مع ميزات HMAC Signature</p>
        </div>
        <button onclick="document.getElementById('newWebhookModal').classList.remove('hidden')" class="bg-blue-600 hover:bg-blue-500 text-white font-medium px-4 py-2.5 rounded-xl text-xs transition shadow">
            + إضافة Webhook جديد
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 text-emerald-800 rounded-2xl border border-emerald-200 text-xs font-bold">
            {{ session('success') }}
        </div>
    @endif

    {{-- Webhooks Directory Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($webhooks as $wh)
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-xs font-mono uppercase bg-slate-100 text-slate-600 px-2 py-0.5 rounded">{{ $wh->type }}</span>
                        <h3 class="text-lg font-bold text-slate-800 mt-1">{{ $wh->name }}</h3>
                        <p class="text-xs text-slate-500 font-mono truncate max-w-xs">{{ $wh->url ?? 'API Endpoint (/api/v1/webhooks/incoming)' }}</p>
                    </div>
                    <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-2.5 py-1 rounded-full">نشط</span>
                </div>
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600">
                    <span>عدد الاستدعاءات:</span>
                    <span class="font-bold text-slate-900 text-sm">{{ $wh->logs_count }} سجل</span>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white p-8 rounded-2xl text-center text-slate-400 border border-slate-200">
                لا توجد روابط Webhooks مسجلة بعد.
            </div>
        @endforelse
    </div>

    {{-- Webhook Logs Table --}}
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-base font-bold text-slate-900">سجل استدعاءات الـ Webhooks (Webhook Logs)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead class="bg-slate-50 text-slate-600 font-bold">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">النوع Type</th>
                        <th class="p-3">اسم الحدث Event</th>
                        <th class="p-3">الرابط Target URL</th>
                        <th class="p-3">كود الاستجابة Code</th>
                        <th class="p-3">الحالة Status</th>
                        <th class="p-3">التاريخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($logs as $log)
                        <tr>
                            <td class="p-3 font-mono text-slate-400">#{{ $log->id }}</td>
                            <td class="p-3 font-bold uppercase text-slate-700">{{ $log->type }}</td>
                            <td class="p-3 font-bold text-slate-900">{{ $log->event }}</td>
                            <td class="p-3 text-slate-600 font-mono">{{ $log->url }}</td>
                            <td class="p-3 font-mono text-slate-800">{{ $log->status_code ?? 200 }}</td>
                            <td class="p-3">
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $log->status }}</span>
                            </td>
                            <td class="p-3 text-slate-400 font-mono">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-slate-400">لا توجد سجلات استدعاء بعد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pt-4 border-t border-slate-100">
            {{ $logs->links() }}
        </div>
    </div>
</div>

<!-- Modal -->
<div id="newWebhookModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-2xl p-6 w-full max-w-md shadow-2xl space-y-4 text-right" dir="rtl">
        <h3 class="text-lg font-bold text-slate-900">إضافة Webhook جديد</h3>
        <form action="{{ route('admin.system.webhooks.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">اسم الرابط / النظام المصدر</label>
                <input type="text" name="name" required placeholder="CRM Integration Webhook" class="w-full border-slate-200 rounded-xl p-2.5 text-sm">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">نوع المسار Type</label>
                <select name="type" required class="w-full border-slate-200 rounded-xl p-2.5 text-sm">
                    <option value="outgoing">صادر (Outgoing Webhook)</option>
                    <option value="incoming">وارد (Incoming Webhook)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">الرابط المستهدف Target URL</label>
                <input type="url" name="url" placeholder="https://api.external.com/webhooks" class="w-full border-slate-200 rounded-xl p-2.5 text-sm font-mono">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="document.getElementById('newWebhookModal').classList.add('hidden')" class="px-4 py-2 text-sm text-slate-600">إلغاء</button>
                <button type="submit" class="bg-blue-600 text-white font-medium px-4 py-2 rounded-xl text-sm">حفظ وتوليد المفتاح</button>
            </div>
        </form>
    </div>
</div>
@endsection
