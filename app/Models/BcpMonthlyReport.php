<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcpMonthlyReport extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ["checklist_month"];

    public function bcp()
    {
        return $this->belongsTo(Bcp::class);
    }
  
    public function getChecklistMonthAttribute()
    {
        return \DateTime::createFromFormat("!m",$this->month)->format("F");
    }
}
