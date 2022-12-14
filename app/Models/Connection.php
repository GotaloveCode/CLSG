<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name'
    ];


    /**
     * Get the Eois for the Connection.
     */
    public function eois()
    {
        return $this->belongsToMany(Eoi::class);
    }

}
