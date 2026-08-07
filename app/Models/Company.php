<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_code',
        'cr_number',
        'contact_person',
        'phone',
        'email',
        'city',
        'address',
        'status',
        'contract_request_id',
    ];

    public function contractRequest()
    {
        return $this->belongsTo(ContractRequest::class, 'contract_request_id');
    }

    public function activeContract()
    {
        return $this->hasOne(Contract::class)->where('status', 'active')->latestOfMany();
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function beneficiaries()
    {
        return $this->hasMany(ContractBeneficiary::class);
    }
}
