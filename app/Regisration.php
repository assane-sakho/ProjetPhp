<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    public $timestamps = false;
    protected $fillable = ['student_id', 'training_id', 'folder_id', 'status_id'];

   function folder()
   {
       return $this->belongsTo('App\Folder');
   }

   function registration_status()
   {
       return $this->belongsTo('App\RegistrationStatus', 'id', 'id');
   }

   function training()
   {
       return $this->belongsTo('App\Training');
   }

   function student()
   {
       return $this->belongsTo('App\Student');
   }
}
