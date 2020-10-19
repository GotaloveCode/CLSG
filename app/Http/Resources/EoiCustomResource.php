<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EoiCustomResource extends JsonResource
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
            'program_manager' => $this->program_manager,
            'fixed_grant' => $this->fixed_grant,
            'variable_grant' => $this->variable_grant,
            'emergency_intervention_total' => $this->emergency_intervention_total,
            'operation_costs_total' => $this->operation_costs_total,
            'months' => $this->months,
            'water_service_areas' => $this->water_service_areas,
            'total_people_water_served' => $this->total_people_water_served,
            'proportion_served' => $this->proportion_served,
            'wsp_id' => $this->wsp_id,
            'services' => $this->services,
            'connections' => $this->connections,
            'estimatedCosts' => $this->estimatedCosts,
            'operationCosts' => $this->operationCosts
        ];
    }


}
