<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
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
     * Get the Eois for the Service.
     */
    public function eois()
    {
        return $this->belongsToMany(Eoi::class)
            ->withPivot('areas', 'total')
            ->withTimestamps();
    }

}
