<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ApprovalController extends Controller
{
    /**
     * Both admins and employees can view the queue.
     * Employees see all pending items (including their own).
     */
    public function index(Request $request)
    {
        $query = Product::where('pending_status', '!=', 'approved')
            ->with('category');

        // Filter by request type
        if ($request->filled('type')) {
            $query->where('pending_status', 'pending_' . $request->type);
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        // Pending counts for the badge
        $pendingCount = Product::where('pending_status', '!=', 'approved')->count();

        return view('admin.approvals.index', compact('products', 'pendingCount'));
    }

    /**
     * Show diff data for a pending update — admin only.
     */
    public function show(Product $product)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return response()->json([
            'product'      => $product,
            'pending_data' => $product->pending_data,
            'original_data' => $product->original_data,
        ]);
    }

    /**
     * Approve a pending product action — admin only.
     */
    public function approve(Product $product)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        switch ($product->pending_status) {
            case 'pending_creation':
                $product->update(['is_active' => true, 'pending_status' => 'approved']);
                $message = 'Product approved and is now live.';
                break;

            case 'pending_update':
                $pendingData = $product->pending_data;
                if ($pendingData) {
                    $product->update($pendingData);
                }
                $product->update([
                    'pending_status' => 'approved',
                    'pending_data'   => null,
                    'original_data'  => null,
                ]);
                $message = 'Product update approved and applied.';
                break;

            case 'pending_deletion':
                $productName = $product->name;
                $product->delete();
                return redirect()->route('admin.approvals.index')->with('alert', [
                    'type'    => 'success',
                    'message' => '"' . $productName . '" has been permanently deleted.',
                ]);
        }

        return redirect()->route('admin.approvals.index')->with('alert', [
            'type'    => 'success',
            'message' => $message ?? 'Approved.',
        ]);
    }

    /**
     * Reject a pending product action — admin only.
     */
    public function reject(Product $product)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        switch ($product->pending_status) {
            case 'pending_creation':
                $product->delete();
                return redirect()->route('admin.approvals.index')->with('alert', [
                    'type'    => 'success',
                    'message' => 'Product creation rejected and removed.',
                ]);

            case 'pending_update':
                if ($product->original_data) {
                    $product->update($product->original_data);
                }
                $product->update([
                    'pending_status' => 'approved',
                    'pending_data'   => null,
                    'original_data'  => null,
                ]);
                $message = 'Update rejected. Original data restored.';
                break;

            case 'pending_deletion':
                $product->update([
                    'is_active'      => true,
                    'pending_status' => 'approved',
                ]);
                $message = 'Deletion rejected. Product reactivated.';
                break;

            default:
                $message = 'Request rejected.';
        }

        return redirect()->route('admin.approvals.index')->with('alert', [
            'type'    => 'success',
            'message' => $message,
        ]);
    }
}
