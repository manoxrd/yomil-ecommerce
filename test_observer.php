<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$review = App\Models\Review::factory()->create(['rating' => 1]);
echo 'RATING: ' . App\Models\Product::find($review->product_id)->product_rating . PHP_EOL;
