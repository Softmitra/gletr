<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\SellerProductServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private SellerProductServiceInterface $productService
    ) {}

    /**
     * Display product listing
     */
    public function index(Request $request): View
    {
        $sellerId = Auth::guard('seller')->id();
        $filters = $request->only(['status', 'category', 'search', 'sort']);
        $perPage = $request->get('per_page', 15);

        $data = $this->productService->getProductListing($sellerId, $filters, $perPage);

        return view('seller.products.index', $data);
    }

    /**
     * Show product creation form
     */
    public function create(): View
    {
        return view('seller.products.create', [
            'categories' => [], // TODO: Load categories when available
            'product' => null,
        ]);
    }

    /**
     * Store new product
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            
            $result = $this->productService->createProduct($sellerId, $request->all());

            return redirect()->route('seller.products.index')
                ->with('success', $result['message']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Show product details
     */
    public function show(int $productId)
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            $data = $this->productService->getProductForEdit($sellerId, $productId);

            return view('seller.products.show', $data);
        } catch (\Exception $e) {
            return redirect()->route('seller.products.index')
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show product edit form
     */
    public function edit(int $productId)
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            $data = $this->productService->getProductForEdit($sellerId, $productId);

            return view('seller.products.edit', $data);
        } catch (\Exception $e) {
            return redirect()->route('seller.products.index')
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Update product
     */
    public function update(Request $request, int $productId): RedirectResponse
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            
            $this->productService->updateProduct($sellerId, $productId, $request->all());

            return redirect()->route('seller.products.show', $productId)
                ->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Delete product
     */
    public function destroy(int $productId): RedirectResponse
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            
            $this->productService->deleteProduct($sellerId, $productId);

            return redirect()->route('seller.products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Toggle product status
     */
    public function toggleStatus(int $productId): RedirectResponse
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            
            $this->productService->toggleProductStatus($sellerId, $productId);

            return back()->with('success', 'Product status updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Handle bulk actions
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'product_ids' => 'required|array|min:1',
            'product_ids.*' => 'integer',
        ]);

        try {
            $sellerId = Auth::guard('seller')->id();
            
            $result = $this->productService->bulkAction(
                $sellerId,
                $request->action,
                $request->product_ids
            );

            return back()->with('success', $result['message']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show import form
     */
    public function importForm(): View
    {
        $template = $this->productService->getImportTemplate();

        return view('seller.products.import', compact('template'));
    }

    /**
     * Import products
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'import_file' => 'required|file|mimes:csv,xlsx,xls|max:10240', // 10MB max
        ]);

        try {
            $sellerId = Auth::guard('seller')->id();
            
            $result = $this->productService->importProducts($sellerId, $request->file('import_file'));

            if ($result['success'] > 0) {
                return redirect()->route('seller.products.index')
                    ->with('success', $result['message']);
            } else {
                return back()->withErrors(['error' => $result['message']]);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Export products
     */
    public function export(Request $request)
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            $filters = $request->only(['status', 'category', 'search']);
            
            $result = $this->productService->exportProducts($sellerId, $filters);

            if ($result['file_path']) {
                return response()->download($result['file_path']);
            } else {
                return back()->with('info', $result['message']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Get product performance data (AJAX)
     */
    public function getPerformance(Request $request)
    {
        try {
            $sellerId = Auth::guard('seller')->id();
            $stats = $this->productService->getProductStatistics($sellerId);

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
