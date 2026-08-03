<?php

namespace App\Http\Controllers;

use App\Models\MedicalReport;
use App\Models\LabSample;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MedicalReportController extends Controller
{
    /**
     * Upload medical PDF report into private secure storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:users,id',
            'lab_sample_id' => 'nullable|exists:lab_samples,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'report_pdf' => 'required|file|mimes:pdf|max:10240', // Max 10MB
        ]);

        $file = $request->file('report_pdf');
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();

        // Store in private storage directory
        $path = $file->store('private/medical_reports');

        $sample = $request->lab_sample_id ? LabSample::find($request->lab_sample_id) : null;

        $report = MedicalReport::create([
            'lab_sample_id' => $request->lab_sample_id,
            'patient_id' => $request->patient_id,
            'booking_id' => $request->booking_id,
            'company_id' => $sample ? $sample->company_id : null,
            'visit_code' => $sample ? $sample->visit_code : null,
            'file_path' => $path,
            'file_name' => $fileName,
            'file_size' => $fileSize,
            'mime_type' => 'application/pdf',
            'uploaded_by' => Auth::id(),
            'uploaded_at' => now(),
        ]);

        if ($sample) {
            $sample->update([
                'sample_status' => 'result_ready',
                'result_ready_at' => now(),
            ]);
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'event' => 'medical_report_uploaded',
            'auditable_type' => MedicalReport::class,
            'auditable_id' => $report->id,
            'new_values' => json_encode(['patient_id' => $report->patient_id, 'file_name' => $fileName]),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', 'تم رفع تقرير النتائج الطبية وحفظه بأمان.');
    }

    /**
     * Authorized download stream for sensitive medical PDF.
     */
    public function download(MedicalReport $report): StreamedResponse
    {
        $user = Auth::user();

        // Authorization check: Admin, Staff, Patient owner, or Company user of the patient
        $authorized = false;
        if (in_array($user->role, ['admin', 'super_admin', 'doctor', 'nurse', 'lab_tech'])) {
            $authorized = true;
        } elseif ($user->id === $report->patient_id) {
            $authorized = true;
        } elseif ($user->company_id && $user->company_id === $report->company_id) {
            $authorized = true;
        }

        if (!$authorized) {
            abort(403, 'غير مصرح لك بالوصول لتقرير النتيجة الطبية.');
        }

        if (!Storage::exists($report->file_path)) {
            abort(404, 'الملف غير موجود بالسيرفر.');
        }

        // Audit download activity
        AuditLog::create([
            'user_id' => $user->id,
            'event' => 'medical_report_downloaded',
            'auditable_type' => MedicalReport::class,
            'auditable_id' => $report->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return Storage::download($report->file_path, $report->file_name);
    }
}
