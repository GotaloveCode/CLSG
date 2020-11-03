<?php

namespace App\Models;

use App\Traits\ProgressTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WspReporting extends Model
{
    use HasFactory, ProgressTrait;

    protected $guarded = [];

    public function bcp()
    {
        return $this->belongsTo(Bcp::class);
    }

    /**
     * Get the attachments for the Wsp Reporting.
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
