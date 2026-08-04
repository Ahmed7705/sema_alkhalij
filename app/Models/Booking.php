<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'booking_number',
        'service_id',
        'booking_date',
        'booking_time',
        'city',
        'address',
        'phone',
        'total_price',
        'status',
        'payment_status',
        'payment_method',
        'notes',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
            if (empty($model->booking_number)) {
                $year = date('Y');
                $latestBooking = static::where('booking_number', 'LIKE', "BK-{$year}-%")->orderBy('id', 'desc')->first();
                $seq = $latestBooking ? ((int) substr($latestBooking->booking_number, -5)) + 1 : 10001;
                $model->booking_number = "BK-{$year}-{$seq}";
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function assignedProvider()
    {
        return $this->belongsTo(User::class, 'assigned_provider_id');
    }

    public function labSample()
    {
        return $this->hasOne(LabSample::class, 'booking_id');
    }

    public function medicalReports()
    {
        return $this->hasMany(MedicalReport::class, 'booking_id');
    }
}
