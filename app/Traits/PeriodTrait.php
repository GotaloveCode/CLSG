<?php


namespace App\Traits;


use Carbon\Carbon;

trait PeriodTrait
{

    function getMonth()
    {
        return Carbon::now()->format("m");
    }

    function getYear()
    {
        return Carbon::now()->format("Y");
    }
}
