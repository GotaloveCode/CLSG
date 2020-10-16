<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BcpResource extends JsonResource
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
            'excecutive_summary' => $this->excecutive_summary,
            'introduction' => $this->introduction,
            'planning_assumptions' => $this->planning_assumptions,
            'wsp_id' => $this->wsp_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'bcpteams' => new BcpteamCollection($this->whenLoaded('bcpteams')),
            'essential_operations' => new EssentialOperationCollection($this->whenLoaded('essential_operations')),
            'wsp' => new WspResource($this->whenLoaded('wsp'))
        ];
    }
}
