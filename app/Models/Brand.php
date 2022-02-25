<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
     //
     use Translatable;

     /**
      * The relations to eager load on every query.
      *
      * @var array
      */
     protected $with = ['translations'];
 
 
     protected $translatedAttributes = ['name'];
 
     /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
     protected $fillable = ['photo', 'is_active'];
 
     /**
      * The attributes that should be hidden for serialization.
      *
      * @var array
      */
     protected $hidden = ['translations'];
 
     /**
      * The attributes that should be cast to native types.
      *
      * @var array
      */
     protected $casts = [
          'is_active' => 'boolean',
     ];
 
 
     
     public function getActive(){
         return $this->is_active==1?__('admin/category.active'):__('admin/category.notactive');
     }
     public function scopeActive($query){
         return $this->where('is_active',1);

     }

     public function getPhotoAttribute($val){
         return($val!==null)?asset('assets/images/brands/'.$val):"";
     }

     
   
}
