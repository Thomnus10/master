<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Show all products
    public function index()
    {
        $products = Product::all();
        return view('admin.product', compact('products'));
    }

    // Show form to create a new product
    public function create()
    {
        // Fetch categories and units to pass them to the view
        $categories = Category::all();
        $units = Unit::all();

        // Pass categories and units to the product creation view
        return view('admin.products.products_create', compact('categories', 'units'));
    }

    // Store a new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
        ]);

        Product::create($request->all());

        return redirect()->route('admin.inventory')->with('success', 'Product added successfully.');
    }

    // Show form to edit an existing product
    public function edit(Product $product)
    {
        // Fetch categories and units to pass them to the edit form
        $categories = Category::all();
        $units = Unit::all();

        return view('admin.products.products_edit', compact('product', 'categories', 'units'));
    }

    // Update product details
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
        ]);

        $product->update($request->all());

        return redirect()->route('admin.inventory')->with('success', 'Product updated successfully.');
    }

    // Delete a product
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
