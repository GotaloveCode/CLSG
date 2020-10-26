<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ErpResource extends JsonResource
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
            'period' => $this->period,
            'coordinator'=> $this->coordinator,
            'erp_items' => $this->erp_items,
            'wsp_id' => $this->wsp_id
        ];

    }
}
