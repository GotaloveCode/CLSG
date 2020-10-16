<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WspResource extends JsonResource
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'eois' => new EoiCollection($this->whenLoaded('eois')),
            'bcps' => new BcpCollection($this->whenLoaded('bcps')),
            'staff' => new StaffCollection($this->whenLoaded('staff')),
            'revenues' => new RevenueCollection($this->whenLoaded('revenues')),
            'essentialsupplies' => new EssentialsupplyCollection($this->whenLoaded('essentialsupplies'))
        ];
    }
}
