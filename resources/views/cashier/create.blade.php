@extends('layouts.pos')

@section('title', 'New Transaction')

@section('content')
<div class="container-fluid">
    <form action="{{ route('cashier.store') }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Transaction Details</div>
            <div class="card-body row g-3">
                <div class="col-md-6">
                    <label for="employee_id" class="form-label">Cashier</label>
                    <select name="employee_id" id="employee_id" class="form-select" required>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="order_date" value="{{ now()->toDateString() }}">
                <input type="hidden" name="status" value="completed">
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white">Transaction Items</div>
            <div class="card-body">
                @if(session('cart') && count(session('cart')) > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach(session('cart') as $i => $item)
                                    @php 
                                        $subtotal = $item['price'] * $item['quantity']; 
                                        $total += $subtotal;
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $item['name'] }}
                                            <input type="hidden" name="products[{{ $i }}][product_id]" value="{{ $item['id'] }}">
                                        </td>
                                        <td>
                                            {{ $item['quantity'] }}
                                            <input type="hidden" name="products[{{ $i }}][quantity]" value="{{ $item['quantity'] }}">
                                        </td>
                                        <td>
                                            ₱{{ number_format($item['price'], 2) }}
                                            <input type="hidden" name="products[{{ $i }}][price]" value="{{ $item['price'] }}">
                                        </td>
                                        <td>₱{{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                                    <td><strong>₱{{ number_format($total, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Submit Transaction</button>
                    </div>
                @else
                    <div class="alert alert-warning">No items in cart.</div>
                @endif
            </div>
        </div>
    </form>
</div>
@endsection
