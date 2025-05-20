<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = [
        'name',
        'images',
        'description',
        'price',
        'category_id',
    ];

    /**
     * Summary of category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Category, Menu>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
