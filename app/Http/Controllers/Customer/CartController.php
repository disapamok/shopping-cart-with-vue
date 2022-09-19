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

    public function addToCart(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        // Check if the cart item is already exists.
        $prodItem = CartItems::where('cart_id', $cart->id)->where('product_id', $request->product_id)->first();

        if ($prodItem == null) {
            $cart->items()->save(new CartItems(['product_id' => $request->product_id]));
            return $this->success([
                'created' => true
            ], 'The product has been added to the cart.');
        } else {
            $prodItem->qty = ($prodItem->qty + 1);
            $prodItem->update();
            return $this->success([
                'created' => false
            ], 'The product quantity has been updated.');
        }
    }

    public function checkout()
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()])->with('items', 'items.product')->first();
        return view('front.checkout')->with([
            'cart' => $cart
        ]);
    }

    public function doCheckout()
    {
    }
}
