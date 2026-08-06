<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingManagerController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['service', 'user', 'assignedProvider', 'company']);

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('booking_number', 'LIKE', "%{$q}%")
                    ->orWhere('patient_name', 'LIKE', "%{$q}%")
                    ->orWhere('phone', 'LIKE', "%{$q}%")
                    ->orWhereHas('user', function ($u) use ($q) {
                        $u->where('name', 'LIKE', "%{$q}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('assigned_provider_id')) {
            $query->where('assigned_provider_id', $request->input('assigned_provider_id'));
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->input('company_id'));
        }

        if ($request->filled('date')) {
            $query->where('booking_date', $request->input('date'));
        }

        $bookings = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();

        $staffList = User::whereIn('role', ['doctor', 'nurse', 'physio', 'lab_tech', 'customer_service', 'manager'])
            ->where('is_active', true)
            ->get();

        return view('admin.bookings.index', compact('bookings', 'staffList'));
    }

    public function show($id)
    {
        $booking = Booking::with([
            'service',
            'user',
            'company',
            'contract',
            'assignedProvider.staffProfile',
            'assignedBy',
            'verifiedBy',
            'labSample',
            'medicalReports',
        ])->findOrFail($id);

        $timelineLogs = AuditLog::with('user')
            ->where('model_type', 'LIKE', '%Booking%')
            ->where('model_id', $booking->id)
            ->orderBy('created_at', 'asc')
            ->get();

        $staffList = User::with('staffProfile')
            ->whereIn('role', ['doctor', 'nurse', 'physio', 'lab_tech', 'customer_service', 'manager'])
            ->where('is_active', true)
            ->get();

        return view('admin.bookings.show', compact('booking', 'timelineLogs', 'staffList'));
    }

    public function assign(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'assigned_provider_id' => 'required|exists:users,id',
        ]);

        $provider = User::with('staffProfile')->findOrFail($validated['assigned_provider_id']);

        // Server-Side Validation: Ensure target practitioner is active & qualified staff
        if (!$provider->is_active || ($provider->staffProfile && !$provider->staffProfile->is_active)) {
            return back()->with('error', __('Cannot assign visit to an inactive staff member.'));
        }

        $staffRoles = ['doctor', 'nurse', 'physio', 'lab_tech', 'customer_service', 'manager', 'admin', 'super_admin'];
        if (!in_array($provider->role, $staffRoles)) {
            return back()->with('error', __('Selected user is not qualified for service assignment.'));
        }

        $oldProviderName = $booking->assignedProvider ? $booking->assignedProvider->name : __('None');
        $isReassignment = !empty($booking->assigned_provider_id);

        $booking->update([
            'assigned_provider_id' => $provider->id,
            'assigned_by' => Auth::id(),
            'assigned_at' => now(),
            'status' => in_array($booking->status, ['requested', 'assigned']) ? 'assigned' : $booking->status,
        ]);

        $actionType = $isReassignment ? 'REASSIGN_VISIT' : 'ASSIGN_VISIT';
        $logMsg = $isReassignment
            ? "Reassigned visit #{$booking->booking_number} from {$oldProviderName} to {$provider->name} ({$provider->role})"
            : "Assigned visit #{$booking->booking_number} to {$provider->name} ({$provider->role})";

        AuditLog::log($actionType, $booking, $logMsg);

        return back()->with('success', __('Medical visit assigned successfully.'));
    }

    public function verify(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        // Server-Side Authorization: Only Supervisors, Managers, and Admins can verify completed visits
        $user = Auth::user();
        $allowedRoles = ['admin', 'super_admin', 'manager', 'customer_service'];
        if (!in_array($user->role, $allowedRoles) && !$user->hasRole('admin')) {
            abort(403, __('Unauthorized: Only supervisors or admins can verify completed medical visits.'));
        }

        if ($booking->status !== 'completed') {
            return back()->with('error', __('Only completed visits can be verified. Current status: ') . $booking->status);
        }

        $booking->update([
            'status' => 'verified',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        AuditLog::log('VERIFY_VISIT', $booking, "Visit #{$booking->booking_number} verified by {$user->name}");

        return back()->with('success', __('Medical visit verified and marked complete successfully.'));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $request->validate(['status' => 'required|string']);

        $newStatus = $request->input('status');
        $oldStatus = $booking->status;

        // Workflow state machine validation rules
        $allowedTransitions = [
            'requested' => ['assigned', 'cancelled'],
            'assigned' => ['accepted', 'assigned', 'cancelled'],
            'accepted' => ['in_progress', 'cancelled'],
            'in_progress' => ['completed', 'cancelled'],
            'completed' => ['verified'],
            'verified' => [],
        ];

        if (isset($allowedTransitions[$oldStatus]) && !in_array($newStatus, $allowedTransitions[$oldStatus])) {
            return back()->with('error', __("Invalid workflow transition from {$oldStatus} to {$newStatus}."));
        }

        $updateData = ['status' => $newStatus];
        if ($newStatus === 'accepted') {
            $updateData['accepted_at'] = now();
        } elseif ($newStatus === 'in_progress') {
            $updateData['started_at'] = now();
        } elseif ($newStatus === 'completed') {
            $updateData['completed_at'] = now();
        } elseif ($newStatus === 'verified') {
            $updateData['verified_at'] = now();
            $updateData['verified_by'] = Auth::id();
        }

        $booking->update($updateData);

        AuditLog::log('STATUS_CHANGE', $booking, "Visit #{$booking->booking_number} status changed from {$oldStatus} to {$newStatus}");

        return back()->with('success', __('Medical visit status updated successfully.'));
    }
}
