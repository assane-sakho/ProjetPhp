<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    public $timestamps = false;
    protected $fillable = ['cv', 'cover_letter', 'vle_screenshot'];

    function report_card()
    {
        return $this->hasMany('App\ReportCard');
    }

    function registration()
    {
        return $this->hasOne('App\Registration');
    }
}
