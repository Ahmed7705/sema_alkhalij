<?php

namespace App\Services;

use App\Models\LabSample;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VisitCodeGeneratorService
{
    /**
     * Generate a unique visit code with DB transaction locking for concurrency safety.
     * Format: VIS-YYYY-XXXXXX
     */
    public function generateUniqueVisitCode(): string
    {
        return DB::transaction(function () {
            $year = date('Y');
            $prefix = "VIS-{$year}-";

            // Find max code for current year
            $latestSample = LabSample::where('visit_code', 'LIKE', "{$prefix}%")
                ->lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            if (!$latestSample) {
                $number = 100001;
            } else {
                $lastNumber = (int) substr($latestSample->visit_code, -6);
                $number = $lastNumber + 1;
            }

            return $prefix . str_pad($number, 6, '0', STR_PAD_LEFT);
        });
    }

    public static function generate(): string
    {
        return (new static())->generateUniqueVisitCode();
    }
}

