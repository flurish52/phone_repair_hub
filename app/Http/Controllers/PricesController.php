<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PricesController extends Controller
{

    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'Products');

        $vendor_cats = Category::orderBy('name', 'DESC')
            ->with(['children', 'children.children']) // load nested children
            ->withCount('products')
            ->where('user_id', null)
            ->get();
        $vendor_brands = Brand::orderBy('name', 'DESC')
            ->withCount('products')
            ->where('user_id', null)
            ->get();


        if ($activeTab === 'Vendors') {
            $vendors = User::role('vendor')
                ->withCount('products') // counts products per vendor
                ->orderBy('products_count', 'desc') // uses the dynamic count
                ->paginate(20);
            $products = collect();
        } else {
            $products = Product::with(['category', 'user', 'brand', 'tags', 'images', 'variants'
            => fn($q) => $q->where('status', 'active')->with('images')])
                ->inRandomOrder()
                ->paginate(52);

            $vendors = collect(); // empty collection since we're showing products
            $activeTab = 'Products'; // normalize tab name
        }

        return Inertia::render('Welcome', [
            'products' => $products,
            'vendors' => $vendors,
            'activeTab' => $activeTab,
            'vendor_brands' => $vendor_brands,
            'vendor_cats' => $vendor_cats,
        ]);
    }


}
