<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Employee;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('employee')->latest()->get();
        return view('cashier.home', compact('orders'));
    }

    public function create()
    {
        $employees = Employee::all();
        return view('cashier.home', compact('employees'));
    }

    public function store(Request $request)
    {
        $order = Order::create([
            'employee_id' => $request->employee_id,
            'total_amount' => $request->total_amount,
            'order_date' => $request->order_date,
            'status' => $request->status,
        ]);
        
        // Example format of $request->products:
        // [
        //   ['product_id' => 1, 'quantity' => 2, 'price' => 100.00],
        //   ['product_id' => 3, 'quantity' => 1, 'price' => 50.00],
        // ]
        
        foreach ($request->products as $product) {
            $order->products()->attach($product['product_id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }
        

        Order::create($request->all());

        return redirect()->route('cashier.home')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        return view('cashier.home', compact('order'));
    }

    public function edit(Order $order)
    {
        $employees = Employee::all();
        return view('cashier.home', compact('order', 'employees'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'total_amount' => 'required|numeric|min:0',
            'order_date' => 'required|date',
            'status' => 'required|in:completed,voided,refunded',
        ]);

        $order->update($request->all());

        return redirect()->route('cashier.home')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('cashier.home')->with('success', 'Order deleted successfully.');
    }
}
