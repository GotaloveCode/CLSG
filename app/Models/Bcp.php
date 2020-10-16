<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bcp extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'executive_summary', 'introduction', 'planning_assumptions', 'wsp_id'
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
     * Get the Bcpteams for the Bcp.
     */
    public function bcpteams()
    {
        return $this->hasMany(Bcpteam::class);
    }


    /**
     * Get the EssentialOperations for the Bcp.
     */
    public function essentialOperations()
    {
        return $this->hasMany(EssentialOperation::class);
    }


    /**
     * Get the Wsp for the Bcp.
     */
    public function wsp()
    {
        return $this->belongsTo(Wsp::class);
    }

}
