<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BcpChecklistResource extends JsonResource
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
            'month' => $this->month,
            'year' =>$this->year,
            'essential' => json_decode($this->essential),
            'customer' => json_decode($this->customer),
            'staff' => json_decode($this->staff),
            'communication' => json_decode($this->communication),
        ];
    }
}
