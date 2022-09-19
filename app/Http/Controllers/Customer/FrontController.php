<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\BaseAPIController;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontController extends BaseAPIController
{
    public function listProducts()
    {
        $categories = Category::with('products')->get();
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $cart->items = CartItems::where('cart_id', $cart->id)->get();

        return view('front.product-list')->with([
            'categories' => $categories,
            'cart' => $cart
        ]);
    }
}
