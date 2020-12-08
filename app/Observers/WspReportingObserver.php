<?php

namespace App\Observers;

use App\Models\CslgCalculation;
use App\Models\WspReporting;

class WspReportingObserver
{
    public function saved(WspReporting $reporting)
    {
        info("log me before");
        if($reporting->status != "WASREB Approved") return;

        $performanceScore = $reporting->bcp->performanceScores()
            ->where('month', $reporting->month)
            ->where('year', $reporting->year)
            ->first();
        info("log me before performanceScore");
        if(!$performanceScore) return;
        info("log me before performanceScore->status");
        if($performanceScore->status != "WASREB Approved") return;
        info("log me before calc");
        CslgCalculation::calculate($performanceScore,$reporting);
    }
}
