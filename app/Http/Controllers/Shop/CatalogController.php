<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category ; 
use App\Models\Product ; 

class CatalogController extends Controller
{
     public function index(Request $request)
    {
        // Get all categories for filter sidebar
        $categories = Category::all();
        $origins = Product::distinct()->pluck('origin')->filter()->values();
        $materials  = Product::distinct()->pluck('material')->filter()->values() ; 


        // Query products with filters
        $products = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereIn('category_id', (array) $request->category);
            })
            ->when($request->filled('origin'), function ($query) use ($request) {
                $query->whereIn('origin', (array) $request->origin);
            })
            ->when($request->filled('material') , function($query) use ($request){
                $query->whereIn('material' , (array) $request->material) ; 
            })
            ->when($request->filled('sort'), function ($query) use ($request) {
                match ($request->sort) {
                    'price_asc'  => $query->orderBy('price', 'asc'),
                    'price_desc' => $query->orderBy('price', 'desc'),
                    'newest'     => $query->latest(),
                    default      => $query->latest(),
                };
            }, function ($query) {
                $query->latest();
            })
            ->paginate(9)
            ->withQueryString(); // Keep filter parameters in pagination links


        return view('shop.catalog', compact('products', 'categories' , "origins" , "materials"));
    }
}
