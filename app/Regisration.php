<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    public $timestamps = false;
    protected $fillable = ['training_id', 'folder_id', 'status_id', 'classicTraining', 'apprenticeshipTraining'];

    function folder()
    {
        return $this->belongsTo('App\Folder');
    }

    function registration_status()
    {
        return $this->belongsTo('App\RegistrationStatus', 'status_id', 'id');
    }

    function training()
    {
        return $this->belongsTo('App\Training');
    }

    function student()
    {
        return $this->hasOne('App\Student');
    }
}
