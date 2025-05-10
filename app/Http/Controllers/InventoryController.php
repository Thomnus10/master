<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductRequest;

class InventoryController extends Controller
{
    // Display a listing of inventories
    public function index()
    {
        // Eager load the related product information to avoid N+1 query problem
        $inventories = Inventory::with('product')->get();
        
        return view('admin.inventory', compact('inventories'));
    }

    // Show the form for creating a new inventory
    public function create()
    {
        // Get all products for selection
        $products = Product::all();
        
        return view('admin.inventories.inventories_create', compact('products'));
    }

    // Store a newly created inventory
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'product_id' => 'required|exists:products,id', // Ensure product exists
            'quantity' => 'required|numeric|min:0', // Validate quantity is a positive number
            'expiration_date' => 'required|date|after_or_equal:today', // Ensure valid expiration date
        ]);

        // Create the new inventory record
        Inventory::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'expiration_date' => $request->expiration_date,
        ]);

        // Redirect with success message
        return redirect()->route('admin.inventory')->with('success', 'Inventory added successfully.');
    }

    // Show the form for editing the specified inventory
    public function edit(Inventory $inventory)
    {
        // Get all products for selection (same as create)
        $products = Product::all();
        
        return view('admin.inventories.inventories_edit', compact('inventory', 'products'));
    }

    // Update the specified inventory
    public function update(Request $request, Inventory $inventory)
    {
        // Validate the incoming request data
        $request->validate([
            'product_id' => 'required|exists:products,id', // Ensure product exists
            'quantity' => 'required|numeric|min:0', // Validate quantity is a positive number
            'expiration_date' => 'required|date|after_or_equal:today', // Ensure valid expiration date
        ]);

        // Update the inventory with validated data
        $inventory->update([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'expiration_date' => $request->expiration_date,
        ]);

        // Redirect with success message
        return redirect()->route('admin.inventory')->with('success', 'Inventory updated successfully.');
    }

    public function receiveProduct($id)
{
    $request = ProductRequest::findOrFail($id);

    if ($request->status === 'received') {
        return back()->with('info', 'Product already received.');
    }

    // Add to inventory
    Inventory::create([
        'product_id' => $request->product_id,
        'quantity' => $request->quantity,
        'expiration_date' => now()->addMonths(6), // or use a field if needed
    ]);

    // Update request status
    $request->update(['status' => 'received']);

    return back()->with('success', 'Product received and added to inventory.');
}

}
