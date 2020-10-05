<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EssentialOperationResource extends JsonResource
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
            'priority_level' => $this->priority_level,
            'essentialfunction_id' => $this->essentialfunction_id,
            'primary_staff' => $this->primary_staff,
            'backup_staff' => $this->backup_staff,
            'bcp_id' => $this->bcp_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'bcp' => new BcpResource($this->whenLoaded('bcp')),
            'essentialfunction' => new EssentialfunctionResource($this->whenLoaded('essentialfunction'))
        ];
    }
}
