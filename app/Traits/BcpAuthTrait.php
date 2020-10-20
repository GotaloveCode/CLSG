<?php

namespace App\Traits;



use App\Models\Bcp;

trait BcpAuthTrait
{
    function canAccessBcp(Bcp $bcp)
    {
        $user = auth()->user();
        if($user->hasRole('wsp')){
            if($user->wsps()->first()->id !== $bcp->wsp_id){
                abort('403','You do not have permission to edit this BCP');
            }
        }
    }

}
