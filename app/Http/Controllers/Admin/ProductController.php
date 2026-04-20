<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product ; 
use App\Models\Category ;

class ProductController extends Controller
{
        
       
        /**
         * Display a listing of the products.
         */
        public function index(Request $request)
        {
                $query = Product::with('category');

                // Search by name
                if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
                }

                // Filter by category
                if ($request->filled('category')) {
                $query->where('category_id', $request->category);
                }

                $products = $query->latest()->paginate(10)->withQueryString();
                $categories = Category::all();

                return view('admin.products.index', compact('products', 'categories'));
        }

        /**
         * Store a newly created product.
         */
        public function store(Request $request)
        {
                $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:products,slug',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'origin' => 'nullable|string|max:100',
                'material' => 'nullable|string|max:100',
                'color' => 'nullable|string|max:100',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'boolean',
                ]);

                // Generate slug if not provided
                if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['name']);
                }

                // Handle image uploads
                $imagePaths = [];
                if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                        $path = $image->store('products', 'public');
                        $imagePaths[] = $path;
                }
                }
                $validated['images'] = $imagePaths;
                $validated['is_active'] = $request->boolean('is_active');

                Product::create($validated);

                return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
        }

        /**
         * Update the specified product.
         */
        public function update(Request $request, Product $product)
        {
                $validated = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|unique:products,slug,' . $product->id,
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'origin' => 'nullable|string|max:100',
                'material' => 'nullable|string|max:100',
                'color' => 'nullable|string|max:100',
                'images' => 'nullable|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_active' => 'boolean',
                ]);

                // Generate slug if not provided
                if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['name']);
                }

                // Handle image uploads (append to existing)
                $imagePaths = $product->images ?? [];
                if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                        $path = $image->store('products', 'public');
                        $imagePaths[] = $path;
                }
                }
                $validated['images'] = $imagePaths;
                $validated['is_active'] = $request->boolean('is_active');

                $product->update($validated);

                return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
        }

        /**
         * Remove the specified product.
         */
        public function destroy(Product $product)
        {
                $product->delete();
                return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
        }
}
