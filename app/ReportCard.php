<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportCard extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'folder_id'];
}
