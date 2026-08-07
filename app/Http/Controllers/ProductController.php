<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {

    $filters = $request->validate([
      'category' => ['nullable', 'string'],
      'rating' => ['nullable', 'numeric', 'min:1', 'max:5'],
      'min_price' => ['nullable', 'numeric', 'min:0'],
      'max_price' => ['nullable', 'numeric', 'gte:min_price'],
    ]);

    $products = Product::active()->filter($filters)
      ->with('category:id,name')->paginate(12)->withQueryString();

    $categories = Category::select('id', 'name')->get();

    return Inertia::render('products/Index', [
      'products' => $products,
      'categories' => $categories,

    ]);
  }

  public function show(Product $product)
  {
    $product->loadCount('reviews');

    return Inertia::render('products/Show', [
      'product' => $product,
    ]);
  }
}
