<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Display a listing of suppliers
    public function index()
    {
        $suppliers = Supplier::all(); // Retrieve all suppliers
        return view('admin.supplier', compact('suppliers')); // Pass to view
        
    }

    // Show the form for creating a new supplier
    public function create()
    {
        return view('admin.suppliers.suppliers_create');
    }

    // Store a newly created supplier in the database
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|numeric',
        ]);

        // Create a new supplier
        Supplier::create([
            'name' => $request->name,
            'contact' => $request->contact,
        ]);

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    // Display the specified supplier
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.suppliers.suppliers_show', compact('supplier'));
    }

    // Show the form for editing the specified supplier
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.suppliers.suppliers_edit', compact('supplier'));
    }

    // Update the specified supplier in the database
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|numeric',
        ]);

        // Find the supplier and update
        $supplier = Supplier::findOrFail($id);
        $supplier->update([
            'name' => $request->name,
            'contact' => $request->contact,
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Supplier updated successfully.');
    }

    // Remove the specified supplier from the database
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('admin.inventory')->with('success', 'Supplier deleted successfully.');
    }
}
