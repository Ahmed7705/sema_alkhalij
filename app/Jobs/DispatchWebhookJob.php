<?php

namespace App\Jobs;

use App\Models\AuditLog;
use App\Services\WebhookService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DispatchWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $event;
    public $payload;

    public function __construct(string $event, array $payload)
    {
        $this->event = $event;
        $this->payload = $payload;
    }

    public function handle(WebhookService $webhookService): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'QUEUE_JOB_CREATED',
            'details' => json_encode(['job' => 'DispatchWebhookJob', 'event' => $this->event]),
        ]);

        $webhookService->dispatchOutgoing($this->event, $this->payload);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'QUEUE_JOB_COMPLETED',
            'details' => json_encode(['job' => 'DispatchWebhookJob', 'event' => $this->event]),
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'QUEUE_JOB_FAILED',
            'details' => json_encode(['job' => 'DispatchWebhookJob', 'error' => $exception->getMessage()]),
        ]);
    }
}
