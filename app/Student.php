<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;
    protected $fillable = ['lastname', 'firstname', 'card_id', 'birthdate', 'phone_number', 'email', 'password', 'address_id', 'registration_id'];
    protected $dates = ['birthdate'];
    protected $hidden = ['password'];

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }
    
    function address()
    {
        return $this->belongsTo('App\Address');
    }

    function registration()
    {
        return $this->belongsTo('App\Registration');
    }

    function message()
    {
        return $this->belongsTo('App\Message');
    }

    public function fullName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function folderPath()
    {
        return 'uploads\\' . $this->id . '\\';
    }
}
