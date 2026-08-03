<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'staff_type',
        'specialty',
        'license_number',
        'job_title',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
