<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabSample extends Model
{
    use HasFactory;

    // 9-Stage Workflow Constants
    public const STATUS_REGISTERED = 'registered';
    public const STATUS_ASSIGNED = 'assigned';
    public const STATUS_COLLECTED = 'sample_collected';
    public const STATUS_SENT_TO_LAB = 'sent_to_lab';
    public const STATUS_RECEIVED_BY_LAB = 'received_by_lab';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_RESULT_READY = 'result_ready';
    public const STATUS_REPORT_UPLOADED = 'report_uploaded';
    public const STATUS_DELIVERED = 'delivered';

    public const WORKFLOW_STAGES = [
        self::STATUS_REGISTERED => 1,
        self::STATUS_ASSIGNED => 2,
        self::STATUS_COLLECTED => 3,
        self::STATUS_SENT_TO_LAB => 4,
        self::STATUS_RECEIVED_BY_LAB => 5,
        self::STATUS_PROCESSING => 6,
        self::STATUS_RESULT_READY => 7,
        self::STATUS_REPORT_UPLOADED => 8,
        self::STATUS_DELIVERED => 9,
    ];

    protected $fillable = [
        'visit_code',
        'patient_id',
        'booking_id',
        'company_id',
        'contract_id',
        'assigned_staff_id',
        'sample_status',
        'collected_at',
        'sent_to_lab_at',
        'received_at',
        'processing_at',
        'result_ready_at',
        'report_uploaded_at',
        'delivered_at',
        'notes',
    ];

    protected $casts = [
        'collected_at' => 'datetime',
        'sent_to_lab_at' => 'datetime',
        'received_at' => 'datetime',
        'processing_at' => 'datetime',
        'result_ready_at' => 'datetime',
        'report_uploaded_at' => 'datetime',
        'delivered_at' => 'datetime',
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

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function assignedStaff()
    {
        return $this->belongsTo(User::class, 'assigned_staff_id');
    }

    public function medicalReport()
    {
        return $this->hasOne(MedicalReport::class);
    }

    public function getCurrentStageIndex(): int
    {
        return self::WORKFLOW_STAGES[$this->sample_status] ?? 1;
    }
}

