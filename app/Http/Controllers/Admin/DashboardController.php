<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function dashboard()
    {
        Gate::authorize('touch_product');

        $categories = Category::all();
        $products = Product::all();

        return view('admin.dashboard')->with([
            'categories' => $categories,
            'product' => $products
        ]);
    }
}
