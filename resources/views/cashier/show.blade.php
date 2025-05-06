@extends('layouts.pos')

@section('title', 'Order Receipt')

@section('content')
<h2>Order Receipt</h2>

<div class="mb-4">
    <strong>Order ID:</strong> {{ $order->id }}<br>
    <strong>Date:</strong> {{ $order->order_date->format('F d, Y h:i A') }}<br>
    <strong>Cashier:</strong> {{ $order->employee->name ?? 'Unknown' }}<br>
    <strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}<br>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Product</th>
            <th class="text-end">Quantity</th>
            <th class="text-end">Price</th>
            <th class="text-end">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td class="text-end">{{ $product->pivot->quantity }}</td>
            <td class="text-end">₱{{ number_format($product->pivot->price, 2) }}</td>
            <td class="text-end">₱{{ number_format($product->pivot->quantity * $product->pivot->price, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    <p><strong>Subtotal:</strong> ₱{{ number_format($order->subtotal, 2) }}</p>
    <p><strong>Tax (12%):</strong> ₱{{ number_format($order->tax, 2) }}</p>
    <p><strong>Discount ({{ $order->discount ?? 0 }}%):</strong> -₱{{ number_format($order->discount_amount, 2) }}</p>
    <p class="fs-4"><strong>Total Amount:</strong> ₱{{ number_format($order->total_amount, 2) }}</p>
    <p><strong>Amount Tendered:</strong> ₱{{ number_format($order->amount_tendered, 2) }}</p>
    <p><strong>Change:</strong> ₱{{ number_format($order->change_amount, 2) }}</p>
</div>

<a href="{{ route('cashier.index') }}" class="btn btn-primary mt-3">Back to POS</a>
@endsection

@section('cart')
    <div class="cart-header">
        <h5>Transaction Complete</h5>
        <p>Thank you for using the POS system.</p>
    </div>
@endsection
