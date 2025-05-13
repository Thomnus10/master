@extends('layouts.app')

@section('title', 'Payment Details')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Payment Details for Order #{{ $order->id }}</h4>
                </div>
                <div class="card-body">
                    <div class="receipt-box mb-4">
                        <h5 class="text-center mb-3">Order Summary</h5>
                        <table class="table table-sm">
                            <tr>
                                <th>Order Date:</th>
                                <td class="text-end">{{ $order->order_date->format('M d, Y h:i A') }}</td>
                            </tr>
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

                    <div class="receipt-box">
                        <h5 class="text-center mb-3">Payment Information</h5>
                        <table class="table table-sm">
                            <tr>
                                <th>Payment Date:</th>
                                <td class="text-end">{{ $payment->payment_date->format('M d, Y h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Payment Method:</th>
                                <td class="text-end text-capitalize">{{ $payment->payment_method }}</td>
                            </tr>
                            <tr>
                                <th>Amount Paid:</th>
                                <td class="text-end">₱{{ number_format($payment->amount, 2) }}</td>
                            </tr>
                            @if($payment->payment_reference_number)
                            <tr>
                                <th>Reference Number:</th>
                                <td class="text-end">{{ $payment->payment_reference_number }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th>Processed By:</th>
                                <td class="text-end">{{ $payment->user->name }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">
                            Back to Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection