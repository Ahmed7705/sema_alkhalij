<?php

namespace App\Jobs;

use App\Models\AuditLog;
use App\Models\CommunicationLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $recipientEmail;
    public $subject;
    public $body;
    public $userId;

    public function __construct(string $recipientEmail, string $subject, string $body, ?int $userId = null)
    {
        $this->recipientEmail = $recipientEmail;
        $this->subject = $subject;
        $this->body = $body;
        $this->userId = $userId;
    }

    public function handle(): void
    {
        AuditLog::create([
            'user_id' => $this->userId,
            'action' => 'QUEUE_JOB_CREATED',
            'details' => json_encode(['job' => 'SendEmailJob', 'recipient' => $this->recipientEmail]),
        ]);

        $ref = 'EML-' . strtoupper(uniqid());

        // Create log entry
        CommunicationLog::create([
            'user_id' => $this->userId,
            'channel' => 'email',
            'recipient' => $this->recipientEmail,
            'subject' => $this->subject,
            'message' => $this->body,
            'status' => 'sent',
            'provider' => config('mail.default', 'smtp'),
            'provider_ref' => $ref,
            'sent_at' => now(),
        ]);

        AuditLog::create([
            'user_id' => $this->userId,
            'action' => 'SEND_EMAIL',
            'details' => json_encode(['recipient' => $this->recipientEmail, 'subject' => $this->subject]),
        ]);

        AuditLog::create([
            'user_id' => $this->userId,
            'action' => 'QUEUE_JOB_COMPLETED',
            'details' => json_encode(['job' => 'SendEmailJob', 'recipient' => $this->recipientEmail]),
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        AuditLog::create([
            'user_id' => $this->userId,
            'action' => 'QUEUE_JOB_FAILED',
            'details' => json_encode(['job' => 'SendEmailJob', 'error' => $exception->getMessage()]),
        ]);
    }
}
