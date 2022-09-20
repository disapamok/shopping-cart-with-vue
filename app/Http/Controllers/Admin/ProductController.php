<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAPIController;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddProduct;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddProduct $request)
    {
        Gate::authorize('touch_product');

        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->image = $request->imageURL;
        $product->added_by = auth()->id();
        $product->save();

        $productOb = Product::with('category')->find($product->id);

        return $this->success([
            'theProduct' => $productOb
        ], trans('general.product.added'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        Gate::authorize('touch_product');

        $product = Product::find($id);
        $product->name = $request->product_name;
        $product->category_id = $request->product_category;
        $product->image = $request->product_image;
        $product->description = $request->product_description;
        $product->updated_by = auth()->id();
        $product->update();

        $productOb = Product::with('category')->find($product->id);

        return $this->success([
            'theProduct' => $productOb
        ], trans('general.product.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('touch_product');
        Product::find($id)->delete();
        return $this->success([], trans('general.product.deleted'));
    }
}
