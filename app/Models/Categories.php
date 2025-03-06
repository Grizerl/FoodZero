<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
   protected $fillable = [ 'name','images_category' ];

   public function menu() {
        return $this->hasMany(Menu::class,'category_id');
   }
}
