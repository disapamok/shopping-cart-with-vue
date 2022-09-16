<?php

namespace App\Models;

use Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $appends = ['short_description'];
    protected $hidden = [
        'updated_at', 'created_at', 'added_by', 'updated_by'
    ];
    protected $fillable = ['name', 'category_id', 'price', 'description', 'image', 'added_by'];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function getShortDescriptionAttribute()
    {
        return Str::limit($this->description, 40, '...');
    }
}
