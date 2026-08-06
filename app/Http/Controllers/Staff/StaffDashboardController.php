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
        $user = Auth::user();
        if (!in_array($user->role, ['doctor', 'nurse', 'physio', 'lab_tech', 'admin', 'manager', 'customer_service', 'super_admin'])) {
            abort(403, 'عذراً، هذه البوابة مخصصة للكادر الطبي والتشغيلي فقط.');
        }

        $staffId = $user->id;

        $assignedQuery = Booking::where('assigned_provider_id', $staffId);
        
        // If Admin/Super Admin/Manager is testing, fallback to viewing all bookings if none assigned directly
        if (in_array($user->role, ['admin', 'super_admin', 'manager']) && $assignedQuery->count() === 0) {
            $assignedVisits = Booking::with(['service', 'user'])->latest()->paginate(15);
        } else {
            $assignedVisits = $assignedQuery->with(['service', 'user'])->latest()->paginate(15);
        }

        $todaysVisits = Booking::where(function($q) use ($staffId, $user) {
                if (!in_array($user->role, ['admin', 'super_admin'])) {
                    $q->where('assigned_provider_id', $staffId);
                }
            })
            ->whereDate('booking_date', today())
            ->count();

        $pendingAcceptance = Booking::where(function($q) use ($staffId, $user) {
                if (!in_array($user->role, ['admin', 'super_admin'])) {
                    $q->where('assigned_provider_id', $staffId);
                }
            })
            ->where('status', 'assigned')
            ->count();

        $inProgress = Booking::where(function($q) use ($staffId, $user) {
                if (!in_array($user->role, ['admin', 'super_admin'])) {
                    $q->where('assigned_provider_id', $staffId);
                }
            })
            ->where('status', 'in_progress')
            ->count();

        $completed = Booking::where(function($q) use ($staffId, $user) {
                if (!in_array($user->role, ['admin', 'super_admin'])) {
                    $q->where('assigned_provider_id', $staffId);
                }
            })
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

        if ((int)$booking->assigned_provider_id !== (int)Auth::id() && !in_array(Auth::user()->role, ['admin', 'super_admin'])) {
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
