<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EssentialOperation extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'priority_level', 'essentialfunction_id', 'primary_staff', 'backup_staff', 'bcp_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

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
        'primary_staff' => 'integer',
        'backup_staff' => 'integer'
    ];

    /**
     * Get the Bcp for the EssentialOperation.
     */
    public function bcp()
    {
        return $this->belongsTo(Bcp::class);
    }


    /**
     * Get the Essentialfunction for the EssentialOperation.
     */
    public function essentialfunction()
    {
        return $this->belongsTo(Essentialfunction::class);
    }

    public function primaryStaff()
    {
        return $this->belongsTo(Staff::class,'primary_staff');
    }

    public function backupStaff()
    {
        return $this->belongsTo(Staff::class,'backup_staff');
    }



}
