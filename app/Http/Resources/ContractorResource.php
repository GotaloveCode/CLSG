<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractorResource extends JsonResource
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
            'name' => $this->name,
            'postal_address' => $this->postal_address,
            'physical_address' => $this->physical_address,
            'postal_code_id' => $this->postal_code_id,
            'phone' => $this->phone,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'essentialsupply_wsps' => new EssentialsupplyWspCollection($this->whenLoaded('essentialsupply_wsps'))
        ];
    }
}
