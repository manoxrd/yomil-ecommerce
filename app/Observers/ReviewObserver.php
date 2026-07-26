<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Review;

class ReviewObserver
{
  /**
   * Handle the Review "saved" event (covers created and updated).
   */
  public function saved(Review $review): void
  {
    // 1. Get the average rating from the REVIEWS table, not the products table.
    $averageRating = Review::where('product_id', $review->product_id)->avg('rating');
    $reviewsCount = Review::where('product_id', $review->product_id)->count();

    // 2. Update the product_rating column on the PRODUCTS table.
    Product::where('id', $review->product_id)->update([
      'rating' => $averageRating,
      'reviews_count' => $reviewsCount

    ]);
  }

  /**
   * Handle the Review "deleted" event.
   */
  public function deleted(Review $review): void
  {
    $averageRating = Review::where('product_id', $review->product_id)->avg('rating');

    Product::where('id', $review->product_id)->update([
      'product_rating' => $averageRating
    ]);
  }

  /**
   * Handle the Review "restored" event.
   */
  public function restored(Review $review): void
  {
    //
  }

  /**
   * Handle the Review "force deleted" event.
   */
  public function forceDeleted(Review $review): void
  {
    //
  }
}
