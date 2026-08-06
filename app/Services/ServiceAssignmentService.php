<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\AuditLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Exception;

class ServiceAssignmentService
{
    /**
     * Allowed State Transitions Matrix
     */
    protected array $allowedTransitions = [
        'pending' => ['assigned', 'cancelled'],
        'assigned' => ['accepted', 'rejected', 'assigned', 'cancelled'],
        'accepted' => ['in_progress', 'cancelled', 'unable_to_complete'],
        'in_progress' => ['completed', 'unable_to_complete', 'cancelled'],
        'completed' => ['verified'],
        'verified' => [],
        'cancelled' => [],
        'unable_to_complete' => ['assigned'],
    ];

    /**
     * Assign service request to medical staff provider.
     */
    public function assignProvider(Booking $booking, int $providerId, int $assignedByUserId): Booking
    {
        $oldStatus = $booking->status;
        
        $booking->update([
            'assigned_provider_id' => $providerId,
            'assigned_by' => $assignedByUserId,
            'assigned_at' => Carbon::now(),
            'status' => 'assigned',
        ]);

        $this->logActivity($booking, 'assigned', $oldStatus, 'assigned');

        return $booking;
    }

    /**
     * Transition booking status with strict state machine validation.
     */
    public function transitionStatus(Booking $booking, string $newStatus, ?string $notes = null): Booking
    {
        $currentStatus = $booking->status ?? 'pending';

        if (!in_array($newStatus, $this->allowedTransitions[$currentStatus] ?? [])) {
            throw new Exception("الانتقال من حالة '{$currentStatus}' إلى '{$newStatus}' غير مسموح به حسب قواعد Workflow المنظومة.");
        }

        $updateData = ['status' => $newStatus];

        if ($notes) {
            $updateData['notes'] = $booking->notes ? ($booking->notes . "\n" . $notes) : $notes;
        }

        $now = Carbon::now();
        if ($newStatus === 'accepted') {
            $updateData['accepted_at'] = $now;
        } elseif ($newStatus === 'in_progress') {
            $updateData['started_at'] = $now;
        } elseif ($newStatus === 'completed') {
            $updateData['completed_at'] = $now;
        } elseif ($newStatus === 'verified') {
            $updateData['verified_at'] = $now;
            $updateData['verified_by'] = Auth::id();
        }

        $booking->update($updateData);

        $this->logActivity($booking, $newStatus, $currentStatus, $newStatus);

        return $booking;
    }

    protected function logActivity(Booking $booking, string $action, string $oldStatus, string $newStatus): void
    {
        AuditLog::log(
            'STATUS_CHANGE_' . strtoupper($action),
            $booking,
            ['status' => $oldStatus],
            ['status' => $newStatus, 'assigned_provider' => $booking->assigned_provider_id]
        );
    }
}
