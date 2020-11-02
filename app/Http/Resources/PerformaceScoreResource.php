<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PerformaceScoreResource extends JsonResource
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
            'month' => \DateTime::createFromFormat("!m",$this->month)->format("F"),
            'year' => $this->year,
            'wsp' => $this->bcp()->first()->wsp->name,
            'bcp_erp_score' => $this->bcp_erp_score,
            'bcp_score' => $this->bcp_score,
            'collection_efficiency' => $this->collection_efficiency,
            'collection_efficiency_comment' => $this->collection_efficiency_comment,
            'collection_efficiency_score' => $this->collection_efficiency_score,
            'compliance_score' => $this->compliance_score,
            'drinking_water' => $this->drinking_water,
            'drinking_water_comment' => $this->drinking_water_comment,
            'drinking_water_score' => $this->drinking_water_score,
            'erp_score' => $this->erp_score,
            'financial_score' => $this->financial_score,
            'nrw_comment' => $this->nrw_comment,
            'nrw_score' => $this->nrw_score,
            'nrw' => $this->nrw,
            'performance_score' => $this->performance_score,
            'service_per_day' => $this->service_per_day,
            'service_per_day_comment' => $this->service_per_day_comment,
            'service_per_day_score' => $this->service_per_day_score,
            'created_at' => Carbon::parse($this->created_at)->format("d-m-Y H:i"),
            'total' => (int)$this->service_per_day_score+(int)$this->performance_score+(int)$this->nrw_score+(int)$this->financial_score+(int)$this->erp_score+
                (int)$this->drinking_water_score+(int)$this->compliance_score+(int)$this->collection_efficiency_score+(int)$this->bcp_score+(int)$this->bcp_erp_score,
        ];
    }
}
