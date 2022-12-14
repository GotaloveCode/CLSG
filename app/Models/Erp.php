<?php

namespace App\Models;

use App\Traits\ProgressTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Erp extends Model
{
    use HasFactory, ProgressTrait;

    protected $fillable = [
        'period', 'wsp_id', 'coordinator', 'status'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Get the Wsp for the Bcp.
     */
    public function wsp()
    {
        return $this->belongsTo(Wsp::class);
    }

    /**
     * Get the ErpItems for the Erp.
     */
    public function erp_items()
    {
        return $this->hasMany(ErpItem::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Get the attachments for the Eoi.
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    /**
     * Get the Operationcosts for the Eoi.
     */
    public function operationcosts()
    {
        return $this->belongsToMany(Operationcost::class)
            ->withPivot('cost')
            ->withTimestamps();
    }

    /**
     * Get the approvals for the Erp.
     */
    public function approvals()
    {
        return $this->morphMany(Approval::class, 'approvable');
    }

    public function scopeOfStatus($query, $status)
    {
        $query->where('status', $status);
    }

}
