<?php

namespace App\Http\Helpers;

use App\Models\Cart;
use App\Models\CartItems;

class CartHelper
{
    private $theCart;

    public function __construct()
    {
        $this->theCart = Cart::firstOrCreate(['user_id' => auth()->id()]);
    }

    public function getCart()
    {
        $this->theCart->items = CartItems::where('cart_id', $this->theCart->id)->with('product', 'product.category')->get();
        return $this->theCart;
    }
}
