<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Webhook;
use App\Models\WebhookLog;
use Illuminate\Support\Facades\Http;

class WebhookService
{
    public function dispatchOutgoing(string $event, array $payload): array
    {
        $webhooks = Webhook::where('type', 'outgoing')
            ->where('is_active', true)
            ->get();

        $results = [];

        foreach ($webhooks as $webhook) {
            if (!empty($webhook->events) && !in_array('*', $webhook->events) && !in_array($event, $webhook->events)) {
                continue;
            }

            $signature = hash_hmac('sha256', json_encode($payload), $webhook->secret ?? 'default_secret');
            $headers = [
                'Content-Type' => 'application/json',
                'X-Sema-Signature' => $signature,
                'X-Sema-Event' => $event,
            ];

            $log = WebhookLog::create([
                'webhook_id' => $webhook->id,
                'type' => 'outgoing',
                'event' => $event,
                'url' => $webhook->url,
                'headers' => $headers,
                'payload' => $payload,
                'status' => 'pending',
                'attempts' => 1,
            ]);

            try {
                // In testing/production environment, dispatch HTTP POST
                $response = Http::withHeaders($headers)->timeout(5)->post($webhook->url, $payload);
                $log->update([
                    'status_code' => $response->status(),
                    'status' => $response->successful() ? 'success' : 'failed',
                    'error_message' => $response->successful() ? null : $response->body(),
                ]);
            } catch (\Exception $e) {
                $log->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);
            }

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'WEBHOOK_SENT',
                'details' => json_encode(['webhook_id' => $webhook->id, 'event' => $event, 'status' => $log->status]),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            $results[] = $log;
        }

        return $results;
    }

    public function processIncoming(array $headers, array $payload, string $event = 'custom_event'): WebhookLog
    {
        $log = WebhookLog::create([
            'type' => 'incoming',
            'event' => $event,
            'headers' => $headers,
            'payload' => $payload,
            'status' => 'success',
            'status_code' => 200,
            'attempts' => 1,
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'WEBHOOK_RECEIVED',
            'details' => json_encode(['event' => $event, 'payload_keys' => array_keys($payload)]),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return $log;
    }
}
