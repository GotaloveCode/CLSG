<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyVerificationReport extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function wsp()
    {
        return $this->belongsTo(Wsp::class);
    }
}
