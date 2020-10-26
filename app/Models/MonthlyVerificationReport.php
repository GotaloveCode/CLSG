<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyVerificationReport extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ["verification_month"];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function wsp()
    {
        return $this->belongsTo(Wsp::class);
    }

    public function getVerificationMonthAttribute()
    {
      return \DateTime::createFromFormat('!m', $this->month)->format('F');
    }   
}
