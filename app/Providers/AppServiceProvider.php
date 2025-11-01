<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);

        Inertia::share([
            'brands' => function () {
                return Brand::orderBy('name')->get();
            },
            'categories' => function () {
                return Category::orderBy('name')->get();
            },
            'tags' => function () {
                return Tag::orderBy('name')->get();
            },
        ]);
    }
}
