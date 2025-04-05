<?php

namespace App\Http\Controllers;

use App\Models\Purchase; // Assuming you have a Purchase model
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function products()
    {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    public function purchase()
    {
        // Fetch all purchases from the database
        $purchases = Purchase::all(); // Make sure you have a Purchase model

        // Pass the purchases to the view
        return view('admin.purchase.index', compact('purchases'));
    }
}
