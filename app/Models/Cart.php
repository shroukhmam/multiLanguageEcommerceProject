<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    public $table='carts';
    //public $primaryKey  = '_id';
   protected $fillable=['user_id','product_id','product_qty','create_at','updated_at'];

   public function products(){
       return $this->belongsTo(Product::class,'product_id');
   }
   public function users(){
    return $this->belongsTo(User::class,'user_id');
}
}
