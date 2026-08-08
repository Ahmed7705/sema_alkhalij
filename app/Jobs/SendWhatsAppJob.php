<?php

namespace App\Jobs;

use App\Models\AuditLog;
use App\Services\Drivers\WhatsAppService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsAppJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $phone;
    public $message;
    public $userId;

    public function __construct(string $phone, string $message, ?int $userId = null)
    {
        $this->phone = $phone;
        $this->message = $message;
        $this->userId = $userId;
    }

    public function handle(WhatsAppService $whatsAppService): void
    {
        AuditLog::create([
            'user_id' => $this->userId,
            'action' => 'QUEUE_JOB_CREATED',
            'details' => json_encode(['job' => 'SendWhatsAppJob', 'phone' => $this->phone]),
        ]);

        $whatsAppService->sendWhatsApp($this->phone, $this->message, $this->userId);


        AuditLog::create([
            'user_id' => $this->userId,
            'action' => 'QUEUE_JOB_COMPLETED',
            'details' => json_encode(['job' => 'SendWhatsAppJob', 'phone' => $this->phone]),
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        AuditLog::create([
            'user_id' => $this->userId,
            'action' => 'QUEUE_JOB_FAILED',
            'details' => json_encode(['job' => 'SendWhatsAppJob', 'error' => $exception->getMessage()]),
        ]);
    }
}
