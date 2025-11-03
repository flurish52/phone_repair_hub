<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ProductVariant;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function vendorViewProduct(User $vendor, Product $product)
    {
        // Ensure the authenticated vendor owns the product
        if (Auth::id() !== $vendor->id || $product->user_id !== $vendor->id) {
            abort(403, 'Unauthorized access');
        }

        // Fetch full product details
        $product = Product::with(['category', 'user', 'brand', 'tags', 'variants.images', 'images'])
            ->where('id', $product->id)
            ->where('user_id', $vendor->id)
            ->firstOrFail();

        // Decode variant attributes
        $product->variants->each(function ($variant) {
            $variant->attributes = json_decode($variant->attributes, true) ?? [];
        });

        // Return single product object, not array
        return inertia('Product/View', [
            'product' => $product
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia::render('Product/Create', [

    ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // 1. Generate slug and SKU
        $slug = Str::slug($request->name);
        $brand = Brand::find($request->brand_id)?->name ?? 'BRD';
        $category = Category::find($request->category_id)?->name ?? 'CAT';

        $skuBase = strtoupper(
            substr($brand, 0, 3) . '-' .
            substr($category, 0, 3) . '-' .
            Str::slug($request->name, '-')
        );

        $sku = $skuBase . '-' . rand(1000, 9999);

        DB::beginTransaction();
        // 2. Create product
        $product = Product::create([
            'name' => $request->name,
            'user_id' => Auth::id(),
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
        ]);

        $this->handleTags($product, $request->tags ?? []);

        $createdImages = [];
        foreach ($request->product_images as $imgData) {
            $filePath = $imgData['file']->store('products', 'public');
            $image = $product->images()->create([
                'image_path' => $filePath,
                'is_primary' => $imgData['primary'] ?? false,
                'position' => $imgData['position'] ?? 0,
            ]);
            $createdImages[] = $image;
        }

        $createdVariants = [];
        foreach ($request->variants as $variantData) {
            $variantSku = $sku . '-' . Str::slug($variantData['name'], '-');
            $variant = $product->variants()->create([
                'name' => $variantData['name'],
                'sku' => $variantSku,
                'engineer_price' => $variantData['engineer_price'],
                'regular_price' => $variantData['regular_price'],
                'stock' => $variantData['stock'],
                'status' => $variantData['status'],
                'attributes' => json_encode($variantData['attributes'] ?? []),
            ]);

            $variantImages = [];
            foreach ($variantData['images'] as $vImg) {
                $filePath = $vImg['file']->store('variants', 'public');
                $variantImages[] = $variant->images()->create([
                    'image_path' => $filePath,
                    'is_primary' => $vImg['primary'] ?? false,
                    'position' => $vImg['position'] ?? 0,
                ]);
            }

            $createdVariants[] = [
                'variant' => $variant,
                'images' => $variantImages,
            ];
        }
        DB::commit();

        // Return full data so you can debug in dev tools
        return response()->json([
            'product' => $product,
            'product_images' => $createdImages,
            'variants' => $createdVariants,
            'sku_base' => $skuBase,
            'sku_generated' => $sku,
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        if (Auth::id() !== $product->user_id)
        {
            return response(['message' => 'Unauthorized'], 403);
        }
        $product->load('variants.images', 'images', 'tags');
        $product->variants->each(function ($variant) {
            $variant->attributes = json_decode($variant->attributes, true) ?? [];
        });
        return Inertia::render('Product/Create', [
            'editingProduct' => $product
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        DB::beginTransaction();

        $data = $request->validated();

        $slug = $this->generateSlug($data['name']);
        $sku = $this->generateSku($data['name'], $data['brand_id'], $data['category_id']);

        $product->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? $product->description,
            'brand_id' => $data['brand_id'],
            'category_id' => $data['category_id'],
        ]);

        // Handle tags
        $this->handleTags($product, $data['tags'] ?? []);

        // Handle images
        $this->handleProductImages($product, $data['product_images'] ?? [], $data['product_deleted_images'] ?? []);

        // Handle variants
        foreach ($data['variants'] as $variantData) {
            $variant = $product->variants()->updateOrCreate(
                ['id' => $variantData['id'] ?? null],
                [
                    'name' => $variantData['name'],
                    'sku' => $sku . '-' . Str::slug($variantData['name'], '-'),
                    'engineer_price' => $variantData['engineer_price'],
                    'regular_price' => $variantData['regular_price'],
                    'stock' => $variantData['stock'],
                    'status' => $variantData['status'],
                ]
            );

            $this->handleVariantAttributes($variant, $variantData['attributes'] ?? []);
            $this->handleVariantImages($variant, $variantData['images'] ?? [], $variantData['deleted_images'] ?? []);
        }

        DB::commit();

        return response()->json(['message' => 'Product updated successfully']);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (auth()->id() !== $product->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        foreach ($product->images as $image) {
            if ($image->image_path && Storage::exists($image->image_path)) {
                Storage::delete($image->image_path);
            }
            $image->delete();
        }

        foreach ($product->variants as $variant) {
            foreach ($variant->images as $variantImage) {
                if ($variantImage->image_path && Storage::exists($variantImage->image_path)) {
                    Storage::delete($variantImage->image_path);
                }
                $variantImage->delete();
            }
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }



    private function handleProductImages(Product $product, array $images = [], array $deleted = [])
    {
        if (!empty($deleted)) {
            Image::whereIn('id', $deleted)->delete();
        }

        foreach ($images as $imageData) {
            if (isset($imageData['file'])) {
                $path = $imageData['file']->store('products', 'public');
                $product->images()->create([
                    'product_variant_id' => null,
                    'image_path' => $path,
                    'position' => $imageData['position'] ?? 0,
                    'is_primary' => $imageData['primary'] ?? false,
                ]);
            } elseif (isset($imageData['id'])) {
                Image::where('id', $imageData['id'])->update([
                    'position' => $imageData['position'] ?? 0,
                    'is_primary' => $imageData['primary'] ?? false,
                ]);
            }
        }
    }
    private function handleVariantImages(ProductVariant $variant, array $images = [], array $deleted = [])
    {
        if (!empty($deleted)) {
            Image::whereIn('id', $deleted)->delete();
        }


        foreach ($images as $imageData) {
            if (isset($imageData['file'])) {
                $path = $imageData['file']->store('variants', 'public');
                $variant->images()->create([
                    'product_id' => null,
                    'image_path' => $path,
                    'position' => $imageData['position'] ?? 0,
                    'is_primary' => $imageData['primary'] ?? false,
                ]);
            } elseif (isset($imageData['id'])) {
                Image::where('id', $imageData['id'])->update([
                    'position' => $imageData['position'] ?? 0,
                    'is_primary' => $imageData['primary'] ?? false,
                ]);
            }
        }
    }


    private function generateSlug(string $name): string
    {
        return Str::slug($name);
    }

    private function generateSku(string $productName, int $brandId, int $categoryId): string
    {
        $brand = Brand::find($brandId)?->name ?? 'BRD';
        $category = Category::find($categoryId)?->name ?? 'CAT';

        $skuBase = strtoupper(
            substr($brand, 0, 3) . '-' .
            substr($category, 0, 3) . '-' .
            Str::slug($productName, '-')
        );

        return $skuBase . '-' . rand(1000, 9999);
    }
    private function handleTags(Product $product, array $tags)
    {
        $tagIds = [];

        foreach ($tags as $tag) {
            if (is_string($tag)) {
                $existingTag = Tag::where('name', $tag)->first();
                if ($existingTag) {
                    $tagIds[] = $existingTag->id;
                }
            } elseif (is_numeric($tag)) {
                $tagIds[] = $tag;
            }
        }

        $product->tags()->sync($tagIds);
    }


    private function handleVariantAttributes(ProductVariant $variant, array $attributes)
    {
        // Assuming attributes stored as JSON inside the variant
        $variant->update([
            'attributes' => json_encode($attributes),
        ]);
    }


}
