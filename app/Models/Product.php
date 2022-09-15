<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $hidden = [
        'updated_at', 'created_at', 'added_by', 'updated_by'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
