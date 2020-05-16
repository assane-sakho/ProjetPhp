<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use Notifiable;

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
    protected $fillable = ['lastname', 'firstname', 'card_id', 'birthdate', 'phone_number', 'email', 'password', 'address_id', 'registration_id'];

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = ['birthdate'];

    /**
     * The attributes that are hidden.
     *
     * @var array
     */
    protected $hidden = ['password'];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * The belongs to Relationship,
     * A student have an address
     *
     */
    function address()
    {
        return $this->belongsTo('App\Address');
    }

    /**
     * The belongs to Relationship
     * A student have a registration
     *
     */
    function registration()
    {
        return $this->belongsTo('App\Registration');
    }

    /**
     * The belongs to Relationship
     * A student has many messages
     *
     */
    function messages()
    {
        return $this->hasMany('App\Message');
    }

    /**
     * The fullname of the current user
     *
     */
    public function fullName()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * The folder path of the current user
     *
     */
    public function folderPath()
    {
        return 'uploads\\' . $this->id . '\\';
    }
}
