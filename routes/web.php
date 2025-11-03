<?php

use App\Http\Controllers\PricesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RepairsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/', function () {
//    return Inertia::render('Auth/Login', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

//Route::get('/', function () {
//    return Inertia::render('welcome', [
//    ]);
//});
Route::get('/vendor/{slug}', [ProductListingController::class, 'viewVendorProducts'])->name('vendor.products');
Route::get('/products/{vendor}/{product}/details', [ProductListingController::class, 'ViewProduct'])->name('vendor.product.details');
Route::get('/categories/{category}', [ProductListingController::class, 'ViewCatProduct'])->name('category.products');
Route::get('/brands/{brand}', [ProductListingController::class, 'viewBrandProduct'])->name('category.products');
    Route::get('/accessories', [PricesController::class, 'index'])->name('products.tab');
    Route::get('/', [ProductListingController::class, 'welcome'])->name('products.tab');
//    Route::get('/vendors', [ProductListingController::class, 'allVendors'])->name('products.tab');



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

});

require __DIR__.'/auth.php';
