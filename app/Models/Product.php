<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\Attributes\Sluggable;

#[Sluggable(from: 'name', to: 'slug')]

class Product extends Model
{
  /** @use HasFactory<ProductFactory> */
  use HasFactory;

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

  public function relatedProducts(): BelongsToMany
  {
    return $this->belongsToMany(Product::class, 'related_products', 'product_id', 'related_product_id');
  }

  protected function price(): Attribute
  {
    return Attribute::make(
      get: fn($value) => $value / 100,

      set: fn($value) => $value * 100
    );
  }

  protected function thumbnailUrl(): Attribute
  {
    return Attribute::get(
      fn() => $this->thumbnail
        ? Storage::disk('public')->url($this->thumbnail)
        : ''
    );
  }

  protected function casts(): array
  {
    return [
      'is_active' => 'boolean'
    ];
  }
}
