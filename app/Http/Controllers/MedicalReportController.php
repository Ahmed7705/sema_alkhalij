<?php

namespace App\Http\Controllers;

use App\Models\MedicalReport;
use App\Models\MedicalReportVersion;
use App\Models\LabSample;
use App\Models\AuditLog;
use App\Services\LabWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        return DB::transaction(function () use ($request, $file, $fileName, $fileSize) {
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
                    'sample_status' => LabSample::STATUS_REPORT_UPLOADED,
                    'result_ready_at' => $sample->result_ready_at ?? now(),
                    'report_uploaded_at' => now(),
                ]);
            }

            AuditLog::log('medical_report_uploaded', $report, [], ['patient_id' => $report->patient_id, 'file_name' => $fileName]);

            return redirect()->back()->with('success', 'تم رفع تقرير النتائج الطبية وحفظه بأمان.');
        });
    }

    /**
     * Replace existing PDF report and log version history.
     */
    public function replace(Request $request, $id)
    {
        $report = MedicalReport::findOrFail($id);

        $request->validate([
            'report_pdf' => 'required|file|mimes:pdf|max:10240',
            'reason' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        if (!$user->isAdmin() && $report->uploaded_by !== $user->id) {
            abort(403, 'غير مصرح لك باستبدال هذا التقرير الطبي.');
        }

        $file = $request->file('report_pdf');
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();

        return DB::transaction(function () use ($report, $file, $fileName, $fileSize, $user, $request) {
            // Archive current version
            MedicalReportVersion::create([
                'medical_report_id' => $report->id,
                'file_path' => $report->file_path,
                'file_name' => $report->file_name,
                'file_size' => $report->file_size,
                'mime_type' => $report->mime_type,
                'uploaded_by' => $report->uploaded_by,
                'replaced_by' => $user->id,
                'reason' => $request->input('reason', 'تم تحديث التقرير بطلب الفني/الأدمن'),
            ]);

            $oldPath = $report->file_path;
            $newPath = $file->store('private/medical_reports');

            $report->update([
                'file_path' => $newPath,
                'file_name' => $fileName,
                'file_size' => $fileSize,
                'uploaded_by' => $user->id,
                'uploaded_at' => now(),
            ]);

            AuditLog::log('medical_report_replaced', $report, ['old_file' => $oldPath], ['new_file' => $newPath, 'reason' => $request->reason]);

            return redirect()->back()->with('success', 'تم استبدال التقرير الطبي وحفظ النسخة السابقة في السجل.');
        });
    }

    /**
     * Delete medical report.
     */
    public function destroy($id)
    {
        $report = MedicalReport::findOrFail($id);
        $user = Auth::user();

        if (!$user->isAdmin() && $report->uploaded_by !== $user->id) {
            abort(403, 'غير مصرح لك بحذف هذا التقرير الطبي.');
        }

        return DB::transaction(function () use ($report) {
            if (Storage::exists($report->file_path)) {
                Storage::delete($report->file_path);
            }

            if ($report->labSample) {
                $report->labSample->update([
                    'sample_status' => LabSample::STATUS_RESULT_READY,
                ]);
            }

            AuditLog::log('medical_report_deleted', $report, $report->toArray(), []);
            $report->delete();

            return redirect()->back()->with('success', 'تم حذف التقرير الطبي بنجاح.');
        });
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
        } elseif ((int)$user->id === (int)$report->patient_id) {
            $authorized = true;
        } elseif ($user->company_id && (int)$user->company_id === (int)$report->company_id) {
            $authorized = true;
        }

        if (!$authorized) {
            abort(403, 'غير مصرح لك بالوصول لتقرير النتيجة الطبية.');
        }

        if (!Storage::exists($report->file_path)) {
            abort(404, 'الملف غير موجود بالسيرفر.');
        }

        AuditLog::log('medical_report_downloaded', $report);

        return Storage::download($report->file_path, $report->file_name);
    }
}

