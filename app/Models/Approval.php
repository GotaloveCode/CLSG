<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function approvable()
    {
        return $this->morphToMany();
    }

    /**
     * Get the Users for the Approval.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
