@extends('layouts.app')

@section('title', 'Process Payment')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Process Payment for Order #{{ $order->id }}</h4>
                </div>
                <div class="card-body">
                    <div class="receipt-box mb-4">
                        <h5 class="text-center mb-3">Order Summary</h5>
                        <table class="table table-sm">
                            <tr>
                                <th>Subtotal:</th>
                                <td class="text-end">₱{{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Tax (12%):</th>
                                <td class="text-end">₱{{ number_format($order->tax, 2) }}</td>
                            </tr>
                            @if($order->discount > 0)
                            <tr>
                                <th>Discount ({{ $order->discount }}%):</th>
                                <td class="text-end">-₱{{ number_format($order->discount_amount, 2) }}</td>
                            </tr>
                            @endif
                            <tr class="fw-bold">
                                <th>Total Amount:</th>
                                <td class="text-end">₱{{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </table>
                    </div>

                    <form method="POST" action="{{ route('orders.process-payment', $order) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="cash" {{ old('payment_method', $order->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="card" {{ old('payment_method', $order->payment_method) == 'card' ? 'selected' : '' }}>Credit/Debit Card</option>
                                <option value="mobile" {{ old('payment_method', $order->payment_method) == 'mobile' ? 'selected' : '' }}>Mobile Payment</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount Tendered</label>
                            <input type="number" step="0.01" class="form-control" id="amount" name="amount" 
                                   value="{{ old('amount', $order->total_amount) }}" min="{{ $order->total_amount }}" required>
                        </div>

                        <div class="mb-3" id="reference-field" style="display: none;">
                            <label for="reference_number" class="form-label">Reference Number</label>
                            <input type="text" class="form-control" id="reference_number" name="reference_number" 
                                   value="{{ old('reference_number') }}" placeholder="Enter transaction reference">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-credit-card me-2"></i> Process Payment
                            </button>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">
                                Back to Order
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethod = document.getElementById('payment_method');
        const referenceField = document.getElementById('reference-field');
        
        // Show/hide reference number field based on payment method
        paymentMethod.addEventListener('change', function() {
            if (this.value !== 'cash') {
                referenceField.style.display = 'block';
            } else {
                referenceField.style.display = 'none';
            }
        });
        
        // Trigger change event on page load
        paymentMethod.dispatchEvent(new Event('change'));
    });
</script>
@endsection
@endsection