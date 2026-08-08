<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
use App\Jobs\SendPushNotificationJob;
use App\Jobs\SendSmsJob;
use App\Jobs\SendWhatsAppJob;
use App\Models\AuditLog;
use App\Models\NotificationPreference;
use App\Models\User;
use Illuminate\Support\Facades\Notification as LaravelNotification;
use App\Notifications\GenericSystemNotification;

class NotificationEngine
{
    /**
     * Dispatch notification across all preferred channels for a user.
     *
     * @param User $user Target user
     * @param string $eventType Lifecycle event e.g. 'booking_created', 'invoice_created'
     * @param string $titleAr Arabic title
     * @param string $titleEn English title
     * @param string $messageAr Arabic message body
     * @param string $messageEn English message body
     * @param array $extraData Metadata payload
     */
    public function dispatch(
        User $user,
        string $eventType,
        string $titleAr,
        string $titleEn,
        string $messageAr,
        string $messageEn,
        array $extraData = []
    ): void {
        // Fetch or fallback user preference
        $pref = NotificationPreference::where('user_id', $user->id)
            ->where('event_type', $eventType)
            ->first();

        $inApp = $pref ? $pref->in_app : true;
        $email = $pref ? $pref->email : true;
        $sms = $pref ? $pref->sms : true;
        $whatsapp = $pref ? $pref->whatsapp : true;
        $push = $pref ? $pref->push : true;

        $isEn = app()->getLocale() === 'en';
        $title = $isEn ? $titleEn : $titleAr;
        $message = $isEn ? $messageEn : $messageAr;

        // 1. In-App Notification
        if ($inApp) {
            $user->notify(new GenericSystemNotification(
                $eventType,
                $titleAr,
                $titleEn,
                $messageAr,
                $messageEn,
                $extraData
            ));

            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'CREATE_NOTIFICATION',
                'details' => json_encode(['event_type' => $eventType, 'title' => $title]),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        }

        // 2. Email Channel via Queue
        if ($email && !empty($user->email)) {
            SendEmailJob::dispatch(
                $user->email,
                $title,
                $message,
                $user->id
            );
        }

        // 3. SMS Channel via Queue
        if ($sms && !empty($user->phone)) {
            SendSmsJob::dispatch(
                $user->phone,
                $message,
                $user->id
            );
        }

        // 4. WhatsApp Channel via Queue
        if ($whatsapp && !empty($user->phone)) {
            SendWhatsAppJob::dispatch(
                $user->phone,
                $message,
                $user->id
            );
        }

        // 5. Push Notification Channel via Queue
        if ($push) {
            SendPushNotificationJob::dispatch(
                $user->id,
                $title,
                $message,
                $extraData
            );
        }

        // 6. Dispatch Outgoing Webhook if configured
        app(WebhookService::class)->dispatchOutgoing($eventType, [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'event_type' => $eventType,
            'title' => $title,
            'message' => $message,
            'extra' => $extraData,
        ]);
    }
}
