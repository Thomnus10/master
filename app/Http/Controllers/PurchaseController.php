<?php

namespace App\Http\Controllers;

use App\Models\Purchase; // Ensure you have a Purchase model
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
{
    return view('admin.purchase'); // Adjust if your view is located elsewhere
}
    

    // Show the purchase creation form
    public function create()
    {
        return view('admin.purchase.create');
    }

    // Store a newly created purchase in storage
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id', // Assuming you have a suppliers table
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            // Add other validation rules as needed
        ]);

        // Calculate total pay after discount
        $totalPay = $request->total_price - ($request->total_price * ($request->discount / 100));

        Purchase::create([
            'supplier_id' => $request->supplier_id,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
            'discount' => $request->discount ?? 0,
            'total_pay' => $totalPay,
        ]);

        return redirect()->route('admin.purchase.list')->with('success', 'Purchase added successfully!');
    }

    // Show the form for editing the specified purchase
    public function edit(Purchase $purchase)
    {
        return view('admin.purchase.edit', compact('purchase'));
    }

    // Update the specified purchase in storage
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
        ]);

        // Calculate total pay after discount
        $totalPay = $request->total_price - ($request->total_price * ($request->discount / 100));

        $purchase->update([
            'supplier_id' => $request->supplier_id,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
            'discount' => $request->discount ?? 0,
            'total_pay' => $totalPay,
        ]);

        return redirect()->route('admin.purchase.list')->with('success', 'Purchase updated successfully!');
    }

    // Remove the specified purchase from storage
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('admin.purchase.list')->with('success', 'Purchase deleted successfully!');
    }
}