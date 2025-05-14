<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::latest()->get();
        return view('admin.discounts.discounts_index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.discounts.discounts_form');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|in:fixed,percentage',
        'value' => 'required|numeric|min:0',
        'is_active' => 'nullable|boolean',
    ]);

    $validated['is_active'] = $request->input('is_active', 0);
 

    Discount::create($validated);

    return redirect()->route('discounts.index')
        ->with('success', 'Discount created successfully');
}


    public function edit(Discount $discount)
    {
        return view('admin.discounts.discounts_form', compact('discount'));
    }

    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);
        $validated['is_active'] = $request->input('is_active', 0);


        $discount->update($validated);

        return redirect()->route('discounts.index')
            ->with('success', 'Discount updated successfully');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('discounts.index')
            ->with('success', 'Discount deleted successfully');
    }

    public function toggleStatus(Discount $discount)
{
    $discount->update(['is_active' => !$discount->is_active]);
    return back()->with('success', 'Discount status updated');
}
}