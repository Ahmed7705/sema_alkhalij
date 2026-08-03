<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\LabSample;
use App\Services\ServiceAssignmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffDashboardController extends Controller
{
    protected $assignmentService;

    public function __construct(ServiceAssignmentService $assignmentService)
    {
        $this->assignmentService = $assignmentService;
    }

    public function index()
    {
        $staffId = Auth::id();

        $assignedVisits = Booking::where('assigned_provider_id', $staffId)
            ->with(['service', 'user'])
            ->latest()
            ->paginate(15);

        $todaysVisits = Booking::where('assigned_provider_id', $staffId)
            ->whereDate('booking_date', today())
            ->count();

        $pendingAcceptance = Booking::where('assigned_provider_id', $staffId)
            ->where('status', 'assigned')
            ->count();

        $inProgress = Booking::where('assigned_provider_id', $staffId)
            ->where('status', 'in_progress')
            ->count();

        $completed = Booking::where('assigned_provider_id', $staffId)
            ->where('status', 'completed')
            ->count();

        return view('staff.dashboard', compact(
            'assignedVisits',
            'todaysVisits',
            'pendingAcceptance',
            'inProgress',
            'completed'
        ));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        if ($booking->assigned_provider_id !== Auth::id() && !in_array(Auth::user()->role, ['admin', 'super_admin'])) {
            abort(403, 'غير مصرح لك بتحديث حالة هذه الزيارة الطبية.');
        }

        try {
            $this->assignmentService->transitionStatus($booking, $request->status, $request->notes);
            return redirect()->back()->with('success', 'تم تحديث حالة الزيارة الطبية بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
