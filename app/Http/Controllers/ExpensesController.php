<?php

namespace App\Http\Controllers;

use App\Models\Expense; // Ensure you have an Expense model
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    // Display a listing of the expenses
    public function index()
    {
        return view('admin.expenses'); // Adjust if your view is located elsewhere
    }

    // Show the expense creation form
    public function create()
    {
        return view('admin.expenses.create');
    }

    // Store a newly created expense in storage
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id', // Assuming you have a categories table
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
            // Add other validation rules as needed
        ]);

        Expense::create([
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('admin.expenses.list')->with('success', 'Expense added successfully!');
    }

    // Show the form for editing the specified expense
    public function edit(Expense $expense)
    {
        return view('admin.expenses.edit', compact('expense'));
    }

    // Update the specified expense in storage
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        $expense->update([
            'category_id' => $request->category_id,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('admin.expenses.list')->with('success', 'Expense updated successfully!');
    }

    // Remove the specified expense from storage
    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('admin.expenses.list')->with('success', 'Expense deleted successfully!');
    }
}