<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bcpteam extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'unit', 'role', 'bcp_id'
    ];

}
