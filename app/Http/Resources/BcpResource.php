<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BcpResource extends JsonResource
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
            'executive_summary' => $this->executive_summary,
            'introduction' => $this->introduction,
            'planning_assumptions' => $this->planning_assumptions,
            'training' => $this->training,
            'staff_health_protection' => $this->staff_health_protection,
            'supply_chain' => $this->supply_chain,
            'emergency_response_plan' => $this->emergency_response_plan,
            'communication_plan' => $this->communication_plan,
            'government_subsidy' => $this->government_subsidy,
            'projected_revenues' => $this->revenue_projections,
            'bcp_teams'=> $this->bcpteams,
            'essential_operations' => $this->essentialOperations,
            'wsp_id' => $this->wsp_id
        ];

    }
}
