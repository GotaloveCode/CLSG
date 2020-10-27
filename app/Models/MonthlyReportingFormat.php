<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReportingFormat extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ["format_month"];

    public function wsp()
    {
        return $this->belongsTo(Wsp::class);
    }

    public function getFormatMonthAttribute()
    {
        return \DateTime::createFromFormat("!m",$this->month)->format("F");
    }
}
