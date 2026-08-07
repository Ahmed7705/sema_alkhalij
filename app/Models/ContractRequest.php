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
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
        'approved_by',
        'approved_at',
        'converted_company_id',
    ];

    public function convertedCompany()
    {
        return $this->belongsTo(Company::class, 'converted_company_id');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
