<?php

namespace App\Models;

use Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $appends = ['short_description'];
    protected $hidden = [
        'updated_at', 'created_at', 'added_by', 'updated_by'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function getShortDescriptionAttribute()
    {
        return Str::limit($this->description, 40, '...');
    }
}
