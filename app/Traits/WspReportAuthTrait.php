<?php

namespace App\Traits;



use App\Models\WspReporting;

trait WspReportAuthTrait
{
    function canAccessWspReporting(WspReporting $report)
    {
        $user = auth()->user();
        if($user->hasRole('wsp')){
            if($user->wsps()->first()->id !== $report->bcp->wsp->id){
                abort(403,'You do not have permission to edit this Monthly Report');
            }
        }
    }
}
