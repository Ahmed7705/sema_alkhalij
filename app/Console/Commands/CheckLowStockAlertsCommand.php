<?php

namespace App\Console\Commands;

use App\Models\AuditLog;
use App\Services\InventoryService;
use Illuminate\Console\Command;

class CheckLowStockAlertsCommand extends Command
{
    protected $signature = 'sema:check-low-stock';
    protected $description = 'Check low stock levels across warehouses and trigger alerts';

    public function handle(InventoryService $inventoryService): int
    {
        $lowStock = $inventoryService->getLowStockAlerts(10);
        
        $this->info("Low Stock Check Completed. Found " . count($lowStock) . " batches under threshold.");

        AuditLog::create([
            'user_id' => null,
            'action' => 'SCHEDULE_EXECUTED',
            'details' => json_encode(['task' => 'sema:check-low-stock', 'count' => count($lowStock)]),
        ]);

        return Command::SUCCESS;
    }
}
