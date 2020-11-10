<?php

namespace App\Observers;

use App\Models\CslgCalculation;
use App\Models\PerformanceScore;

class PerformanceScoreObserver
{
    public function saved(PerformanceScore $performanceScore)
    {
        if ($performanceScore->status != "WASREB Approved") return;

        $reporting = $performanceScore->bcp->wspReportings()
            ->where('month', $performanceScore->month)
            ->where('year', $performanceScore->year)
            ->first();

        if (!$reporting) return;

        if ($reporting->status != "WASREB Approved") return;

        CslgCalculation::calculate($performanceScore,$reporting);

    }
}
