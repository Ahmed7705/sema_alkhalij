<x-admin-layout title="سجل العمليات والأمان Audit Logs">
    <x-slot name="headerTitle">سجل تتبع العمليات وتأمين النظام Audit Activity Logs</x-slot>

    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-5 text-right">
        
        <div class="flex items-center justify-between">
            <h3 class="font-black text-base text-primary">سجل العمليات والإجراءات الحساسة ({{ $logs->total() }})</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-right border-collapse">
                <thead>
                    <tr class="bg-surface text-gray-700 font-bold border-b border-gray-200">
                        <th class="p-3">#</th>
                        <th class="p-3">المستخدم / المدير</th>
                        <th class="p-3">الإجراء المنفذ</th>
                        <th class="p-3">الكائن / العنصر المتأثر</th>
                        <th class="p-3">عنوان IP</th>
                        <th class="p-3">تاريخ ووقت التنفيذ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="p-3 font-bold text-gray-400">{{ $log->id }}</td>
                            <td class="p-3 font-black text-primary">{{ $log->user->name ?? 'نظام أوتوماتيكي' }}</td>
                            <td class="p-3 font-bold text-gray-800">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-primary/10 text-primary">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="p-3 font-bold text-gray-600 dir-ltr text-right">
                                {{ $log->model_type ? class_basename($log->model_type) . ' #' . $log->model_id : '-' }}
                            </td>
                            <td class="p-3 font-bold text-gray-600 dir-ltr text-right">{{ $log->ip_address }}</td>
                            <td class="p-3 font-bold text-gray-500">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-400 font-bold">لا توجد سجلات تتبع حالياً</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pt-2">
            {{ $logs->links() }}
        </div>

    </div>
</x-admin-layout>
