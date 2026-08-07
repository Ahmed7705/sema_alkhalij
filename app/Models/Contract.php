<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_number',
        'company_id',
        'start_date',
        'end_date',
        'payment_terms',
        'discount_percentage',
        'status',
        'notes',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->contract_number)) {
                $year = date('Y');
                $latestContract = static::where('contract_number', 'LIKE', "CNT-{$year}-%")->orderBy('id', 'desc')->first();
                $seq = $latestContract ? ((int) substr($latestContract->contract_number, -4)) + 1 : 1001;
                $model->contract_number = "CNT-{$year}-{$seq}";
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function contractPrices()
    {
        return $this->hasMany(ContractPrice::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'contract_prices', 'contract_id', 'service_id')
                    ->withPivot('custom_price')
                    ->withTimestamps();
    }

    public function beneficiaries()
    {
        return $this->hasMany(ContractBeneficiary::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'company_id', 'company_id');
    }

    public function isActive()
    {
        $today = date('Y-m-d');
        return $this->status === 'active' && $this->start_date <= $today && $this->end_date >= $today;
    }
}
