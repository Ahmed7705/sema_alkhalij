<?php

namespace Tests\Feature;

use App\Jobs\DispatchWebhookJob;
use App\Jobs\GeneratePdfReportJob;
use App\Jobs\SendEmailJob;
use App\Jobs\SendPushNotificationJob;
use App\Jobs\SendSmsJob;
use App\Jobs\SendWhatsAppJob;
use App\Models\ActivityLog;
use App\Models\AuditLog;
use App\Models\CommunicationLog;
use App\Models\NotificationPreference;
use App\Models\User;
use App\Models\UserDeviceToken;
use App\Models\Webhook;
use App\Models\WebhookLog;
use App\Services\NotificationEngine;
use App\Services\WebhookService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class Phase10NotificationsCommunicationJobsTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $patient;
    protected $otherPatient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->patient = User::factory()->create([
            'role' => 'patient',
            'email' => 'patient@sema.med',
            'phone' => '0590000001',
        ]);
        $this->otherPatient = User::factory()->create([
            'role' => 'patient',
            'email' => 'other@sema.med',
            'phone' => '0590000002',
        ]);
    }

    public function test_user_can_access_notification_center_and_mark_as_read()
    {
        // Engine dispatches in-app notification
        $engine = new NotificationEngine();
        $engine->dispatch(
            $this->patient,
            'booking_created',
            'تأكيد الحجز الطبي',
            'Booking Confirmed',
            'تم تأكيد حجز الخدمة الطبية بنجاح.',
            'Your medical service booking has been confirmed.'
        );

        $this->assertEquals(1, $this->patient->unreadNotifications()->count());

        $notificationId = $this->patient->unreadNotifications()->first()->id;

        // Mark as read
        $response = $this->actingAs($this->patient)->post(route('notifications.read', $notificationId));
        $response->assertRedirect();

        $this->assertEquals(0, $this->patient->fresh()->unreadNotifications()->count());
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'READ_NOTIFICATION',
            'user_id' => $this->patient->id,
        ]);
    }

    public function test_user_can_mark_all_notifications_as_read()
    {
        $engine = new NotificationEngine();
        $engine->dispatch($this->patient, 'invoice_created', 'عنوان 1', 'Title 1', 'نص 1', 'Text 1');
        $engine->dispatch($this->patient, 'lab_result', 'عنوان 2', 'Title 2', 'نص 2', 'Text 2');

        $this->assertEquals(2, $this->patient->unreadNotifications()->count());

        $response = $this->actingAs($this->patient)->post(route('notifications.read-all'));
        $response->assertRedirect();

        $this->assertEquals(0, $this->patient->fresh()->unreadNotifications()->count());
    }

    public function test_user_can_configure_notification_channel_preferences()
    {
        $response = $this->actingAs($this->patient)->post(route('notifications.preferences.update'), [
            'preferences' => [
                'booking_created' => [
                    'in_app' => 1,
                    'email' => 1,
                    'sms' => 0,
                    'whatsapp' => 1,
                    'push' => 0,
                ]
            ]
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('notification_preferences', [
            'user_id' => $this->patient->id,
            'event_type' => 'booking_created',
            'in_app' => 1,
            'email' => 1,
            'sms' => 0,
            'whatsapp' => 1,
            'push' => 0,
        ]);
    }

    public function test_push_notification_device_token_registration()
    {
        $response = $this->actingAs($this->patient)->postJson(route('notifications.device-token'), [
            'device_token' => 'FCM_SAMPLE_TOKEN_999',
            'device_type' => 'android',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('user_device_tokens', [
            'user_id' => $this->patient->id,
            'device_token' => 'FCM_SAMPLE_TOKEN_999',
            'device_type' => 'android',
        ]);
    }

    public function test_queue_jobs_execution_and_communication_logging()
    {
        // 1. SendEmailJob
        $emailJob = new SendEmailJob('patient@sema.med', 'مرحباً بك', 'نص البريد الإلكتروني', $this->patient->id);
        $emailJob->handle();

        $this->assertDatabaseHas('communication_logs', [
            'user_id' => $this->patient->id,
            'channel' => 'email',
            'recipient' => 'patient@sema.med',
        ]);

        // 2. SendSmsJob
        $smsService = new \App\Services\Drivers\SmsService();
        $smsJob = new SendSmsJob('0590000001', 'تأكيد الحجز SMS', $this->patient->id);
        $smsJob->handle($smsService);

        $this->assertDatabaseHas('communication_logs', [
            'user_id' => $this->patient->id,
            'channel' => 'sms',
            'recipient' => '0590000001',
        ]);

        // 3. SendWhatsAppJob
        $waService = new \App\Services\Drivers\WhatsAppService();
        $waJob = new SendWhatsAppJob('0590000001', 'تأكيد الحجز WhatsApp', $this->patient->id);
        $waJob->handle($waService);

        $this->assertDatabaseHas('communication_logs', [
            'user_id' => $this->patient->id,
            'channel' => 'whatsapp',
            'recipient' => '0590000001',
        ]);

        // 4. SendPushNotificationJob
        UserDeviceToken::create([
            'user_id' => $this->patient->id,
            'device_token' => 'TOKEN_PUSH_123',
            'device_type' => 'ios',
        ]);
        $pushService = new \App\Services\Drivers\PushNotificationService();
        $pushJob = new SendPushNotificationJob($this->patient->id, 'تنبيه', 'إشعار لحظي push');
        $pushJob->handle($pushService);

        $this->assertDatabaseHas('communication_logs', [
            'user_id' => $this->patient->id,
            'channel' => 'push',
        ]);
    }

    public function test_failed_queue_job_creates_audit_log()
    {
        $job = new SendEmailJob('invalid-email', 'اختبار الفشل', 'محتوى', $this->patient->id);
        $job->failed(new \Exception('SMTP Connection Error'));

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'QUEUE_JOB_FAILED',
        ]);
    }

    public function test_scheduler_commands_execution()
    {
        Artisan::call('sema:check-low-stock');
        Artisan::call('sema:check-expiry-alerts');

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'SCHEDULE_EXECUTED',
        ]);
    }


    public function test_webhooks_incoming_and_outgoing_processing()
    {
        // 1. Outgoing Webhook
        $webhook = Webhook::create([
            'name' => 'CRM External System',
            'type' => 'outgoing',
            'url' => 'https://api.external-crm.com/webhook',
            'secret' => 'secret_key_123',
            'events' => ['booking_created'],
            'is_active' => true,
        ]);

        $webhookService = new WebhookService();
        $results = $webhookService->dispatchOutgoing('booking_created', ['booking_id' => 101]);

        $this->assertCount(1, $results);
        $this->assertDatabaseHas('audit_logs', [
            'action' => 'WEBHOOK_SENT',
        ]);

        // 2. Incoming Webhook API
        $response = $this->postJson(route('api.webhooks.incoming'), [
            'event' => 'payment_received_external',
            'amount' => 500,
        ], ['X-Sema-Event' => 'payment_received_external']);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('webhook_logs', [
            'type' => 'incoming',
            'event' => 'payment_received_external',
        ]);
    }

    public function test_user_activity_timeline_feed()
    {
        ActivityLog::create([
            'user_id' => $this->patient->id,
            'activity_type' => 'booking',
            'description_ar' => 'تم إنشاء حجز زيارة منزلية جديدة',
            'description_en' => 'New home visit booking created',
            'ip_address' => '127.0.0.1',
        ]);

        $response = $this->actingAs($this->patient)->get(route('profile.activity'));
        $response->assertStatus(200);
        $response->assertSee('حجز زيارة منزلية جديدة');
    }

    public function test_admin_can_access_system_health_and_queue_monitoring()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.system.health'));
        $response->assertStatus(200);
        $response->assertSee('مراقبة صحة النظام');

        $responseQueue = $this->actingAs($this->admin)->get(route('admin.system.queues'));
        $responseQueue->assertStatus(200);

        $responseWebhooks = $this->actingAs($this->admin)->get(route('admin.system.webhooks'));
        $responseWebhooks->assertStatus(200);
    }

    public function test_unauthorized_user_cannot_access_system_health_monitoring()
    {
        $response = $this->actingAs($this->patient)->get(route('admin.system.health'));
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }
}
