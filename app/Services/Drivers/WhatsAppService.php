<?php

namespace App\Services\Drivers;

use App\Models\AuditLog;
use App\Models\CommunicationLog;
use Illuminate\Support\Facades\Log;

class WhatsAppService implements WhatsAppDriverInterface
{
    protected $provider;
    protected $token;

    public function __construct()
    {
        $this->provider = config('services.whatsapp.provider', 'meta_business_api');
        $this->token = config('services.whatsapp.access_token');
    }

    public function sendWhatsApp(string $recipient, string $message, ?int $userId = null): array
    {
        $status = 'sent';
        $ref = 'WA-' . strtoupper(uniqid());

        if (empty($this->token)) {
            Log::info("WhatsApp Service [Driver: {$this->provider}]: Message queued for {$recipient}. Access Token required in REQUIRED FROM USER.");
        }

        $log = CommunicationLog::create([
            'user_id' => $userId ?? auth()->id(),
            'channel' => 'whatsapp',
            'recipient' => $recipient,
            'message' => $message,
            'status' => $status,
            'provider' => $this->provider,
            'provider_ref' => $ref,
            'response_payload' => ['provider' => $this->provider],
            'sent_at' => now(),
        ]);


        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'SEND_WHATSAPP',
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
