<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Display a list of categories
    public function index()
    {
        $categories = Category::all();
        return view('admin.category', compact('categories'));
    }

    // Show the form to create a new category
    public function create()
    {
        return view('admin.categories.categories_create');
    }

    // Store a new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Category created successfully.');
    }

    // Show the form to edit an existing category
    public function edit(Category $category)
    {
        return view('admin.categories.categories_edit', compact('category'));
    }

    // Update an existing category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id . '|max:255',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Category updated successfully.');
    }

    // Delete a category
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.inventory')->with('success', 'Category deleted successfully.');
    }
}
