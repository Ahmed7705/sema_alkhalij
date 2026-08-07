<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalReportVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_report_id',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'uploaded_by',
        'replaced_by',
        'reason',
    ];

    public function medicalReport()
    {
        return $this->belongsTo(MedicalReport::class);
    }

    public function originalUploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function replacer()
    {
        return $this->belongsTo(User::class, 'replaced_by');
    }
}
