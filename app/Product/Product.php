<?php

namespace App\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=[
        'name','detail','price','discount','stock','img'
    ];

   public function reviews(){
       return $this->hasMany(\App\Product\Review\Review::class);
   }

   public function user()
   {
       return $this->belongsTo(\App\User::class);
   }
}
