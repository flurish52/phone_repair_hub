<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PricesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepairsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;


Route::get('/vendor/{slug}', [ProductListingController::class, 'viewVendorProducts'])->name('vendor.products');
Route::get('/products/{vendor}/{product}/details', [ProductListingController::class, 'ViewProduct'])->name('vendor.product.details');
Route::get('/categories/{category}', [ProductListingController::class, 'ViewCatProduct'])->name('category.products');
Route::get('/brands/{brand}', [ProductListingController::class, 'viewBrandProduct'])->name('category.products');
Route::get('/products', [PricesController::class, 'index'])->name('products.tab');
Route::get('/', [ProductListingController::class, 'welcome'])->name('products.tab');
Route::get('/search', [SearchController::class, 'index'])->name('search');



Route::get('/dashboard', [RepairsController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(callback: function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/repairs', [RepairsController::class, 'index'])->name('repairs.get');
    Route::post('/repair/create', [RepairsController::class, 'store'])->name('repair.store');
    Route::post('/repair/update/{repair}', [RepairsController::class, 'update'])->name('repair.update');
    Route::delete('/repair/delete/{repair}', [RepairsController::class, 'destroy'])->name('repair.delete');
    Route::get('/fetch/repairs', [RepairsController::class, 'sortAndFilter'])->name('repair.sort.filter');

    Route::patch('/repair/update/status/{repair}', [RepairsController::class, 'updateStatus'])->name('repair.status.update');


    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::get('/product/update/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/create', [ProductController::class, 'store'])->name('product.store');
    Route::post('/product/update/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/product/delete/{product}', [ProductController::class, 'destroy'])->name('product.destroy');


    Route::get('/product/{vendor}/{product}/view', [ProductController::class, 'vendorViewProduct'])->name('product.vendor.view');
    Route::delete('/product/delete/{product}', [ProductController::class, 'destroy'])->name('product.vendor.delete');


    Route::get('/vendor/categories/get', [CategoryController::class, 'index'])->name('categoriesget');
    Route::post('/vendor/categories/create', [CategoryController::class, 'store'])->name('categories.store');

    Route::patch('/vendor/category/{category}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/vendor/category/{category}/delete', [CategoryController::class, 'destroy'])->name('categories.delete');


    Route::get('/vendor/brands/get', [BrandController::class, 'index'])->name('brands.get');
    Route::post('/vendor/brand/create', [BrandController::class, 'store'])->name('brands.store');
    Route::patch('/vendor/brand/{brand}/update', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/vendor/brand/{brand}/delete', [BrandController::class, 'destroy'])->name('brands.delete');

Route::get('/vendor/settings/get', [SettingsController::class, 'index'])->name('settings.get');
    Route::post('/vendor/profile/update', [SettingsController::class, 'update'])->name('vendor.profile.update');

});

require __DIR__ . '/auth.php';
