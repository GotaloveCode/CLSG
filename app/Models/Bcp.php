<?php

namespace App\Models;

use App\Traits\ProgressTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bcp extends Model
{
    use HasFactory, ProgressTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'executive_summary', 'introduction', 'planning_assumptions', 'training', 'staff_health_protection', 'supply_chain',
        'emergency_response_plan', 'government_subsidy', 'communication_plan', 'wsp_id', 'status'
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
     * Get the Bcpteams for the Bcp.
     */
    public function bcpteams()
    {
        return $this->hasMany(Bcpteam::class);
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


    /**
     * Get the BcpMonthlyReports for the Bcp.
     */
    public function bcpMonthlyReports()
    {
        return $this->hasMany(BcpMonthlyReport::class);
    }

    public function mgms()
    {
        return $this->hasMany(MonthlyGrantMultiplier::class);
    }
}
