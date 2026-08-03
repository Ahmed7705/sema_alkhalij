<?php

namespace App\Listeners;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LogActivityListener
{
    public static function log(string $action, ?string $modelType = null, ?int $modelId = null, array $oldValues = [], array $newValues = []): void
    {
        try {
            DB::table('audit_logs')->insert([
                'user_id' => Auth::id(),
                'action' => $action,
                'model_type' => $modelType,
                'model_id' => $modelId,
                'old_values' => !empty($oldValues) ? json_encode($oldValues, JSON_UNESCAPED_UNICODE) : null,
                'new_values' => !empty($newValues) ? json_encode($newValues, JSON_UNESCAPED_UNICODE) : null,
                'ip_address' => Request::ip(),
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to log audit activity: ' . $e->getMessage());
        }
    }
}
