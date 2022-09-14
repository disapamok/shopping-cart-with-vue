<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $timestamps = false;
    protected $table = 'carts';
    protected $fillable = ['user_id'];

    public function items()
    {
        return $this->hasMany(CartItems::class, 'cart_id', 'id');
    }
}
