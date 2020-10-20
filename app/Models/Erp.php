<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Erp extends Model
{
    use HasFactory;

    protected $fillable = [
        'period', 'wsp_id','coordinator'
    ];


    /**
     * Get the Wsp for the Bcp.
     */
    public function wsp()
    {
        return $this->belongsTo(Wsp::class);
    }

    /**
     * Get the ErpItems for the Erp.
     */
    public function erp_items()
    {
        return $this->hasMany(ErpItem::class);
    }
}
