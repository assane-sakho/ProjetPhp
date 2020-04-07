<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;
    protected $fillable = ['lastname', 'firstname', 'card_id', 'birthdate', 'phone_number', 'email', 'password', 'address_id'];
    protected $dates = ['birthdate'];

    function address()
    {
        return $this->belongsTo('App\Address');
    }

    function registration()
    {
        return $this->hasOne('App\Registration');
    }

    function message()
    {
        return $this->belongsTo('App\Message');
    }
}
