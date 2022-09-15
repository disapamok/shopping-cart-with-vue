<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItems;
use Illuminate\Http\Request;

class CartController extends BaseAPIController
{
    public function index()
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()])->with('items', 'items.product', 'items.product.category')->first();
        return view('front.cart')->with([
            'cart' => $cart
        ]);
    }

    public function remove($cartItem, Request $request)
    {
        Cart::where('user_id', auth()->id())->first()->items()->find($cartItem)->delete();
        return $this->success([], 'The item has been removed from the cart.');
    }
}
