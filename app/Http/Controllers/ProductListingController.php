<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Inertia\Inertia;

class ProductListingController extends Controller
{


    public function viewVendorProducts($slug)
    {
        $vendor = User::role('vendor')->where('slug', $slug)->first();

        $vendors = User::role('vendor')
            ->withCount('products')
            ->inRandomOrder()
            ->paginate(20);

        if (!$vendor) {
            abort(404, 'Vendor not found');
        }

        // load vendor products
        $products = Product::with(['category', 'user', 'brand', 'tags', 'variants.images', 'images'])
            ->inRandomOrder()
            ->paginate(50);;

        return Inertia::render('Welcome', [
            'vendor' => $vendor,
            'vendors' => $vendors,
            'products' => $products,
        ]);
    }


    public function viewProduct($vendorSlug, $productSlug)
    {
        $vendor = User::where('slug', $vendorSlug)->firstOrFail();

        $product = Product::with(['category', 'user', 'brand', 'tags', 'variants.images', 'images'])
            ->where('slug', $productSlug)
            ->where('user_id', $vendor->id)
            ->firstOrFail();

        return inertia::render('PublicProduct/Show', [
            'product' => $product
        ]);
    }


    public function viewCatProduct($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        $products = Product::with(['category', 'user', 'brand', 'tags', 'variants.images', 'images'])
            ->where('category_id', $category->id)
            ->inRandomOrder()
            ->paginate(20); // adjust pagination if needed

        $vendors = User::role('vendor')
            ->withCount('products')
            ->inRandomOrder()
            ->paginate(20);


        return inertia::render('Welcome', [
            'category' => $category,
            'vendors' => $vendors,
            'products' => $products,
        ]);
    }

    public function viewBrandProduct($brandSlug)
    {
        $brand = Brand::where('slug', $brandSlug)->firstOrFail();

        $products = Product::with(['category', 'user', 'brand', 'tags', 'variants.images', 'images'])
            ->where('brand_id', $brand->id)
            ->paginate(20);

        return inertia::render('Welcome', [
            'brand' => $brand,
            'products' => $products
        ]);
    }


    public function allVendors()
    {
        $vendors = User::role('vendor')
            ->withCount('products')
            ->inRandomOrder()
            ->paginate(20);

        return Inertia::render('Welcome', [
            'products' => $vendors,
            'activeTab' => 'Vendors',
        ]);
    }

    public function welcome(Request $request)
    {
        $activeTab = $request->query('tab');

        if ($activeTab === 'Vendors') {
            $vendors = User::role('vendor')
                ->withCount('products')
                ->inRandomOrder()
                ->paginate(20);
            $products = collect();
            $activeTab = 'Vendors';
        } else {
            $products = Product::with(['category', 'user', 'brand', 'tags', 'variants.images', 'images'])
                ->inRandomOrder()
                ->paginate(50);
            $vendors = collect();
            $activeTab = 'Accessories';
        }

        return Inertia::render('Welcome', [
            'products' => $products,
            'vendors' => $vendors,
            'activeTab' => $activeTab,
        ]);

    }
}
