<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostalcodeResource extends JsonResource
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
            'code' => $this->code,
            'constituency' => $this->constituency,
            'county' => $this->county,
            'country' => $this->country,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
