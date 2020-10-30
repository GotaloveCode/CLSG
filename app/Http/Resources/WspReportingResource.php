<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WspReportingResource extends JsonResource
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
            'bcp_erp_evidence' => $this->bcp_erp_evidence,
            'bcp_erp_score' => $this->bcp_erp_score,
            'bcp_evidence' => $this->bcp_evidence,
            'bcp_score' => $this->bcp_score,
            'challenges' => $this->challenges,
            'challenges_cooment' => $this->challenges_cooment,
            'clsg_total' => $this->clsg_total,
            'collection_efficiency' => $this->collection_efficiency,
            'collection_efficiency_comment' => $this->collection_efficiency_comment,
            'collection_efficiency_score' => $this->collection_efficiency_score,
            'compliance_evidence' => $this->compliance_evidence,
            'compliance_score' => $this->compliance_score,
            'drinking_water' => $this->drinking_water,
            'drinking_water_comment' => $this->drinking_water_comment,
            'drinking_water_score' => $this->drinking_water_score,
            'erp_evidence' => $this->erp_evidence,
            'erp_score' => $this->erp_score,
            'expected_activities' => json_encode($this->expected_activities),
            'financial_evidence' => $this->financial_evidence,
            'nrw_comment' => $this->nrw_comment,
            'nrw_score' => $this->nrw_score
        ];
    }
}
