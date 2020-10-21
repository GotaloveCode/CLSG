<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operationcost extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name'
    ];


    /**
     * Get the Eois for the Operationcost.
     */
    public function eois()
    {
        return $this->belongsToMany(Eoi::class);
    }

    /**
     * Get the Bcps for the Operationcost.
     */
    public function bcps()
    {
        return $this->belongsToMany(Bcp::class);
    }

}
