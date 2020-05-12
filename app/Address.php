<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
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
    protected $fillable = ['street', 'city', 'zip_code'];

    /**
     * The has one to Relationship
     * One address has one student
     */
    public function student()
    {
        return $this->hasOne('App\Student');
    }
}
