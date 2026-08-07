<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractBeneficiary extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'company_id',
        'patient_id',
        'name',
        'identification_type',
        'identification_number',
        'phone',
        'employee_id_number',
        'status',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'patient_id', 'patient_id');
    }

    public function getDisplayNameAttribute()
    {
        if ($this->patient) {
            return $this->patient->name;
        }
        return $this->name ?? ('Beneficiary #' . $this->id);
    }
}
