<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product ; 
use App\Models\Category ;
use Illuminate\Support\Str;


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

                $productData = [
                        'name' => $validated['name'],
                        'slug' => $validated['slug'] ?? Str::slug($validated['name']),
                        'description' => $validated['description'],
                        'price' => $validated['price'],
                        'stock_quantity' => $validated['stock_quantity'],
                        'category_id' => $validated['category_id'],
                        'origin' => $validated['origin'] ?? null,
                        'material' => $validated['material'] ?? null,
                        'color' => $validated['color'] ?? null,
                        'images' => $imagePaths,
                ];

                  if (auth()->user()->role === 'employee') {
                        $productData['is_active'] = false;
                        $productData['pending_status'] = 'pending_creation';
                        $message = 'Product submitted for approval.';
                } else {
                        $productData['is_active'] = $request->boolean('is_active', false);
                        $productData['pending_status'] = 'approved';
                        $message = 'Product created successfully.';
                }

            

         
                Product::create($productData);


                return redirect()->route('admin.products.index')->with('alert', [
                        "type" => "success"  , 
                        "message" => $message , 
                ]);

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

                $updateData = [
                        'name' => $validated['name'],
                        'slug' => $validated['slug'] ?? Str::slug($validated['name']),
                        'description' => $validated['description'],
                        'price' => $validated['price'],
                        'stock_quantity' => $validated['stock_quantity'],
                        'category_id' => $validated['category_id'],
                        'origin' => $validated['origin'] ?? null,
                        'material' => $validated['material'] ?? null,
                        'color' => $validated['color'] ?? null,
                        'images' => $imagePaths,
                ];
                
                //only admin can toggle is_active value : 
                 if (auth()->user()->role === 'employee') {
                        //employee
                        $product->update([
                        'pending_status' => 'pending_update',
                        'pending_data' => $updateData,
                        'original_data' => $product->only(array_keys($updateData)),
                        ]);
                        $message = 'Product update submitted for approval.';
                } else {
                        //admin
                        $updateData['is_active'] = $request->boolean('is_active');
                        $product->update($updateData);
                        $product->update([
                        'pending_status' => 'approved',
                        'pending_data' => null,
                        'original_data' => null,
                        ]);
                        $message = 'Product updated successfully.';
                }


                return redirect()->route('admin.products.index')->with('alert',[
                        "type"=>"success" , "message"=>  $message   
                ]);
        }

        /**
         * Remove the specified product.
         */
        public function destroy(Product $product)
        {
                if (auth()->user()->role === 'employee') {
                        $product->update([
                        'is_active' => false,
                        'pending_status' => 'pending_deletion',
                        ]);
                        $message = 'Product deletion submitted for approval.';
                } else {
                        $product->delete();
                        $message = 'Product deleted permanently.';
                }

                return redirect()->route('admin.products.index')->with('alert',[
                        "type"=>"success" , "message"=>  $message   
                ]);
        }




}
