<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BcpListResource extends JsonResource
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
            'executive_summary' => substr($this->executive_summary,0,35),
            'company_overview' => substr($this->company_overview,0,35),
            'financing' => substr($this->financing,0,35),
            'strategic_direction' => substr($this->strategic_direction,0,35),
            'environment_analysis' => substr($this->environment_analysis,0,35),
            'rationale' => substr($this->rationale,0,35),
            'status' => $this->status,
            'wsp' => $this->wsp->name,
            'created_at' => Carbon::parse($this->created_at)->format("d/m/Y")
        ];
    }
}
