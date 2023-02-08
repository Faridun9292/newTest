<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::query()
            ->latest()
            ->paginate(30);

        return view('products.index', compact('products'));
    }


    public function create()
    {
        return view('products.create');
    }


    public function store(ProductRequest $request, Product $product)
    {
        $product->create($request->validated());

        return to_route('products.index');
    }


    public function edit(Product $product)
    {
       return view('products.edit', compact('product'));
    }


    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return to_route('products.index');
    }


    public function destroy(Product $product)
    {
        $product->delete();

        return back();
    }
}
