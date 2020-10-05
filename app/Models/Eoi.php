<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eoi extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'program_manager', 'fixed_grant', 'variable_grant', 'emergency_intervention', 'operation_costs', 'months', 'water_service_areas', 'total_people_water_served', 'proportion_served', 'wsp_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date', 'created_at', 'updated_at'];

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
        'months' => 'integer',
        'total_people_water_served' => 'integer'
    ];

    /**
     * Get the Wsp for the Eoi.
     */
    public function wsp()
    {
        return $this->belongsTo(\App\Wsp::class);
    }


    /**
     * Get the Services for the Eoi.
     */
    public function services()
    {
        return $this->belongsToMany(\App\Service::class);
    }

    /**
     * Get the Connections for the Eoi.
     */
    public function connections()
    {
        return $this->belongsToMany(\App\Connection::class);
    }

    /**
     * Get the Estimatedcosts for the Eoi.
     */
    public function estimatedcosts()
    {
        return $this->belongsToMany(\App\Estimatedcost::class);
    }

    /**
     * Get the Operationcosts for the Eoi.
     */
    public function operationcosts()
    {
        return $this->belongsToMany(\App\Operationcost::class);
    }

}
