<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
  public function index()
  {
    $products = Product::all();

    return Inertia::render('admin/products/Index', [
      'products' => $products,
    ]);
  }

  public function create()
  {
    //
  }

  public function store(Request $request)
  {
    //
  }

  public function edit(Product $product) {
    return Inertia::render('admin/products/Edit', [
      'product' => $product
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Product $product)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Product $product)
  {
    //
  }
}
