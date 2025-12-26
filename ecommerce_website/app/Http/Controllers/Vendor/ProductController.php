<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:vendor');
    }

    public function index()
    {
        $products = Auth::user()->products()
            ->with('category')
            ->latest()
            ->paginate(15);

        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('vendor.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ]);

        $product = auth()->user()->products()->create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . time(),
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ]);

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
            $product->update(['images' => $images]);
        }

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product created successfully. It will be reviewed by admin.');
    }

    public function show(Product $product)
    {
        if ($product->vendor_id !== auth()->id()) {
            abort(403);
        }

        return view('vendor.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        if ($product->vendor_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::where('is_active', true)->get();
        return view('vendor.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->vendor_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'is_approved' => false, // Re-approve after edit
        ]);

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->vendor_id !== auth()->id()) {
            abort(403);
        }

        $product->delete();

        return redirect()->route('vendor.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}