<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    public $timestamps = false;
    protected $fillable = ['student_id', 'training_id', 'folder_id', 'status_id'];

   function folder()
   {
       return $this->hasOne('App\Folder');
   }

   function status()
   {
       return $this->hasOne('App\Folder');
   }

   function training()
   {
       return $this->hasOne('App\Folder');
   }
}
