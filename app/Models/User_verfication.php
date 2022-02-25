<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_verfication extends Model
{
    //
   public $table='usersverficationcode';
   protected $fillable=['user_id','code','create_at','updated_at'];
   
}
