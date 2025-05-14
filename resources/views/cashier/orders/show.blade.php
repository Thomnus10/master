@extends('layouts.pos')

@section('title', 'Payment Information')

@section('styles')
<style>
    .payment-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        border: none;
        margin-bottom: 20px;
    }
    
    .payment-header {
        background: linear-gradient(45deg, var(--primary-accent) 0%, #1e3a68 100%);
        padding: 16px 20px;
        border-bottom: none;
    }
    
    .payment-body {
        padding: 25px;
        background-color: #fff;
    }
    
    .payment-detail {
        margin-bottom: 8px;
        display: flex;
        align-items: center;
    }
    
    .payment-detail .label {
        font-weight: 600;
        min-width: 150px;
        color: #555;
    }
    
    .payment-detail .value {
        font-weight: 500;
        color: var(--primary-base);
    }
    
    .highlight-value {
        font-size: 18px;
        color: var(--primary-accent);
    }
    
    .btn-action {
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 600;
        margin-right: 10px;
        transition: all 0.2s ease;
    }
    
    .btn-primary {
        background-color: var(--complementary-accent);
        border-color: var(--complementary-accent);
    }
    
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    
    .btn-warning {
        background-color: #ff9800;
        border-color: #ff9800;
    }
    
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }
    
    .cart-summary-container {
        background: linear-gradient(180deg, #13213c 0%, #1d2f4d 100%);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .cart-header {
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 12px;
        margin-bottom: 15px;
    }
    
    .cart-item {
        background-color: rgba(255,255,255,0.05);
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 12px;
    }
    
    .total-price {
        background-color: var(--complementary-accent);
        color: var(--primary-accent);
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 20px;
        margin-top: 20px;
    }
    
    .new-order-button {
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 12px 20px;
        font-weight: 600;
        margin-top: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    
    .new-order-button:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }
    
    .icon-spacing {
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Order #{{ $order->id }} Details</h4>
        {{-- <a href="{{ route('cashier.pos.index') }}" class="new-order-button">
            <i class="bi bi-plus-circle icon-spacing"></i> New Order
        </a> --}}
    </div>

    @if($order->payment)
        <div class="payment-card">
            <div class="payment-header">
                <h5 class="mb-0 text-white"><i class="bi bi-check-circle-fill me-2"></i>Payment Completed</h5>
            </div>
            <div class="payment-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="payment-detail">
                            <span class="label"><i class="bi bi-credit-card icon-spacing"></i>Payment Method:</span>
                            <span class="value">{{ ucfirst($order->payment_method) }}</span>
                        </div>
                        <div class="payment-detail">
                            <span class="label"><i class="bi bi-cash icon-spacing"></i>Amount Tendered:</span>
                            <span class="value highlight-value">₱{{ number_format($order->amount_tendered, 2) }}</span>
                        </div>
                        <div class="payment-detail">
                            <span class="label"><i class="bi bi-arrow-return-right icon-spacing"></i>Change:</span>
                            <span class="value highlight-value">₱{{ number_format($order->change_amount, 2) }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="payment-detail">
                            <span class="label"><i class="bi bi-calendar-event icon-spacing"></i>Payment Date:</span>
                            <span class="value">{{ $order->payment->payment_date->format('M d, Y h:i A') }}</span>
                        </div>
                        @if($order->payment->payment_reference_number)
                            <div class="payment-detail">
                                <span class="label"><i class="bi bi-upc-scan icon-spacing"></i>Reference #:</span>
                                <span class="value">{{ $order->payment->payment_reference_number }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="action-buttons">
                    <a href="{{ route('orders.payment_details', $order) }}" class="btn btn-action btn-outline-primary">
                        <i class="bi bi-info-circle me-1"></i> View Details
                    </a>
                    <a href="{{ route('orders.receipt_pdf', $order) }}" class="btn btn-action btn-secondary">
                        <i class="bi bi-printer me-1"></i> Print Receipt
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="payment-card">
            <div class="payment-header bg-warning">
                <h5 class="mb-0 text-dark"><i class="bi bi-exclamation-triangle-fill me-2"></i>Payment Required</h5>
            </div>
            <div class="payment-body">
                <p class="mb-4">This order has not been paid yet. Please complete the payment process to finalize the order.</p>
                <a href="{{ route('orders.payment', $order) }}" class="btn btn-action btn-warning">
                    <i class="bi bi-wallet2 me-1"></i> Process Payment Now
                </a>
            </div>
        </div>
    @endif
@endsection

@section('cart')
    <div class="cart-summary-container">
        <div class="cart-header">
            <h5 class="text-white mb-0"><i class="bi bi-cart4 me-2"></i>Order Summary</h5>
        </div>

        @foreach ($order->products as $product)
            <div class="cart-item">
                <div class="fw-bold mb-1">{{ $product->name }}</div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>{{ $product->pivot->quantity }} x ₱{{ number_format($product->pivot->price, 2) }}</div>
                    <div>₱{{ number_format($product->pivot->quantity * $product->pivot->price, 2) }}</div>
                </div>
            </div>
        @endforeach

        <div class="total-price d-flex justify-content-between align-items-center">
            <span><i class="bi bi-currency-dollar me-1"></i>Total:</span>
            <span>₱{{ number_format($order->total_amount, 2) }}</span>
        </div>
        
        <a href="{{ route('cashier.pos.index') }}" class="btn btn-light btn-block w-100 mt-3">
            <i class="bi bi-arrow-left me-1"></i> Back to POS
        </a>
    </div>
@endsection