<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'postal_address', 'physical_address', 'postal_code_id', 'phone', 'email'
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

    public function postal_codes()
    {
        return $this->belongsTo(PostalCode::class,'postal_code_id','id');
    }

//    /**
//     * Get the essentialsupply_wsps for the Contractor.
//     */
//    public function essentialsupplyWsps()
//    {
//        return $this->hasMany(essentialsupply_wsp::class);
//    }

}
