<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_number',
        'company_id',
        'start_date',
        'end_date',
        'payment_terms',
        'status',
        'notes',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->contract_number)) {
                $model->contract_number = 'CNT-' . date('Y') . '-' . strtoupper(Str::random(5));
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

    public function beneficiaries()
    {
        return $this->hasMany(ContractBeneficiary::class);
    }
}
