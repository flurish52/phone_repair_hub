<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BrandController extends Controller
{
    public function index()
    {
        return inertia::render('Brands', [
            'vendor_brands' => Brand::where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->get(),
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $exists = Brand::where('user_id', Auth::id())
            ->where('name', $request->name)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Brand already exists'], 409);
        }

        Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Brand created successfully']);
    }

    public function update(Brand $brand, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($brand->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $exists = Brand::where('user_id', Auth::id())
            ->where('name', $request->name)
            ->where('id', '!=', $brand->id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Brand already exists'], 409);
        }

        $brand->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json(['message' => 'Brand updated successfully']);
    }

    public function destroy(Brand $brand)
    {
        if ($brand->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $brand->delete();

        return response()->json(['message' => 'Brand deleted successfully']);
    }




}
