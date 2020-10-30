<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CslgCalculation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bcp()
    {
        return $this->belongsTo(Bcp::class);
    }
}
