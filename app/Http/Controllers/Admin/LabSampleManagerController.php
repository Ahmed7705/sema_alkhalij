<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabSample;
use App\Models\Booking;
use App\Models\Company;
use App\Models\User;
use App\Services\LabWorkflowService;
use App\Services\VisitCodeGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LabSampleManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = LabSample::with(['patient', 'booking', 'company', 'assignedStaff', 'medicalReport']);

        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('visit_code', 'LIKE', "%{$q}%")
                    ->orWhereHas('patient', function ($p) use ($q) {
                        $p->where('name', 'LIKE', "%{$q}%")
                          ->orWhere('phone', 'LIKE', "%{$q}%")
                          ->orWhere('identification_number', 'LIKE', "%{$q}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('sample_status', $request->input('status'));
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->input('company_id'));
        }

        if ($request->filled('assigned_staff_id')) {
            $query->where('assigned_staff_id', $request->input('assigned_staff_id'));
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->input('date'));
        }

        $samples = $query->latest()->paginate(15)->withQueryString();

        $companies = Company::where('status', 'active')->get();
        $labTechs = User::where('role', 'lab_tech')->get();

        // Analytics metrics from real MySQL
        $stats = [
            'total' => LabSample::count(),
            'registered' => LabSample::where('sample_status', LabSample::STATUS_REGISTERED)->count(),
            'processing' => LabSample::whereIn('sample_status', [LabSample::STATUS_SENT_TO_LAB, LabSample::STATUS_RECEIVED_BY_LAB, LabSample::STATUS_PROCESSING])->count(),
            'result_ready' => LabSample::whereIn('sample_status', [LabSample::STATUS_RESULT_READY, LabSample::STATUS_REPORT_UPLOADED])->count(),
            'delivered' => LabSample::where('sample_status', LabSample::STATUS_DELIVERED)->count(),
        ];

        return view('admin.lab-samples.index', compact('samples', 'companies', 'labTechs', 'stats'));
    }

    public function create()
    {
        $patients = User::where(function($q) {
            $q->whereNull('role')->orWhere('role', 'customer');
        })->get();

        $bookings = Booking::whereIn('status', ['confirmed', 'completed', 'in_progress'])->latest()->take(50)->get();
        $companies = Company::where('status', 'active')->get();
        $labTechs = User::where('role', 'lab_tech')->get();

        return view('admin.lab-samples.create', compact('patients', 'bookings', 'companies', 'labTechs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'company_id' => 'nullable|exists:companies,id',
            'assigned_staff_id' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $visitCode = VisitCodeGeneratorService::generate();
            $bookingId = $request->input('booking_id');
            $booking = $bookingId ? Booking::find($bookingId) : null;

            $sample = LabSample::create([
                'visit_code' => $visitCode,
                'patient_id' => $validated['patient_id'],
                'booking_id' => $bookingId ?: null,
                'company_id' => $request->input('company_id') ?: ($booking ? $booking->company_id : null),
                'contract_id' => $booking ? $booking->contract_id : null,
                'assigned_staff_id' => $request->input('assigned_staff_id') ?: null,
                'sample_status' => $request->filled('assigned_staff_id') ? LabSample::STATUS_ASSIGNED : LabSample::STATUS_REGISTERED,
                'notes' => $request->input('notes'),
            ]);

            \App\Models\AuditLog::log('CREATE_LAB_SAMPLE', $sample, [], $sample->toArray());
        });


        return redirect()->route('admin.lab-samples.index')->with('success', 'تم تسجيل عينة المختبر بنجاح.');
    }

    public function show($id)
    {
        $sample = LabSample::with(['patient', 'booking.service', 'company', 'contract', 'assignedStaff', 'medicalReport.versions.originalUploader', 'medicalReport.versions.replacer', 'medicalReport.uploader', 'medicalReport.verifier'])->findOrFail($id);
        $labTechs = User::where('role', 'lab_tech')->get();

        return view('admin.lab-samples.show', compact('sample', 'labTechs'));
    }

    public function updateStatus(Request $request, $id)
    {
        $sample = LabSample::findOrFail($id);
        $validated = $request->validate([
            'sample_status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        try {
            LabWorkflowService::transition($sample, $validated['sample_status'], auth()->id(), $validated['notes'] ?? null);
            return back()->with('success', 'تم تحديث حالة العينة في نظام المختبر بنجاح.');
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function assignStaff(Request $request, $id)
    {
        $sample = LabSample::findOrFail($id);
        $validated = $request->validate([
            'assigned_staff_id' => 'required|exists:users,id',
        ]);

        LabWorkflowService::assignStaff($sample, $validated['assigned_staff_id'], auth()->id());

        return back()->with('success', 'تم تعيين فني المختبر المسؤول عن العينة بنجاح.');
    }
}
