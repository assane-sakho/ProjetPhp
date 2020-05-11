<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    /**
     *  Dont change the timestamps on save.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['training_id', 'folder_id', 'status_id', 'classicTraining', 'apprenticeshipTraining'];

    /**
     * The belongs to Relationship
     * One registration belongs to one folder
     */
    function folder()
    {
        return $this->belongsTo('App\Folder');
    }

    /**
     * The belongs to Relationship
     * One registration belongs to one status
     */
    function registration_status()
    {
        return $this->belongsTo('App\RegistrationStatus', 'status_id', 'id');
    }

    /**
     * The belongs to Relationship
     * One registration belongs to one training
     */
    function training()
    {
        return $this->belongsTo('App\Training');
    }

    /**
     * The has one to Relationship
     * One registration has one student
     */
    function student()
    {
        return $this->hasOne('App\Student');
    }
}
