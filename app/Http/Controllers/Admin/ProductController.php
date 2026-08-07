<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{
  public function index()
  {
    $products = Product::with('category')->get();

    return Inertia::render('admin/products/Index', [
      'products' => $products,
    ]);
  }

  public function create()
  {
    $categories = Category::select('id', 'name')->get();

    return Inertia::render('admin/products/Create', [
      'categories' => $categories
    ]);
  }

  public function store(StoreProductRequest $request)
  {
    $validated = $request->validated();

    if ($request->hasFile('thumbnail')) {

      $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
    } else {
      unset($validated['thumbnail']);
    }

    $product = $request->user()->products()->create($validated);

    return redirect()->route('admin.products.edit', $product->id);
  }

  public function edit(Product $product)
  {
    $categories = Category::select('id', 'name')->get();

    return Inertia::render('admin/products/Edit', [
      'product' => $product,
      'categories' => $categories
    ]);
  }

  public function update(UpdateProductRequest $request, Product $product)
  {

    $validated = $request->validated();
    
    if ($request->hasFile('thumbnail')) {

      if ($product->thumbnail) {
        Storage::disk('public')->delete($product->thumbnail);
      }

      $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
    } else {
      unset($validated['thumbnail']);
    }

    $product->update($validated);

    return redirect()->route('admin.products.edit', $product->id);
  }

  public function destroy(Product $product)
  {
    $product->delete();
    return redirect()->route('admin.products.index');
  }
}
