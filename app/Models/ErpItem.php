<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErpItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'emergency_intervention', 'risks', 'mitigation', 'cost', 'other', 'erp_id'
    ];

    protected $casts = ['mitigation' => 'array'];

    /**
     * Get the Wsp for the Bcp.
     */
    public function erp()
    {
        return $this->belongsTo(Erp::class);
    }

}
