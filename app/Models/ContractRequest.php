<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'cr_number',
        'contact_person',
        'phone',
        'email',
        'city',
        'requested_services',
        'expected_beneficiaries',
        'notes',
        'status',
    ];
}
