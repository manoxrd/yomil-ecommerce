<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique()->index();
            $table->integer('price');
            $table->float('rating')->nullable();
            $table->integer('reviews_count')->nullable();
            $table->integer('discount')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->integer('stock')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
