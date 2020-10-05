<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BcpteamResource extends JsonResource
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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'unit' => $this->unit,
            'role' => $this->role,
            'training' => $this->training,
            'bpi_plan' => $this->bpi_plan,
            'erp' => $this->erp,
            'bcp_id' => $this->bcp_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'bcp' => new BcpResource($this->whenLoaded('bcp'))
        ];
    }
}
