<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $userIds = User::pluck('id');
    $productIds = Product::pluck('id');

    Review::factory(3000)->create([
      'user_id' => fn() => $userIds->random(),
      'product_id' => fn() => $productIds->random()
    ]);
  }
}
