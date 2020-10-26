<?php

namespace App\Models;

use App\Traits\ProgressTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eoi extends Model
{
    use HasFactory, ProgressTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'program_manager', 'fixed_grant', 'variable_grant', 'emergency_intervention_total', 'operation_costs_total', 'months', 'water_service_areas', 'total_people_water_served', 'proportion_served', 'wsp_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['date', 'created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'months' => 'integer',
        'total_people_water_served' => 'integer'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }

    /**
     * Get the Wsp for the Eoi.
     */
    public function wsp()
    {
        return $this->belongsTo(Wsp::class);
    }


    /**
     * Get the Services for the Eoi.
     */
    public function services()
    {
        return $this->belongsToMany(Service::class)
            ->withPivot('areas', 'total')
            ->withTimestamps();
    }

    /**
     * Get the Connections for the Eoi.
     */
    public function connections()
    {
        return $this->belongsToMany(Connection::class)
            ->withPivot('areas', 'total')
            ->withTimestamps();
    }

    /**
     * Get the Estimatedcosts for the Eoi.
     */
    public function estimatedcosts()
    {
        return $this->belongsToMany(Estimatedcost::class)
            ->withPivot('unit', 'quantity', 'total')
            ->withTimestamps();
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
     * Get the attachments for the Eoi.
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function scopeOfStatus($builder, $value): void
    {
        $builder->where('status', $value);
    }

    public function list()
    {
        return $this->select('id', 'fixed_grant', 'variable_grant', 'emergency_intervention_total', 'operation_costs_total', 'wsp_id', 'wsps.name')
            ->with('wsp:id,name');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scopeSearch($query, string $terms = null)
    {
        if (!$terms) return;
        collect(str_getcsv($terms, ' ', '"'))->filter()->each(function ($term) use ($query) {
            $query->where('wsps.name', 'like', $term . '%');
        });
    }

}
