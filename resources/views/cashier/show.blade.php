{{-- @extends('layouts.pos')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Order #{{ $order->id }}</h2>
            <p class="mb-1"><strong>Date:</strong> {{ $order->order_date->format('M d, Y h:i A') }}</p>
            <p class="mb-1"><strong>Cashier:</strong> {{ $order->employee->name }}</p>
            <p class="mb-1"><strong>Status:</strong> 
                <span class="badge 
                    @if($order->status == 'completed') bg-success 
                    @elseif($order->status == 'voided') bg-danger 
                    @elseif($order->status == 'refunded') bg-warning 
                    @else bg-secondary @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </p>
        </div>
        <div class="col-md-6 text-md-end">
            @if($order->status == 'completed')
                <a href="{{ route('cashier.payment-details', $order) }}" class="btn btn-primary me-2">
                    View Payment Details
                </a>
            @elseif($order->status == 'pending')
                <a href="{{ route('cashier.payment', $order) }}" class="btn btn-success me-2">
                    Process Payment
                </a>
            @endif
            <a href="{{ route('cashier.index') }}" class="btn btn-outline-secondary">
                Back to Orders
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Order Items</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Qty</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td class="text-end">₱{{ number_format($product->pivot->price, 2) }}</td>
                                <td class="text-end">{{ $product->pivot->quantity }}</td>
                                <td class="text-end">₱{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td>Subtotal:</td>
                            <td class="text-end">₱{{ number_format($order->subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Tax (12%):</td>
                            <td class="text-end">₱{{ number_format($order->tax, 2) }}</td>
                        </tr>
                        @if($order->discount > 0)
                        <tr>
                            <td>Discount ({{ $order->discount }}%):</td>
                            <td class="text-end">-₱{{ number_format($order->discount_amount, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="fw-bold">
                            <td>Total Amount:</td>
                            <td class="text-end">₱{{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($order->status == 'completed')
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Payment Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td>Method:</td>
                            <td class="text-end text-capitalize">{{ $order->payment_method }}</td>
                        </tr>
                        <tr>
                            <td>Amount Tendered:</td>
                            <td class="text-end">₱{{ number_format($order->amount_tendered, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Change:</td>
                            <td class="text-end">₱{{ number_format($order->change_amount, 2) }}</td>
                        </tr>
                        @if($order->payment && $order->payment->payment_reference_number)
                        <tr>
                            <td>Reference #:</td>
                            <td class="text-end">{{ $order->payment->payment_reference_number }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($order->notes)
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Order Notes</h5>
        </div>
        <div class="card-body">
            {{ $order->notes }}
        </div>
    </div>
    @endif
</div>
@endsection

@section('cart')
    <!-- Empty cart section for this view -->
    <div class="d-flex flex-column justify-content-center align-items-center h-100">
        <div class="text-center">
            <h4>Order Details</h4>
            <p class="text-muted">Viewing order #{{ $order->id }}</p>
            <a href="{{ route('cashier.index') }}" class="btn btn-outline-light mt-3">
                Back to POS
            </a>
        </div>
    </div>
@endsection --}}