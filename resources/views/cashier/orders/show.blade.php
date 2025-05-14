@extends('layouts.pos')

@section('title', 'Payment Information')

@section('content')
    @if($order->payment)
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Payment Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
                        <p><strong>Amount Tendered:</strong> ₱{{ number_format($order->amount_tendered, 2) }}</p>
                        <p><strong>Change:</strong> ₱{{ number_format($order->change_amount, 2) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Payment Date:</strong> {{ $order->payment->payment_date->format('M d, Y h:i A') }}</p>
                        @if($order->payment->payment_reference_number)
                            <p><strong>Reference #:</strong> {{ $order->payment->payment_reference_number }}</p>
                        @endif
                    </div>
                </div>
                <a href="{{ route('orders.payment_details', $order) }}" class="btn btn-sm btn-outline-primary mt-2">
                    View Payment Details
                </a>
                <a href="{{ route('orders.print_receipt', $order) }}" target="_blank" class="btn btn-sm btn-success mt-2">
                    <i class="bi bi-printer"></i> Print Receipt
                </a>
                <a href="{{ route('orders.receipt_pdf', $order) }}" class="btn btn-sm btn-secondary mt-2">
                    <i class="bi bi-download"></i> Download PDF
                </a>

            </div>
        </div>
    @else
        <div class="card mt-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Payment Required</h5>
            </div>
            <div class="card-body">
                <p>This order has not been paid yet.</p>
                <a href="{{ route('orders.payment', $order) }}" class="btn btn-primary">
                    Process Payment
                </a>
            </div>
        </div>
    @endif
@endsection

@section('cart')
    <div class="cart-header">
        <h5 class="text-white">Cart Summary</h5>
    </div>

    @foreach ($order->products as $product)
        <div class="cart-item">
            <div><strong>{{ $product->name }}</strong></div>
            <div>{{ $product->pivot->quantity }} x ₱{{ number_format($product->pivot->price, 2) }}</div>
            <div class="text-end">₱{{ number_format($product->pivot->quantity * $product->pivot->price, 2) }}</div>
        </div>
    @endforeach

    <div class="cart-summary">
        <div class="total-price">Total: ₱{{ number_format($order->total_amount, 2) }}</div>
    </div>
@endsection