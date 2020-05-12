<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrationStatus extends Model
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
    protected $fillable = ['title'];

    /**
     * The has many to Relationship
     * One status has many registrations
     */
    function registration()
    {
        return $this->hasMany('App\Registration', 'id', 'status_id');
    }
}
