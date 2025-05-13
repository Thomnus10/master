@extends('layout.pos')
@section('title', 'Receipt')

@section('content')
    <div class="receipt-box">
        <h4>Receipt #{{ $order->id }}</h4>
        <p>Date: {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₱{{ number_format($item->price, 2) }}</td>
                        <td>₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="text-end fw-bold">Total Paid: ₱{{ number_format($order->total, 2) }}</p>
    </div>
@endsection