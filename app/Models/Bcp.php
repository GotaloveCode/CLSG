<?php

namespace App\Models;

use App\Traits\ProgressTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bcp extends Model
{
    use HasFactory,ProgressTrait;

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

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

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
     * Get the attachments for the Bcp.
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
    /**
     * Get the Revenue Projections for the Bcp.
     */
    public function revenue_projections()
    {
        return $this->hasMany(RevenueProjection::class);
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

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
