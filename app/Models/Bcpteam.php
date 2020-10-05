<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bcpteam extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'firstname', 'lastname', 'unit', 'role', 'training', 'bpi_plan', 'erp', 'bcp_id'
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
     * Get the Bcp for the Bcpteam.
     */
    public function bcp()
    {
        return $this->belongsTo(\App\Bcp::class);
    }

}
