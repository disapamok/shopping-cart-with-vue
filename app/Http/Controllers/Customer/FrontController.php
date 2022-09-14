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
        return view('front.product-list')->with([
            'categories' => $categories
        ]);
    }

    public function addToCart(Request $request)
    {
        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        // Check if the cart item is already exists.
        $prodItem = CartItems::where('cart_id', $cart->id)->where('product_id', $request->product_id)->first();

        if ($prodItem == null) {
            $cart->items()->save(new CartItems(['product_id' => $request->product_id]));
        } else {
            $prodItem->qty = ($prodItem->qty + 1);
            $prodItem->update();
        }

        return $this->success([], 'The product has been added to the cart.');
    }
}
