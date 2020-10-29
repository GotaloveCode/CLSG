<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyGrantMultiplier extends Model
{
    use HasFactory;

    protected $fillable = ['bcp_id', 'amount', 'month', 'year'];

    public function bcp()
    {
        return $this->belongsTo(Bcp::class);
    }

}
