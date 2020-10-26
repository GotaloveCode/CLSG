<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportingFormatResource extends JsonResource
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
            'wsp' => $this->wsp,
            'reporting_period' => $this->reporting_period,
            'bcp_status_implementation' => $this->bcp_status_implementation,
            'covid_status_implementation' => $this->covid_status_implementation,
            'revenues_collected' => $this->revenues_collected,
            'o_m_costs' => $this->o_m_costs,
            'amount_disbursed' => $this->amount_disbursed,
            'resolution_status' => $this->resolution_status,
            'challenges' => $this->challenges,
            'expected_activities_next_month' => $this->expected_activities_next_month,
            'achievement_details' => json_decode($this->achievement_details),
            'list_of_evidence_details' => json_decode($this->list_of_evidence_details)
        ];
    }
}
