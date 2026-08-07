<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'lab_sample_id',
        'patient_id',
        'booking_id',
        'company_id',
        'visit_code',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'uploaded_by',
        'verified_by',
        'uploaded_at',
        'verified_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function labSample()
    {
        return $this->belongsTo(LabSample::class);
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function versions()
    {
        return $this->hasMany(MedicalReportVersion::class)->latest();
    }
}

