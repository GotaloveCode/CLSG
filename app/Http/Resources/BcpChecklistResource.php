<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'revenue' =>$this->revenue,
            'checklist_month' =>$this->checklist_month,
            'created_at' =>Carbon::parse($this->created_at)->format("d-m-Y H:s"),
            'wsp' =>$this->bcp()->first()->wsp->name            ,
            'operations_costs' =>$this->operations_costs,
            'clsg_total' =>$this->clsg_total,
            'challenges' =>$this->challenges,
            'expected_activities' =>$this->expected_activities,
            'essential' => json_decode($this->essential),
            'customer' => json_decode($this->customer),
            'staff' => json_decode($this->staff),
            'communication' => json_decode($this->communication),
        ];
    }
}
