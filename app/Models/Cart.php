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

    public function getAmountAttribute()
    {
        $amount = 0;
        foreach ($this->items as $item)
            $amount += ($item->qty * $item->product->price);

        return number_format((float) $amount, 2, '.', '');
    }
}
