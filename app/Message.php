<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{    
    public $timestamps = false;
    protected $fillable = ['student_id', 'messageContent', 'responseContent', 'messageDate', 'responseDate'];
    protected $dates = ['messageDate', 'responseDate'];

    function student()
    {
        return $this->belongsTo('App\Student');
    }
}
