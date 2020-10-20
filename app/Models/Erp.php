<?php

namespace App\Models;

use App\Traits\ProgressTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Erp extends Model
{
    use HasFactory, ProgressTrait;

    protected $fillable = [
        'period', 'wsp_id', 'coordinator'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

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
