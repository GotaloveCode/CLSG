<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Essentialfunction extends Model
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


    protected $dates = ['created_at', 'updated_at'];


    /**
     * Get the EssentialOperations for the Essentialfunction.
     */
    public function essentialOperations()
    {
        return $this->hasMany(EssentialOperation::class);
    }

}
