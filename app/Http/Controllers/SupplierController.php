<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Display a listing of the suppliers
    public function index()
    {
        $suppliers = Supplier::all();
        return view('admin.suppliers', compact('suppliers'));
    }

    // Show the supplier creation form
    public function create()
    {
        return view('admin.suppliers.suppliers_create');
    }

    // Store a newly created supplier in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email',
            'phone' => 'required|string|max:15',
        ]);

        Supplier::create([
            'name' => $request->name,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.suppliers')->with('success', 'Supplier added successfully!');
    }

    // Show the form for editing the specified supplier
    public function edit(Supplier $supplier)
    {
        return view('admin.suppliers.suppliers_edit', compact('supplier'));
    }

    // Update the specified supplier in storage
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:suppliers,email,' . $supplier->id,
            'phone' => 'required|string|max:15',
        ]);

        $supplier->update($request->only('name', 'contact_person', 'email', 'phone'));

        return redirect()->route('admin.suppliers')->with('success', 'Supplier updated successfully!');
    }

    // Remove the specified supplier from storage
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('admin.suppliers')->with('success', 'Supplier deleted successfully!');
    }
}
