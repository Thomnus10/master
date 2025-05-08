@extends('layouts.pos')

@section('title', 'Order Receipt')

@section('content')
<h2>Order Receipt</h2>

<div class="mb-4">
    <strong>Order ID:</strong> {{ $order->id }}<br>
    <strong>Date:</strong> {{ $order->order_date->format('F d, Y h:i A') }}<br>
    <strong>Cashier:</strong> {{ $order->employee->Fname}} {{  $order->employee->Mname}} {{  $order->employee->Lname ?? 'Unknown' }}<br>
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
@php
    $subtotal = 0;
    $tax = $subtotal * 0.12;
    // $discountRate = $discount ?? 0;
    // $discountAmount = $subtotal * ($discount /100) ?? 0;
    $total = $subtotal + $tax;
    $amountTendered = $order->amount_tendered ?? $total;
    $changeAmount = $order->change_amount ?? 0;
@endphp

<div class="mt-4">
    <p><strong>Subtotal:</strong> ₱{{ number_format($subtotal, 2) }}</p>
    <p><strong>Tax (12%):</strong> ₱{{ number_format($tax, 2) }}</p>
    {{-- <p><strong>Discount ({{ $discountRate }}%):</strong> -₱{{ number_format($discountAmount, 2) }}</p> --}}
    <p class="fs-4"><strong>Total Amount:</strong> ₱{{ number_format($total, 2) }}</p>
    <p><strong>Amount Tendered:</strong> ₱{{ number_format($amountTendered, 2) }}</p>
    <p><strong>Change:</strong> ₱{{ number_format($changeAmount, 2) }}</p>
</div>


<a href="{{ route('cashier.index') }}" class="btn btn-primary mt-3">Back to POS</a>
@endsection

@section('cart')
    <div class="cart-header">
        <h5>Transaction Complete</h5>
        <p>Thank you for using the POS system.</p>
    </div>
@endsection
