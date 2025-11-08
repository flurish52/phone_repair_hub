<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{


    public function index(Request $request)
    {
        $query = $request->query('q');

        $results = Product::where('name', 'like', "%{$query}%")
            ->with('user')
            ->limit(10)
            ->get();

        return response()->json($results);
    }




}
