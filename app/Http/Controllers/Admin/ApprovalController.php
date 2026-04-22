<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product ; 


class ApprovalController extends Controller
{
      public function index(Request $request)
    {
        $query = Product::where('pending_status', '!=', 'approved')
            ->with('category');

        // فلترة حسب النوع
        if ($request->filled('type')) {
            $query->where('pending_status', 'pending_' . $request->type);
        }

        $products = $query->latest()->paginate(10);

        return view('admin.approvals.index', compact('products'));
    }

    public function approve(Product $product)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        switch ($product->pending_status) {
            case 'pending_creation':
                $product->update(['is_active' => true, 'pending_status' => 'approved']);
                break;
            case 'pending_update':
                $product->update($product->pending_data);
                $product->update(['pending_status' => 'approved', 'pending_data' => null, 'original_data' => null]);
                break;
            case 'pending_deletion':
                $product->delete();
                break;
        }

        return back()->with('success', 'Product approved.');
    }

    public function reject(Product $product)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        if ($product->pending_status === 'pending_update' && $product->original_data) {
            $product->update($product->original_data);
        }
        if ($product->pending_status === 'pending_deletion') {
            $product->update(['is_active' => true]);
        }
        if ($product->pending_status === 'pending_creation') {
            $product->delete();
            return back()->with('success', 'Product creation rejected.');
        }

        $product->update(['pending_status' => 'approved', 'pending_data' => null, 'original_data' => null]);

        return back()->with('success', 'Changes rejected.');
    }

    public function show(Product $product)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        return response()->json([
            'product' => $product,
            'pending_data' => $product->pending_data,
            'original_data' => $product->original_data,
        ]);
    }
}
