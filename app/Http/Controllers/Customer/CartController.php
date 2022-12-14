<?php

namespace App\Http\Controllers\Customer;

use App\Http\Helpers\CartHelper;
use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CartItems;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends BaseAPIController
{
    public function index()
    {
        $cartHelper = new CartHelper();
        return view('front.cart')->with([
            'cart' => $cartHelper->getCart()
        ]);
    }

    public function remove($cartItem, Request $request)
    {
        Cart::where('user_id', auth()->id())->first()->items()->find($cartItem)->delete();
        return $this->success([], trans('general.cart.removed'));
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
            ], trans('general.cart.added'));
        } else {
            $prodItem->qty = ($prodItem->qty + 1);
            $prodItem->update();
            return $this->success([
                'created' => false
            ], trans('general.cart.qty_updated'));
        }
    }

    public function checkout()
    {
        $orders = Order::where('user_id', auth()->id())->with('items', 'items.product')->orderBy('created_at', 'DESC')->get();
        return view('front.order_history')->with([
            'orders' => $orders
        ]);
    }

    public function doCheckout(Request $request)
    {
        //Get iser cart
        $cart = Cart::where('id', $request->cart_id)->where('user_id', auth()->id())->with('items')->first();
        if ($cart == null) {
            $this->fail(null, 'Invalid reqiest.');
        } else {
            DB::beginTransaction();

            // Create the order
            $order = new Order();
            $order->user_id = auth()->id();
            $order->order_number = Order::ORDER_NUMBER_PREFIX . rand(100, 9999);
            $order->amount = $cart->amount;
            $order->discount = 0; // No Discount at the moment.
            $order->gross_amount = $cart->amount;
            $order->save();

            // Create order Items
            foreach ($cart->items as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item->product_id;
                $orderItem->qty = $item->qty;
                $orderItem->sold_price = $item->product->price;
                $orderItem->save();
            }

            // Create Payment
            $payment = new Payment();
            $payment->user_id = auth()->id();
            $payment->order_id = $order->id;
            $payment->amount = $cart->amount;
            $payment->payment_method = Payment::PG_DEFAULT;
            $payment->save();

            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            return $this->success([
                'order_number' => $order->order_number
            ], trans('general.cart.order_processed'));
        }
    }
}
