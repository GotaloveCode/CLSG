<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportingFormatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'wsp_id' => $this->wsp_id,
            'wsp' => $this->wsp->name,
            'format_month' => $this->format_month,
            'year' => $this->year,
            'created_at' => Carbon::parse($this->created_at)->format("d-m-Y H:i"),
            'bcp_status_implementation' => $this->bcp_status_implementation,
            'covid_status_implementation' => $this->covid_status_implementation,
            'revenues_collected' => $this->revenues_collected,
            'o_m_costs' => $this->o_m_costs,
            'amount_disbursed' => $this->amount_disbursed,
            'resolution_status' => $this->resolution_status,
            'challenges' => $this->challenges,
            'expected_activities_next_month' => $this->expected_activities_next_month,
            'score_details' => json_decode($this->scores_details)
        ];
    }
}
