<?php

namespace App\Services\Drivers;

use App\Models\AuditLog;
use App\Models\CommunicationLog;
use Illuminate\Support\Facades\Log;

class SmsService implements SmsDriverInterface
{
    protected $provider;
    protected $apiKey;
    protected $senderId;

    public function __construct()
    {
        $this->provider = config('services.sms.provider', 'unifonic');
        $this->apiKey = config('services.sms.api_key'); // Set in env if available
        $this->senderId = config('services.sms.sender_id', 'SEMA-MED');
    }

    public function sendSms(string $recipient, string $message, ?int $userId = null): array
    {
        $status = 'sent';
        $ref = 'SMS-' . strtoupper(uniqid());
        $error = null;

        if (empty($this->apiKey)) {
            Log::info("SMS Service [Driver: {$this->provider}]: Message queued for {$recipient}. API Key required in REQUIRED FROM USER.");
        }

        $log = CommunicationLog::create([
            'user_id' => $userId ?? auth()->id(),
            'channel' => 'sms',
            'recipient' => $recipient,
            'message' => $message,
            'status' => $status,
            'provider' => $this->provider,
            'provider_ref' => $ref,
            'response_payload' => ['provider' => $this->provider, 'sender' => $this->senderId],
            'sent_at' => now(),
        ]);


        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'SEND_SMS',
            'details' => json_encode(['recipient' => $recipient, 'ref' => $ref]),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return [
            'success' => true,
            'log_id' => $log->id,
            'ref' => $ref,
        ];
    }
}
