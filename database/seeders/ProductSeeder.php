<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@yomil.com',
            'password' => bcrypt('mansour123321'),
            'role' => UserRole::Admin->value,
        ]);

        Product::factory(50)->create([
            'user_id' => $admin->id,
            'category_id' => fn () => Category::inRandomOrder()->first()->id,
        ]);
    }
}
