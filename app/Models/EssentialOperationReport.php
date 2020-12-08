<?php

namespace App\Models;

use App\Traits\ProgressTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EssentialOperationReport extends Model
{
    use HasFactory, ProgressTrait;

    protected $guarded = [];


    public function bcp()
    {
        return $this->belongsTo(Bcp::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
