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
    $category = Category::where('name', $request->category)->first();

    $rating = $request->rating;

    // $products = Product::where('is_active', true)
    // ->when($category?->id, fn($query, $category) => $query->where('category_id', $category))
    // ->when($rating, fn($query, $rating) => $query->where('product_rating', '<=', $rating))
    // ->with('category')->withAvg('reviews', 'rating')->withCount('reviews')->get();

    $products = Product::where('is_active', true)
      ->when($category?->id, fn($query, $category) => $query->where('category_id', $category))
      ->when($rating, fn($query, $rating) => $query->where('rating', '>=', $rating))
      ->with('category')->get();

    $categories = Category::all();

    return Inertia::render('products/Index', [
      'products' => $products,
      'category' => $category,
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
