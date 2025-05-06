<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Employee;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $orders = Order::with('employee')->latest()->get();
        return view('cashier.index', compact('orders','products'));
    }

    public function create()
    {
        $employees = Employee::all();
        $products = Product::all();
        return view('cashier.create', compact('employees', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'order_date' => 'required|date',
            'status' => 'required|in:completed,voided,refunded',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        // Calculate total amount
        $total = collect($request->products)->sum(function ($item) {
            return $item['quantity'] * $item['price'];
        });

        // Create the order
        $order = Order::create([
            'employee_id' => $request->employee_id,
            'total_amount' => $total,
            'order_date' => $request->order_date,
            'status' => $request->status,
        ]);

        // Attach products to the order with quantity and price
        foreach ($request->products as $product) {
            $order->products()->attach($product['product_id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }

        return redirect()->route('cashier.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load('products', 'employee');
        return view('cashier.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $employees = Employee::all();
        return view('cashier.edit', compact('order', 'employees'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'total_amount' => 'required|numeric|min:0',
            'order_date' => 'required|date',
            'status' => 'required|in:completed,voided,refunded',
        ]);

        $order->update($request->only(['employee_id', 'total_amount', 'order_date', 'status']));

        return redirect()->route('cashier.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('cashier.index')->with('success', 'Order deleted successfully.');
    }
}
