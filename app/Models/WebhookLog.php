<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebhookLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'webhook_id',
        'type',
        'event',
        'url',
        'headers',
        'payload',
        'status_code',
        'status',
        'attempts',
        'error_message',
    ];

    protected $casts = [
        'headers' => 'array',
        'payload' => 'array',
    ];

    public function webhook()
    {
        return $this->belongsTo(Webhook::class);
    }
}
