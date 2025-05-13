<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
{
    $products = Product::all();
    $orders = Order::with(['employee', 'payment'])->latest()->get();
    return view('cashier.orders.index', compact('orders', 'products'));
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
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'payment_method' => 'nullable|string|in:cash,card,mobile',
        ]);

        // Calculate totals
        $subtotal = collect($request->products)->sum(function ($item) {
            return $item['quantity'] * $item['price'];
        });
        
        $tax = $subtotal * 0.12; // Assuming 12% tax
        $discountRate = $request->discount ?? 0;
        $discountAmount = $subtotal * ($discountRate / 100);
        $total = $subtotal + $tax - $discountAmount;

        // Create the order
        $order = Order::create([
            'employee_id' => $request->employee_id,
            'total_amount' => $total,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discountRate,
            'discount_amount' => $discountAmount,
            'order_date' => now(),
            'status' => 'pending', // Default status
            'payment_method' => $request->payment_method,
        ]);

        // Attach products to the order
        foreach ($request->products as $product) {
            $order->products()->attach($product['product_id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }

        // If payment method was provided, process payment immediately
        if ($request->payment_method) {
            return $this->processPayment(new Request([
                'payment_method' => $request->payment_method,
                'amount' => $total,
                'reference_number' => $request->reference_number,
            ]), $order);
        }

        return redirect()->route('cashier.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load(['products', 'employee', 'payment']);
        return view('cashier.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $employees = Employee::all();
        $products = Product::all();
        return view('cashier.edit', compact('order', 'employees', 'products'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|in:pending,completed,voided,refunded',
        ]);

        // Recalculate totals
        $subtotal = collect($request->products)->sum(function ($item) {
            return $item['quantity'] * $item['price'];
        });
        
        $tax = $subtotal * 0.12;
        $discountRate = $request->discount ?? 0;
        $discountAmount = $subtotal * ($discountRate / 100);
        $total = $subtotal + $tax - $discountAmount;

        $order->update([
            'employee_id' => $request->employee_id,
            'total_amount' => $total,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discountRate,
            'discount_amount' => $discountAmount,
            'status' => $request->status,
        ]);

        // Sync products
        $order->products()->detach();
        foreach ($request->products as $product) {
            $order->products()->attach($product['product_id'], [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
        }

        return redirect()->route('cashier.show', $order)
            ->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('cashier.index')->with('success', 'Order deleted successfully.');
    }

    public function showPaymentForm(Order $order)
    {
        return view('cashier.payment', compact('order'));
    }

    public function processPayment(Request $request, Order $order)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,card,mobile',
            'amount' => 'required|numeric|min:' . $order->total_amount,
            'reference_number' => 'nullable|string|max:255',
            'amount_tendered' => 'required_if:payment_method,cash|numeric|min:' . $order->total_amount,
        ]);

        // Calculate change if cash payment
        $change = 0;
        if ($request->payment_method === 'cash') {
            $change = $request->amount_tendered - $order->total_amount;
        }

        // Create payment record
        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'amount' => $order->total_amount,
            'payment_date' => now(),
            'payment_method' => $request->payment_method,
            'payment_reference_number' => $request->reference_number,
        ]);

        // Update order status and payment info
        $order->update([
            'status' => 'completed',
            'payment_method' => $request->payment_method,
            'amount_tendered' => $request->amount_tendered ?? $order->total_amount,
            'change_amount' => $change,
        ]);

        return redirect()->route('cashier.show', $order)
            ->with('success', 'Payment processed successfully. Change: ₱' . number_format($change, 2));
    }

    public function showPaymentDetails(Order $order)
    {
        $payment = $order->payment;
        return view('cashier.payment_details', compact('order', 'payment'));
    }
}