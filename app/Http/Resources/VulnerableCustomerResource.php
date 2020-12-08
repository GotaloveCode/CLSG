<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class VulnerableCustomerResource extends JsonResource
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
            'customer_details' => json_decode($this->customer_details),
            'wsp' => $this->bcp()->first()->wsp->name,
            'month' => \DateTime::createFromFormat("!m",$this->month)->format("F"),
            'year' => $this->year,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->format("d-m-Y")
        ];
    }
}
