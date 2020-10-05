<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
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
            'position' => $this->position,
            'skills' => $this->skills,
            'qualifications' => $this->qualifications,
            'wsp_id' => $this->wsp_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'wsp' => new WspResource($this->whenLoaded('wsp'))
        ];
    }
}
