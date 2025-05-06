@extends('layouts.pos')

@section('title', 'Cashier - POS System')

@section('content')
    <h2 class="mb-4">Product List</h2>

    <form action="{{ route('cart.scanProductId') }}" method="POST">
        @csrf
        <label for="product_id">Enter Product ID:</label>
        <input type="number" name="product_id" id="product_id" class="form-control" required min="1">
        <button type="submit" class="btn btn-primary w-100 mt-2">Add to Cart</button>
    </form>
    

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">₱{{ number_format($product->price, 2) }}</p>
                    <form action="{{ route('cart.addToCart') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" value="1" min="1" class="form-control mb-2">
                        <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection

@section('cart')
    <div class="cart-header">
        <h4>Cart</h4>
    </div>

    @php
        $cart = session('cart', []);
        $discount = session('discount', 0);
        $subtotal = 0;
    @endphp

    @forelse($cart as $item)
        @php $itemSubtotal = $item['price'] * $item['quantity']; $subtotal += $itemSubtotal; @endphp
        <div class="cart-item">
            <strong>{{ $item['name'] }}</strong><br>
            ₱{{ number_format($item['price'], 2) }} × 
            <form action="{{ route('cart.updateQuantity') }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" style="width: 60px;">
                <button class="btn btn-sm btn-light">⟳</button>
            </form>
            <form action="{{ route('cart.removeFromCart', $item['id']) }}" method="POST" class="d-inline ms-2">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-danger">✕</button>
            </form>
        </div>
    @empty
        <p>No items in cart.</p>
    @endforelse

    @php
        $tax = $subtotal * 0.12;
        $discountAmount = $subtotal * ($discount / 100);
        $total = $subtotal + $tax - $discountAmount;
    @endphp

    <div class="cart-summary mt-3">
        <div class="total-price">Subtotal: ₱{{ number_format($subtotal, 2) }}</div>
        <div class="total-price">Tax (12%): ₱{{ number_format($tax, 2) }}</div>
        <div class="total-price">Discount ({{ $discount }}%): -₱{{ number_format($discountAmount, 2) }}</div>
        <div class="total-price">Total: ₱{{ number_format($total, 2) }}</div>

        <form action="{{ route('cart.checkout') }}" method="POST" class="mt-3">
            @csrf
            <input type="hidden" name="total_amount" value="{{ $total }}">

            <input type="number" name="amount_tendered" class="form-control mb-2" step="0.01" placeholder="Amount Tendered" required>
            {{-- <input type="text" name="customer_name" class="form-control mb-2" placeholder="Customer Name">
            <input type="text" name="customer_contact" class="form-control mb-2" placeholder="Customer Contact"> --}}
            
            <select name="payment_method" class="form-select mb-3">
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="mobile">Mobile</option>
            </select>

            <div class="action-buttons">
                <button type="submit" class="action-button payment">Checkout</button>
            </div>
        </form>

        <form action="{{ route('cart.clearCart') }}" method="POST" class="mt-2">
            @csrf
            <button type="submit" class="action-button w-100">Clear Cart</button>
        </form>
    </div>
@endsection
