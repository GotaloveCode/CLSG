<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VerificationResource extends JsonResource
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
            'wsp' => $this->wsp->name,
            'wsp_id' => $this->wsp_id,
            'month' => $this->month,
            'year' => $this->year,
            'verification_team' => $this->verification_team,
            'recommendations' => $this->recommendations,
            'performance_score_details' => json_decode($this->performance_score_details),
            'clsg_details' => json_decode($this->clsg_details)
        ];
    }
}
