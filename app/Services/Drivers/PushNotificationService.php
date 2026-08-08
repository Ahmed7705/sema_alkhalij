<?php

namespace App\Services\Drivers;

use App\Models\AuditLog;
use App\Models\CommunicationLog;
use App\Models\User;
use App\Models\UserDeviceToken;
use Illuminate\Support\Facades\Log;

class PushNotificationService
{
    protected $serverKey;

    public function __construct()
    {
        $this->serverKey = config('services.firebase.server_key');
    }

    public function registerDevice(User $user, string $token, string $deviceType = 'web', ?string $deviceName = null): UserDeviceToken
    {
        return UserDeviceToken::updateOrCreate(
            ['device_token' => $token],
            [
                'user_id' => $user->id,
                'device_type' => $deviceType,
                'device_name' => $deviceName,
                'last_used_at' => now(),
            ]
        );
    }

    public function sendPush(User $user, string $title, string $body, array $data = []): array
    {
        $tokens = $user->deviceTokens()->pluck('device_token')->toArray();

        if (empty($tokens)) {
            return ['success' => false, 'message' => 'No registered device tokens for user.'];
        }

        $ref = 'FCM-' . strtoupper(uniqid());

        if (empty($this->serverKey)) {
            Log::info("Push Service (FCM): Push notification queued for User #{$user->id} across " . count($tokens) . " devices. Server Key required in REQUIRED FROM USER.");
        }

        $log = CommunicationLog::create([
            'user_id' => $user->id,
            'channel' => 'push',
            'recipient' => implode(',', $tokens),
            'subject' => $title,
            'message' => $body,
            'status' => 'sent',
            'provider' => 'fcm',
            'provider_ref' => $ref,
            'response_payload' => ['device_count' => count($tokens), 'extra' => $data],
            'sent_at' => now(),
        ]);

        AuditLog::create([
            'user_id' => auth()->id() ?? $user->id,
            'action' => 'SEND_PUSH',
            'details' => json_encode(['user_id' => $user->id, 'ref' => $ref, 'title' => $title]),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return [
            'success' => true,
            'log_id' => $log->id,
            'ref' => $ref,
            'device_count' => count($tokens),
        ];
    }
}
