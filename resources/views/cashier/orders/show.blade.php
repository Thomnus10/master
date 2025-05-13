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
        </div>
    </div>
@else
    <div class="card mt-4">
        <div class="card-header bg-warning">
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