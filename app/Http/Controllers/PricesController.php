<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PricesController extends Controller
{

    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'Accessories');

        if ($activeTab === 'Vendors') {
            $vendors = User::role('vendor')
                ->withCount('products')
                ->inRandomOrder()
                ->paginate(20);
            $products = collect(); // empty collection since we're showing vendors
        } else {
            $products = Product::with(['category', 'user', 'brand', 'tags', 'variants.images', 'images'])
                ->inRandomOrder()
                ->paginate(50);
            $vendors = collect(); // empty collection since we're showing products
            $activeTab = 'Accessories'; // normalize tab name
        }

        return Inertia::render('Welcome', [
            'products' => $products,
            'vendors' => $vendors,
            'activeTab' => $activeTab,
        ]);
    }








}
