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

        $vendor_brands = Brand::where('user_id', $vendor->id)
            ->orderBy('name', 'DESC')
            ->get();

        $vendor_cats = Category::where('user_id', $vendor->id)
            ->with(['children', 'children.children'])
            ->withCount('products')
            ->orderBy('name', 'DESC')
            ->get();

        $vendors = User::role('vendor')
            ->withCount('products')
            ->inRandomOrder()
            ->paginate(20);

        if (!$vendor) {
            abort(404, 'Vendor not found');
        }

        // load vendor products
        $products = Product::with(['category', 'user', 'brand', 'tags', 'variants.images', 'images'])
            ->where('user_id', $vendor->id)
            ->inRandomOrder()
            ->paginate(52);;

        return Inertia::render('Welcome', [
            'vendor' => $vendor,
            'vendors' => $vendors,
            'products' => $products,
            'vendor_brands' => $vendor_brands,
            'vendor_cats' => $vendor_cats,

        ]);
    }


    public function viewProduct($vendorSlug, $productSlug)
    {
        $vendor = User::where('slug', $vendorSlug)->firstOrFail();

        $vendor_brands = Brand::where('user_id', $vendor->id)
            ->orderBy('name', 'DESC')
            ->get();

        $vendor_cats = Category::where('user_id', $vendor->id)
            ->with(['children', 'children.children'])
            ->withCount('products')
            ->orderBy('name', 'DESC')
            ->get();

        $product = Product::with(['category', 'user', 'brand', 'tags', 'variants.images', 'images'])
            ->where('slug', $productSlug)
            ->where('user_id', $vendor->id)
            ->firstOrFail();

        return inertia::render('PublicProduct/Show', [
            'product' => $product,
            'vendor_brands' => $vendor_brands,
            'vendor_cats' => $vendor_cats

        ]);
    }


    public function viewCatProduct($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();

        $products = Product::with(['category', 'user', 'brand', 'tags', 'variants.images', 'images'])
            ->where('category_id', $category->id)
            ->inRandomOrder()
            ->paginate(52);

        $vendor_cats = Category::orderBy('name', 'DESC')
            ->with(['children', 'children.children'])
            ->withCount('products')
            ->where('user_id', $category->user_id)
            ->get();
        $vendor_brands = Brand::orderBy('name', 'DESC')
            ->withCount('products')
            ->where('user_id', $category->user_id)
            ->get();

        $vendors = User::role('vendor')
            ->withCount('products')
            ->inRandomOrder()
            ->paginate(20);


        return inertia::render('Welcome', [
            'category' => $category,
            'vendors' => $vendors,
            'products' => $products,
            'vendor_cats' => $vendor_cats,
            'vendor_brands' => $vendor_brands,
        ]);
    }

    public function viewBrandProduct($brandSlug)
    {
        $brand = Brand::where('slug', $brandSlug)->firstOrFail();

        $products = Product::with(['category', 'user', 'brand', 'tags', 'variants.images', 'images'])
            ->where('brand_id', $brand->id)
            ->paginate(52);

        $vendor_cats = Category::orderBy('name', 'DESC')
            ->with(['children', 'children.children'])
            ->withCount('products')
            ->where('user_id', $brand->user_id)
            ->get();
        $vendor_brands = Brand::orderBy('name', 'DESC')
            ->withCount('products')
            ->where('user_id', $brand->user_id)
            ->get();

        return inertia::render('Welcome', [
            'brand' => $brand,
            'products' => $products,
                       'vendor_cats' => $vendor_cats,
            'vendor_brands' => $vendor_brands,
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
                ->paginate(52);
            $vendors = collect();
            $activeTab = 'Accessories';
        }

        $vendor_cats = Category::orderBy('name', 'DESC')
            ->with(['children', 'children.children']) // load nested children
            ->withCount('products')
            ->where('user_id', null)
            ->get();
        $vendor_brands = Brand::orderBy('name', 'DESC')
            ->withCount('products')
            ->where('user_id', null)
            ->get();

        return Inertia::render('Welcome', [
            'products' => $products,
            'vendors' => $vendors,
            'activeTab' => $activeTab,
            'vendor_cats' => $vendor_cats,
            'vendor_brands' => $vendor_brands,
        ]);

    }
}
