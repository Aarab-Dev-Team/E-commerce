<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        // Get all categories for filter sidebar
        $categories = Category::all();
        $origins    = Product::distinct()->pluck('origin')->filter()->values();
        $materials  = Product::distinct()->pluck('material')->filter()->values();

        // Price range bounds (for slider)
        $priceMin = (float) Product::where('is_active', true)->min('price') ?: 0;
        $priceMax = (float) Product::where('is_active', true)->max('price') ?: 100;

        // Active filter values
        $filterPriceMin = $request->filled('price_min') ? (float) $request->price_min : null;
        $filterPriceMax = $request->filled('price_max') ? (float) $request->price_max : null;

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
            ->when($request->filled('material'), function ($query) use ($request) {
                $query->whereIn('material', (array) $request->material);
            })
            ->when($filterPriceMin !== null, function ($query) use ($filterPriceMin) {
                $query->where('price', '>=', $filterPriceMin);
            })
            ->when($filterPriceMax !== null, function ($query) use ($filterPriceMax) {
                $query->where('price', '<=', $filterPriceMax);
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
            ->withQueryString();

        return view('shop.catalog', compact(
            'products', 'categories', 'origins', 'materials',
            'priceMin', 'priceMax', 'filterPriceMin', 'filterPriceMax'
        ));
    }
}
