<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WspReportingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'month' => \DateTime::createFromFormat("!m", $this->month)->format("F"),
            'year' => $this->year,
            'wsp' => $this->bcp()->first()->wsp->name,
            'challenges' => $this->challenges,
            'challenges_cooment' => $this->challenges_cooment,
            'clsg_total' => $this->clsg_total,
            'expected_activities' => json_decode($this->expected_activities),
            'operations_costs' => json_decode($this->operations_costs),
            'revenue' => $this->revenue,
            'status_of_covid_implementation' => json_decode($this->status_of_covid_implementation),
            'status_of_resolution' => $this->status_of_resolution,
            'status_of_resolution_comment' => $this->status_of_resolution_comment,
            'status' => $this->status,
            'attachments' => $this->attachments,
            'comments' => $this->comments,
            'created_at' => Carbon::parse($this->created_at)->format("d-m-Y H:i")
        ];
    }
}
