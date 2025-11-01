<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PricesController extends Controller
{

    public function index(Request $request)
    {
        $selectedProduct = null;
        $activeTab = null;

        // Check if the request has a 'product' query parameter
        if ($request->has('product')) {
            $selectedProduct = [
                'id' => 1,
                'name' => 'iPhone 11 Case',
                'brand' => 'Oraimo',
                'category' => 'Accessories',
                'vendor' => 'Joseph Communications',
                'price' => 2000,
                'image_url' => '/images/case1.jpg',
                'tag' => 'Hot',
                'slug' => $request->query('product'),
                'description' => 'A high-quality protective case for iPhone 11.'
            ];
            $activeTab = 'Accessories';
        }

        return Inertia::render('Prices', [
            'selectedProduct' => $selectedProduct,
            'activeTab' => $activeTab // optional default tab
        ]);
    }

}
