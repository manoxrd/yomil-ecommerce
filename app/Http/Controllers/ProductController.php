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
    
    $products = Product::where('is_active', true)
      ->when($request->category, fn($query, $categoryName) => 
          $query->whereHas('category', fn($q) => $q->where('name', $categoryName))
      )
      ->when($request->rating, fn($query, $rating) => $query->where('rating', '>=', $rating))
      ->when($request->min_price && $request->max_price, fn($query) => $query->whereBetween('price', [$request->min_price * 100, $request->max_price * 100]))
      ->with('category')->get();

    $categories = Category::all();

    return Inertia::render('products/Index', [
      'products' => $products,
      'categories' => $categories,
    ]);
  }

  public function show(Product $product)
  {
    $product->loadAvg('reviews', 'rating')->loadCount('reviews');


    return Inertia::render('products/Show', [
      'product' => $product,
    ]);
  }
}
