<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\LabSample;
use App\Services\LabWorkflowService;
use Illuminate\Http\Request;

class LabStaffController extends Controller
{
    /**
     * Display assigned lab samples for the logged-in lab technician.
     */
    public function dashboard(Request $request)
    {
        $user = auth()->user();

        if ($user->role !== 'lab_tech' && !$user->isAdmin()) {
            abort(403, 'هذه اللوحة مخصصة لفنيي المختبر المصرح لهم فقط.');
        }

        $query = LabSample::where('assigned_staff_id', $user->id)
            ->with(['patient', 'booking.service', 'company', 'medicalReport']);

        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('visit_code', 'LIKE', "%{$q}%")
                    ->orWhereHas('patient', function ($p) use ($q) {
                        $p->where('name', 'LIKE', "%{$q}%")
                          ->orWhere('phone', 'LIKE', "%{$q}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('sample_status', $request->input('status'));
        }

        $samples = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => LabSample::where('assigned_staff_id', $user->id)->count(),
            'pending' => LabSample::where('assigned_staff_id', $user->id)->whereIn('sample_status', [LabSample::STATUS_ASSIGNED, LabSample::STATUS_COLLECTED, LabSample::STATUS_SENT_TO_LAB, LabSample::STATUS_RECEIVED_BY_LAB, LabSample::STATUS_PROCESSING])->count(),
            'ready' => LabSample::where('assigned_staff_id', $user->id)->whereIn('sample_status', [LabSample::STATUS_RESULT_READY, LabSample::STATUS_REPORT_UPLOADED, LabSample::STATUS_DELIVERED])->count(),
        ];

        return view('staff.lab-portal', compact('samples', 'stats'));
    }

    /**
     * Show sample details for assigned lab technician.
     */
    public function show($id)
    {
        $user = auth()->user();
        $sample = LabSample::with(['patient', 'booking.service', 'company', 'contract', 'medicalReport.versions.originalUploader', 'medicalReport.versions.replacer'])->findOrFail($id);

        if ($sample->assigned_staff_id !== $user->id && !$user->isAdmin()) {
            abort(403, 'غير مصرح لك باستعراض عينات مختبر مسندة لفنيين آخرين.');
        }

        return view('staff.lab-sample-show', compact('sample'));
    }

    /**
     * Update sample status.
     */
    public function updateStatus(Request $request, $id)
    {
        $user = auth()->user();
        $sample = LabSample::findOrFail($id);

        if ($sample->assigned_staff_id !== $user->id && !$user->isAdmin()) {
            abort(403, 'غير مصرح لك بتحديث حالة عينات مسندة لفنيين آخرين.');
        }

        $validated = $request->validate([
            'sample_status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        try {
            LabWorkflowService::transition($sample, $validated['sample_status'], $user->id, $validated['notes'] ?? null);
            return back()->with('success', 'تم تحديث حالة العينة بنجاح.');
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
