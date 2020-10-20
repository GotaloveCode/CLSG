<?php

namespace App\Traits;



use App\Models\Erp;

trait ErpAuthTrait
{
    function canAccessErp(Erp $erp)
    {
        $user = auth()->user();
        if($user->hasRole('wsp')){
            if($user->wsps()->first()->id !== $erp->wsp_id){
                abort('403','You do not have permission to edit this ERP');
            }
        }
    }
}
