<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display a listing of the products
    public function index()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }
    // Show the product creation form
    public function create()
    {
        return view('admin.products.products_create');
    }

    // Store a newly created product in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'stock' => $request->stock,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.products')->with('success', 'Product added successfully!');
    }

    // Show the form for editing the specified product
    public function edit(Product $product)
    {
        return view('admin.products.products_edit', compact('product'));
    }

    // Update the specified product in storage
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $product->update($request->only('name', 'category', 'stock', 'price'));

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    // Remove the specified product from storage
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }
}