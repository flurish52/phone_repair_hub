<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
                return Category::with('children')
                    ->whereNull('parent_id')
                    ->withCount('products')
                    ->has('products')
                    ->where(function ($query) {
                        $query->whereNull('user_id')
                            ->orWhere('user_id', 0);
                    })
                    ->orderBy('name')
                    ->get();
            },

            'vendors_list' => function () {
                return User::role('vendor')
                    ->withCount('products')
                    ->has('products')       // only vendors with products
                    ->orderBy('products_count', 'desc')
                    ->get();
            },
            'tags' => function () {
                return Tag::orderBy('name')->get();
            },
            'roles' => function () {
                return DB::table('roles')->orderBy('name')->get();
            },
        ]);
    }
}
