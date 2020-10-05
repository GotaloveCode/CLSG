<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wsp extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'acronym', 'postal_address', 'physical_address', 'postal_code_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * Get the Eois for the Wsp.
     */
    public function eois()
    {
        return $this->hasMany(Eoi::class);
    }


    /**
     * Get the Bcps for the Wsp.
     */
    public function bcps()
    {
        return $this->hasMany(Bcp::class);
    }


    /**
     * Get the Staff for the Wsp.
     */
    public function staff()
    {
        return $this->hasMany(Staff::class);
    }


    /**
     * Get the Revenues for the Wsp.
     */
    public function revenues()
    {
        return $this->hasMany(Revenue::class);
    }


    /**
     * Get the Essentialsupplies for the Wsp.
     */
    public function essentialsupplies()
    {
        return $this->belongsToMany(Essentialsupply::class);
    }

}
