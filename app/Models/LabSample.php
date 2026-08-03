<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabSample extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_code',
        'patient_id',
        'booking_id',
        'company_id',
        'contract_id',
        'assigned_staff_id',
        'sample_status',
        'collected_at',
        'received_at',
        'result_ready_at',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function assignedStaff()
    {
        return $this->belongsTo(User::class, 'assigned_staff_id');
    }

    public function medicalReport()
    {
        return $this->hasOne(MedicalReport::class);
    }
}
