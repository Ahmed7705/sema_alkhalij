<?php

namespace App\Jobs;

use App\Models\AuditLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GeneratePdfReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $reportType;
    public $userId;

    public function __construct(string $reportType, int $userId)
    {
        $this->reportType = $reportType;
        $this->userId = $userId;
    }

    public function handle(): void
    {
        AuditLog::create([
            'user_id' => $this->userId,
            'action' => 'QUEUE_JOB_CREATED',
            'details' => json_encode(['job' => 'GeneratePdfReportJob', 'type' => $this->reportType]),
        ]);

        // Heavy report generation processing offloaded to Queue
        sleep(1);

        AuditLog::create([
            'user_id' => $this->userId,
            'action' => 'QUEUE_JOB_COMPLETED',
            'details' => json_encode(['job' => 'GeneratePdfReportJob', 'type' => $this->reportType]),
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        AuditLog::create([
            'user_id' => $this->userId,
            'action' => 'QUEUE_JOB_FAILED',
            'details' => json_encode(['job' => 'GeneratePdfReportJob', 'error' => $exception->getMessage()]),
        ]);
    }
}
