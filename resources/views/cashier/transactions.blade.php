@extends('layouts.pos')
@section('title', 'Transactions')

@section('content')
    <h2>Transaction History</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Date</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>₱{{ number_format($order->total, 2) }}</td>
                    <td>
                        <a href="{{ route('receipt.view', $order->id) }}" class="btn btn-sm btn-primary">View Receipt</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
