<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    protected $fillable = ['name', 'slug', 'parent_id'];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // A category may have many children
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
