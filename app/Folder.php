<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
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
    protected $fillable = ['cv', 'cover_letter', 'vle_screenshot'];

    /**
     * The has many to Relationship
     * One folder has many report cards
     *
     */
    function report_cards()
    {
        return $this->hasMany('App\ReportCard');
    }

    /**
     * The has one to Relationship
     * One folder has one registration
     */
    function registration()
    {
        return $this->hasOne('App\Registration');
    }
}
