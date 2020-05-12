<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportCard extends Model
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
    protected $fillable = ['name', 'folder_id'];

    /**
     * The belongs to Relationship
     * One report card belongs to one folder
     *
     */
    function folder()
    {
        return $this->belongsTo('App\Folder');
    }
}
