<?php

namespace App\Traits;



use App\Models\VulnerableCustomer;

trait VulnerableCustomerReportAuthTrait
{
    function canAccessVulnerableCustomerReport(VulnerableCustomer $report)
    {
        $user = auth()->user();
        if($user->hasRole('wsp')){
            if($user->wsps()->first()->id !== $report->bcp->wsp->id){
                abort(403,'You do not have permission to edit this Vulnerable Customer Report');
            }
        }
    }
}
