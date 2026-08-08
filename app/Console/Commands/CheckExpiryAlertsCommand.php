<?php

namespace App\Console\Commands;

use App\Models\AuditLog;
use App\Services\InventoryService;
use Illuminate\Console\Command;

class CheckExpiryAlertsCommand extends Command
{
    protected $signature = 'sema:check-expiry-alerts';
    protected $description = 'Check batches expiring within 60 days and trigger warnings';

    public function handle(InventoryService $inventoryService): int
    {
        $expiring = $inventoryService->getExpiringSoonAlerts(60);

        $this->info("Expiry Check Completed. Found " . count($expiring) . " batches expiring soon.");

        AuditLog::create([
            'user_id' => null,
            'action' => 'SCHEDULE_EXECUTED',
            'details' => json_encode(['task' => 'sema:check-expiry-alerts', 'count' => count($expiring)]),
        ]);

        return Command::SUCCESS;
    }
}
