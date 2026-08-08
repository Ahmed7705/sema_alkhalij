<?php

namespace App\Jobs;

use App\Models\AuditLog;
use App\Models\User;
use App\Services\Drivers\PushNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $userId;
    public $title;
    public $body;
    public $extraData;

    public function __construct(int $userId, string $title, string $body, array $extraData = [])
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->body = $body;
        $this->extraData = $extraData;
    }

    public function handle(PushNotificationService $pushService): void
    {
        AuditLog::create([
            'user_id' => $this->userId,
            'action' => 'QUEUE_JOB_CREATED',
            'details' => json_encode(['job' => 'SendPushNotificationJob', 'user_id' => $this->userId]),
        ]);

        $user = User::find($this->userId);

        if ($user) {
            $pushService->sendPush($user, $this->title, $this->body, $this->extraData);
        }

        AuditLog::create([
            'user_id' => $this->userId,
            'action' => 'QUEUE_JOB_COMPLETED',
            'details' => json_encode(['job' => 'SendPushNotificationJob', 'user_id' => $this->userId]),
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        AuditLog::create([
            'user_id' => $this->userId,
            'action' => 'QUEUE_JOB_FAILED',
            'details' => json_encode(['job' => 'SendPushNotificationJob', 'error' => $exception->getMessage()]),
        ]);
    }
}
