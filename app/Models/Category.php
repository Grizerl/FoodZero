<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [ 'name', 'images_category' ];

    /**
     * Summary of menu
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Menu, Category>
     */
    public function menu(): HasMany
    {
        return $this->hasMany(Menu::class, 'category_id');
    }
}
