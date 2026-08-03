<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractBeneficiary extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'patient_id',
        'employee_id_number',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
