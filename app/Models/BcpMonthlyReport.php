<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BcpMonthlyReport extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bcp()
    {
        return $this->belongsTo(Bcp::class);
    }
}
