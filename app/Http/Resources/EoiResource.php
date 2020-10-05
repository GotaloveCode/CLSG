<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EoiResource extends JsonResource
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
            'date' => $this->date,
            'program_manager' => $this->program_manager,
            'fixed_grant' => $this->fixed_grant,
            'variable_grant' => $this->variable_grant,
            'emergency_intervention' => $this->emergency_intervention,
            'operation_costs' => $this->operation_costs,
            'months' => $this->months,
            'water_service_areas' => $this->water_service_areas,
            'total_people_water_served' => $this->total_people_water_served,
            'proportion_served' => $this->proportion_served,
            'wsp_id' => $this->wsp_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'services' => new ServiceCollection($this->whenLoaded('services')),
            'connections' => new ConnectionCollection($this->whenLoaded('connections')),
            'estimatedcosts' => new EstimatedcostCollection($this->whenLoaded('estimatedcosts')),
            'operationcosts' => new OperationcostCollection($this->whenLoaded('operationcosts')),
            'wsp' => new WspResource($this->whenLoaded('wsp'))
        ];
    }
}
