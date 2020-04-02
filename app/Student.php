<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;
    protected $fillable = ['lastname', 'firstname', 'card_id', 'birthdate', 'phone_number', 'email', 'password', 'address_id'];

    function address()
    {
        return $this->belongsTo('App\Address');
    }
}
