<?php

namespace App\Traits;



use App\Models\EssentialOperationReport;

trait EssentialOperationReportAuthTrait
{
    function canAccessEssentialOperationReport(EssentialOperationReport $report)
    {
        $user = auth()->user();
        if($user->hasRole('wsp')){
            if($user->wsps()->first()->id !== $report->bcp->wsp->id){
                abort(403,'You do not have permission to edit this Essential Operations Report');
            }
        }
    }
}
