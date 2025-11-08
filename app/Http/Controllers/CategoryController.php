<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CategoryController extends Controller
{

    public function index()
    {
        return Inertia::render('Category', [
            'vendor_cats' => Category::where('user_id', Auth::id())
                ->with(['children', 'children.children']) // load nested children
                ->withCount('products')
                ->orderBy('created_at', 'DESC')
                ->get(),
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $exists = Category::where('user_id', Auth::id())
            ->where('name', $request->name)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Category already exists'], 409);
        }

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Category created successfully']);
    }


    public function update(Category $category, Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $exists = Category::where('user_id', Auth::id())
            ->where('name', $request->name)
            ->where('id', '!=', $category->id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Category already exists'], 409);
        }

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
        ]);

        return response()->json(['message' => 'Category updated successfully']);
    }



    public function destroy(Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }

}
