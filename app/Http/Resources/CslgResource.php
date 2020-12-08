<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CslgResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'revenues' => $this->revenues,
            'wsp' => $this->bcp()->first()->wsp->name,
            'status' => $this->status,
            'revenue' => $this->revenue,
            'monthly_grant_multiplier' => $this->monthly_grant_multiplier,
            'actual_performance_score' => $this->actual_performance_score,
            'adjusted_performance_score' => $this->adjusted_performance_score,
            'gross_clsg' => $this->gross_clsg,
            'fixed_grant' => $this->fixed_grant,
            'month' => \DateTime::createFromFormat("!m",$this->month)->format("F"),
            'year' => $this->year,
            'created_at' => Carbon::parse($this->created_at)->format("d-m-Y H:i")
        ];
    }
}
