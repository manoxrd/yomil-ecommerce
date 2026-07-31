<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Number;

class Product extends Model
{
  /** @use HasFactory<ProductFactory> */
  use HasFactory;

  protected $appends = ['formatted_price'];

  public function user(): BelongsTo
  {

    return $this->belongsTo(User::class);
  }

  public function category(): BelongsTo
  {

    return $this->belongsTo(Category::class);
  }


  public function reviews(): HasMany
  {
    return $this->hasMany(Review::class);
  }

  public function relatedProducts(): BelongsToMany {
    return $this->belongsToMany(Product::class, 'related_products', 'product_id', 'related_product_id');
  }

  protected function formattedPrice(): Attribute
  {
    return Attribute::make(
      get: fn() => Number::currency($this->price / 100, "USD")
    );
  }

  protected function casts(): array
  {
    return [];
  }
}
