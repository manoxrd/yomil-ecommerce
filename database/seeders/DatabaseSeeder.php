<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Removed WithoutModelEvents to allow observers to run

  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    $this->call([
      CategorySeeder::class,
      ProductSeeder::class,
      UserSeeder::class,
      ReviewSeeder::class
    ]);
  }
}
