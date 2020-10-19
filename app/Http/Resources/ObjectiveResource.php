<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ObjectiveResource extends JsonResource
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
            'desscription' => $this->desscription,
            'bcp_id' => $this->bcp_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'bcp' => new BcpResource($this->whenLoaded('bcp'))
        ];
    }
}
