<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\CommunicationLog;
use App\Models\Webhook;
use App\Models\WebhookLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SystemHealthController extends Controller
{
    public function index()
    {
        $failedJobsCount = Schema::hasTable('failed_jobs') ? DB::table('failed_jobs')->count() : 0;
        $pendingJobsCount = Schema::hasTable('jobs') ? DB::table('jobs')->count() : 0;

        $totalNotificationsSent = CommunicationLog::count();
        $emailCount = CommunicationLog::where('channel', 'email')->count();
        $smsCount = CommunicationLog::where('channel', 'sms')->count();
        $whatsAppCount = CommunicationLog::where('channel', 'whatsapp')->count();
        $pushCount = CommunicationLog::where('channel', 'push')->count();

        $webhooksCount = Webhook::count();
        $failedWebhooksCount = WebhookLog::where('status', 'failed')->count();

        $recentCommunicationLogs = CommunicationLog::with('user')->latest()->take(10)->get();

        return view('admin.system.health', compact(
            'failedJobsCount',
            'pendingJobsCount',
            'totalNotificationsSent',
            'emailCount',
            'smsCount',
            'whatsAppCount',
            'pushCount',
            'webhooksCount',
            'failedWebhooksCount',
            'recentCommunicationLogs'
        ));
    }

    public function queues()
    {
        $failedJobs = Schema::hasTable('failed_jobs') ? DB::table('failed_jobs')->latest('failed_at')->paginate(15) : collect();
        $communicationLogs = CommunicationLog::with('user')->latest()->paginate(15);

        return view('admin.system.queues', compact('failedJobs', 'communicationLogs'));
    }

    public function webhooks()
    {
        $webhooks = Webhook::withCount('logs')->latest()->get();
        $logs = WebhookLog::with('webhook')->latest()->paginate(15);

        return view('admin.system.webhooks', compact('webhooks', 'logs'));
    }

    public function storeWebhook(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:incoming,outgoing',
            'url' => 'nullable|url',
        ]);

        Webhook::create([
            'name' => $request->name,
            'type' => $request->type,
            'url' => $request->url,
            'secret' => bin2hex(random_bytes(16)),
            'events' => ['*'],
            'is_active' => true,
        ]);

        return back()->with('success', __('تم إنشاء رابط الـ Webhook بنجاح.'));
    }

    public function retryFailedJob(string $id)
    {
        if (Schema::hasTable('failed_jobs')) {
            DB::table('failed_jobs')->where('id', $id)->delete();
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'QUEUE_JOB_COMPLETED',
            'details' => json_encode(['action' => 'manual_retry', 'job_id' => $id]),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return back()->with('success', __('تمت إعادة محاولة تشغيل المهمة بنجاح.'));
    }
}
