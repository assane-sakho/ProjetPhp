<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationStatus extends Model
{
    public $timestamps = false;
    protected $fillable = ['title'];


    function registration()
    {
        return $this->hasMany('App\Registration', 'id', 'status_id');
    }
}
