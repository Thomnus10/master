<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\ProductRequest;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductRequestController extends Controller
{
    // Show all product requests
    public function index(Request $request)
    {
        $status = $request->query('status');

        $query = ProductRequest::with(['product', 'supplier']);

        if ($status) {
            $query->where('status', $status);
        }

        $requests = $query->orderBy('created_at', 'desc')->get();

        return view('admin.requests.index', compact('requests', 'status'));
    }


    // Show form to create a new request
    public function create()
    {
        $products = Product::with(['category', 'unit'])->get();
        $suppliers = Supplier::all();

        // Total inventory quantity per product
        $inventoryQuantities = Inventory::selectRaw('product_id, SUM(quantity) as total')
            ->groupBy('product_id')
            ->pluck('total', 'product_id');

        return view('admin.requests.create', compact('products', 'suppliers', 'inventoryQuantities'));
    }

    // Store a new product request
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|numeric|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        ProductRequest::create([
            'product_id' => $request->product_id,
            'supplier_id' => $request->supplier_id,
            'quantity' => $request->quantity,
            'price' => $request->price, // Store the discounted price
            'status' => 'pending',
        ]);

        return redirect()->route('requests.index')->with('success', 'Product request sent.');
    }

    // Mark a request as received and add to inventory
    public function receive(Request $request, $id)
    {
        $request->validate([
            'expiration_date' => 'required|date|after_or_equal:today',
        ]);

        $productRequest = ProductRequest::findOrFail($id);

        if ($productRequest->status === 'received') {
            return redirect()->route('requests.index')->with('success', 'Already received.');
        }

        DB::beginTransaction();

        try {
            // Add to inventory
            Inventory::create([
                'product_id' => $productRequest->product_id,
                'quantity' => $productRequest->quantity,
                'expiration_date' => $request->expiration_date,
                'unit_price' => $productRequest->price, // Store the discounted price
            ]);

            // Update the product-supplier relationship
            $product = $productRequest->product;
            $supplier = $productRequest->supplier;

            $existingRelation = $product->suppliers()->where('supplier_id', $supplier->id)->first();

            if ($existingRelation) {
                $product->suppliers()->updateExistingPivot($supplier->id, [
                    'quantity' => $existingRelation->pivot->quantity + $productRequest->quantity,
                    'price' => $productRequest->price // Update with the discounted price
                ]);
            } else {
                $product->suppliers()->attach($supplier->id, [
                    'quantity' => $productRequest->quantity,
                    'price' => $productRequest->price
                ]);
            }

            $productRequest->update(['status' => 'received']);

            DB::commit();

            return redirect()->route('requests.index')->with('success', 'Marked as received and added to inventory.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('requests.index')->with('error', 'Failed to process the request: ' . $e->getMessage());
        }
    }
}
