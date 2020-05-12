<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     *  Dont change the timestamps on save.
     *
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['student_id', 'messageContent', 'responseContent', 'messageDate', 'responseDate'];

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = ['messageDate', 'responseDate'];

    /**
     * The belongs to Relationship
     * One message belongs to one student
     */
    function student()
    {
        return $this->belongsTo('App\Student');
    }
}
