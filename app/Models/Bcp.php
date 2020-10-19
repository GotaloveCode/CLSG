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
        'executive_summary', 'rationale', 'environment_analysis', 'company_overview', 'financing', 'strategic_direction',
        'strategic_plans','wsp_id'
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
     * Get the Objectives for the Bcp.
     */
    public function objectives()
    {
        return $this->hasMany(Objective::class);
    }

    /**
     * Get the Operationcosts for the Eoi.
     */
    public function operationcosts()
    {
        return $this->belongsToMany(Operationcost::class)
            ->withPivot('quantity', 'unit_rate', 'total')
            ->withTimestamps();
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
