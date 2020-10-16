<?php

namespace App\Traits;



use App\Models\Eoi;

trait EoiAuthTrait
{
    function canAccessEoi(Eoi $eoi)
    {
        $user = auth()->user();
        if($user->hasRole('wsp')){
            if($user->wsps()->first()->id !== $eoi->wsp_id){
                abort('403','You do not have permission to edit this EOI');
            }
        }
    }
}
