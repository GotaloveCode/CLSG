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
            'revenues_comment' => $this->revenues_comment,
            'grant_multiplier_amount' => $this->grant_multiplier_amount,
            'grant_multiplier_comment' => $this->grant_multiplier_comment,
            'cslg_gross_amount' => $this->cslg_gross_amount,
            'cslg_gross_comment' => $this->cslg_gross_comment,
            'cslg_adjusted_amount' => $this->cslg_adjusted_amount,
            'cslg_adjusted_comment' => $this->cslg_adjusted_comment,
            'month' => \DateTime::createFromFormat("!m",$this->month)->format("F"),
            'year' => $this->year,
            'created_at' => Carbon::parse($this->created_at)->format("d-m-Y H:i")
        ];
    }
}
