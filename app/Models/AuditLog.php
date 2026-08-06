<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function log($action, $model = null, $oldValues = [], $newValues = [])
    {
        return self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'old_values' => is_array($oldValues) ? (!empty($oldValues) ? json_encode($oldValues, JSON_UNESCAPED_UNICODE) : null) : (string)$oldValues,
            'new_values' => is_array($newValues) ? (!empty($newValues) ? json_encode($newValues, JSON_UNESCAPED_UNICODE) : null) : (string)$newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
