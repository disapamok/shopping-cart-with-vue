<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function listProducts()
    {
        $categories = Category::with('products')->get();
        return view('front.product-list')->with([
            'categories' => $categories
        ]);
    }
}
