<?php

use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\UserHasRole;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', UserHasRole::class . ':admin,employee'])->prefix('admin')->name('admin.')->group(function () {

  Route::inertia('dashboard', 'admin/Dashboard')->name('dashboard');

  Route::get('products', [AdminProductController::class, 'index'])->name('products.index');

  Route::get('products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
  Route::patch('products/{product}', [AdminProductController::class, 'update'])->name('products.update');

  Route::get('products/create', [AdminProductController::class, 'create'])->name('products.create');
  Route::post('products', [AdminProductController::class, 'store'])->name('products.store');
});

Route::get('products', [ProductController::class, 'index'])->name('products.index');

Route::get('products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

require __DIR__ . '/settings.php';
