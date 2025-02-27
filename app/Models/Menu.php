<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $table = 'menu';
    protected $fillable = [
        'name',
        'images',
        'description',
        'price',
        'category_id',
    ];

    public function category() {
        return $this->belongsTo(Categories::class);
    }
}
