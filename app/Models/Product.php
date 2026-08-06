<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\Attributes\Sluggable;

#[Fillable(['name', 'stock', 'price', 'is_active', 'description', 'thumbnail', 'category_id'])]
#[Sluggable(from: 'name', to: 'slug')]

/**
 * @method static Builder<static> active()
 */
class Product extends Model
{
  /** @use HasFactory<ProductFactory> */
  use HasFactory, SoftDeletes;

  protected $appends = ['thumbnail_url'];

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

  #[Scope]
  protected function active(Builder $query): void
  {
    $query->where('is_active', true);
  }

  #[Scope]
  protected function filter(Builder $query, array $filters): void
  {
    $query->when(
      $filters['category'] ?? null,
      fn($query, $categoryName) => $query->whereHas('category', fn($q) => $q->where('name', $categoryName))
    )
      ->when($filters['rating'] ?? null, fn($query, $rating) => $query->where('rating', '>=', $rating))
      ->when(isset($filters['min_price'], $filters['max_price']), fn($query) => $query->whereBetween('price', [$filters['min_price'] * 100, $filters['max_price'] * 100]));
  }





  // ->when($request->category, fn ($query, $categoryName) => $query->whereHas('category', fn ($q) => $q->where('name', $categoryName))
  // )
  // ->when($request->rating, fn ($query, $rating) => $query->where('rating', '>=', $rating))
  // ->when($request->min_price && $request->max_price, fn ($query) => $query->whereBetween('price', [$request->min_price * 100, $request->max_price * 100]))

  protected function casts(): array
  {
    return [
      'is_active' => 'boolean',
    ];
  }
}
