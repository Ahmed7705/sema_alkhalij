<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_type',
        'in_app',
        'email',
        'sms',
        'whatsapp',
        'push',
    ];

    protected $casts = [
        'in_app' => 'boolean',
        'email' => 'boolean',
        'sms' => 'boolean',
        'whatsapp' => 'boolean',
        'push' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
