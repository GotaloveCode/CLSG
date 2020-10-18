<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EoiListResource extends JsonResource
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
            'fixed_grant' => $this->fixed_grant,
            'variable_grant' => $this->variable_grant,
            'emergency_intervention_total' => $this->emergency_intervention_total,
            'operation_costs_total' => $this->operation_costs_total,
            'wsp' => $this->wsp->name,
            'created_at' => Carbon::parse($this->created_at)->format("d/m/Y")
        ];
    }
}
