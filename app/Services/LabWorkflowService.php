<?php

namespace App\Services;

use App\Models\LabSample;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class LabWorkflowService
{
    /**
     * Allowed forward state transitions for the 9-stage workflow.
     */
    protected static array $transitionMap = [
        LabSample::STATUS_REGISTERED => [LabSample::STATUS_ASSIGNED],
        LabSample::STATUS_ASSIGNED => [LabSample::STATUS_COLLECTED],
        LabSample::STATUS_COLLECTED => [LabSample::STATUS_SENT_TO_LAB],
        LabSample::STATUS_SENT_TO_LAB => [LabSample::STATUS_RECEIVED_BY_LAB],
        LabSample::STATUS_RECEIVED_BY_LAB => [LabSample::STATUS_PROCESSING],
        LabSample::STATUS_PROCESSING => [LabSample::STATUS_RESULT_READY],
        LabSample::STATUS_RESULT_READY => [LabSample::STATUS_REPORT_UPLOADED],
        LabSample::STATUS_REPORT_UPLOADED => [LabSample::STATUS_DELIVERED],
        LabSample::STATUS_DELIVERED => [],
    ];

    /**
     * Transition a lab sample to a new target status safely.
     */
    public static function transition(LabSample $sample, string $targetStatus, ?int $actorId = null, ?string $notes = null): LabSample
    {
        $currentStatus = $sample->sample_status;

        if ($currentStatus === $targetStatus) {
            return $sample;
        }

        $allowedTargets = self::$transitionMap[$currentStatus] ?? [];
        
        // Super Admin or Admin override allowed if advancing to a valid future stage
        $currentIndex = LabSample::WORKFLOW_STAGES[$currentStatus] ?? 0;
        $targetIndex = LabSample::WORKFLOW_STAGES[$targetStatus] ?? 0;

        if (!in_array($targetStatus, $allowedTargets) && $targetIndex <= $currentIndex) {
            throw new InvalidArgumentException("الانتقال غير مجاز من حالة '{$currentStatus}' إلى '{$targetStatus}'.");
        }

        return DB::transaction(function () use ($sample, $currentStatus, $targetStatus, $actorId, $notes) {
            $now = now();
            $updateData = ['sample_status' => $targetStatus];

            if ($notes) {
                $updateData['notes'] = $notes;
            }

            // Map timestamps for each stage
            switch ($targetStatus) {
                case LabSample::STATUS_COLLECTED:
                    $updateData['collected_at'] = $now;
                    break;
                case LabSample::STATUS_SENT_TO_LAB:
                    $updateData['sent_to_lab_at'] = $now;
                    break;
                case LabSample::STATUS_RECEIVED_BY_LAB:
                    $updateData['received_at'] = $now;
                    break;
                case LabSample::STATUS_PROCESSING:
                    $updateData['processing_at'] = $now;
                    break;
                case LabSample::STATUS_RESULT_READY:
                    $updateData['result_ready_at'] = $now;
                    break;
                case LabSample::STATUS_REPORT_UPLOADED:
                    $updateData['report_uploaded_at'] = $now;
                    break;
                case LabSample::STATUS_DELIVERED:
                    $updateData['delivered_at'] = $now;
                    break;
            }

            $sample->update($updateData);

            AuditLog::log('LAB_SAMPLE_TRANSITION', $sample, [
                'status' => $currentStatus
            ], [
                'status' => $targetStatus,
                'actor_id' => $actorId ?? auth()->id(),
                'notes' => $notes
            ]);

            return $sample->fresh();
        });
    }

    /**
     * Assign staff (lab tech) to sample.
     */
    public static function assignStaff(LabSample $sample, int $staffId, ?int $actorId = null): LabSample
    {
        return DB::transaction(function () use ($sample, $staffId, $actorId) {
            $oldStaffId = $sample->assigned_staff_id;
            $sample->assigned_staff_id = $staffId;
            
            if ($sample->sample_status === LabSample::STATUS_REGISTERED) {
                $sample->sample_status = LabSample::STATUS_ASSIGNED;
            }

            $sample->save();

            AuditLog::log('ASSIGN_LAB_STAFF', $sample, [
                'assigned_staff_id' => $oldStaffId
            ], [
                'assigned_staff_id' => $staffId,
                'actor_id' => $actorId ?? auth()->id()
            ]);

            return $sample->fresh();
        });
    }
}
