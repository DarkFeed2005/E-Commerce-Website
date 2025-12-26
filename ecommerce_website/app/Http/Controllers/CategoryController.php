<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->where('is_active', true);
            }])
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        $products = $category->products()
            ->where('is_active', true)
            ->where('is_approved', true)
            ->with('vendor')
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }
}