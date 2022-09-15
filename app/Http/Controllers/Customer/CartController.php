<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()])->with('items', 'items.product', 'items.product.category')->first();
        return view('front.cart')->with([
            'cart' => $cart
        ]);
    }
}
