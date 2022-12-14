<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wsp extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'acronym', 'postal_address', 'physical_address', 'postal_code_id','managing_director'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }

    /**
     * Get the Users for the Wsp.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get the Eois for the Wsp.
     */
    public function eoi()
    {
        return $this->hasOne(Eoi::class);
    }


    /**
     * Get the Bcp for the Wsp.
     */
    public function bcp()
    {
        return $this->hasOne(Bcp::class);
    }

    /**
     * Get the Erp for the Wsp.
     */
    public function erp()
    {
        return $this->hasOne(Erp::class);
    }


    /**
     * Get the Staff for the Wsp.
     */
    public function staff()
    {
        return $this->hasMany(Staff::class);
    }


    /**
     * Get the Revenues for the Wsp.
     */
    public function revenues()
    {
        return $this->hasMany(Revenue::class);
    }


    public function postalcode()
    {
        return $this->belongsTo(PostalCode::class,'postal_code_id');
    }

    /**
     * Get the Monthly Verification Reports for the Wsp.
     */
    public function monthlyReports()
    {
        return $this->hasMany(MonthlyVerificationReport::class);
    }

    /**
     * Get the attachments for the Bcp.
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

}
