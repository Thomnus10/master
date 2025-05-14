{{-- @extends('layouts.pos')

@section('title', 'Cashier - Cart')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Cart</h2>
        <a href="{{ route('cashier.index') }}" class="btn btn-secondary">Back to Products</a>
    </div>

    <div class="cart-header d-flex justify-content-between align-items-center">
        <h4>Cart</h4>
        <div class="discount-controls">
            @php $discount = session('active_discount'); @endphp
            @if($discount)
                <span class="badge bg-success me-2">
                    {{ $discount->name }}
                    ({{ $discount->type == 'percentage' ? $discount->value . '%' : '₱' . number_format($discount->value, 2) }})
                </span>
                <form action="{{ route('discounts.destroy') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                </form>
            @else
                <form action="{{ route('discounts.apply') }}" method="POST" class="d-flex align-items-center gap-2">
                    @csrf
                    <input type="number" name="discount_id" class="form-control form-control-sm w-auto"
                        placeholder="Enter Discount ID" min="1">
                    <button type="submit" class="btn btn-sm btn-outline-light">Apply</button>
                </form>
            @endif
        </div>
    </div>

    @php
        $cart = session('cart', []);
        $subtotal = 0;
        $discountAmount = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        if ($discount) {
            if ($discount->type == 'percentage') {
                $discountAmount = $subtotal * ($discount->value / 100);
            } else {
                $discountAmount = min($discount->value, $subtotal);
            }
        }

        $tax = $subtotal * 0.12;
        $total = $subtotal + $tax - $discountAmount;
    @endphp

    <!-- CART ITEMS -->
    <div class="cart-items mt-3" style="max-height: 50vh; overflow-y: auto;">
        @forelse($cart as $item)
            <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                <div>
                    <strong>{{ $item['name'] }}</strong><br>
                    ₱{{ number_format($item['price'], 2) }} x {{ $item['quantity'] }}
                </div>
                <div class="text-end">
                    ₱{{ number_format($item['price'] * $item['quantity'], 2) }}
                    <form action="{{ route('cart.removeFromCart', ['id' => $item['id']]) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger ms-2">x</button>
                    </form>

                </div>
            </div>
        @empty
            <p class="text-white">Cart is empty.</p>
        @endforelse
    </div>

    <!-- SUMMARY & CHECKOUT -->
    <div class="cart-summary mt-3">
        <table class="table table-sm table-borderless text-white">
            <tr>
                <td>Subtotal:</td>
                <td class="text-end">₱{{ number_format($subtotal, 2) }}</td>
            </tr>
            @if($discountAmount > 0)
                <tr>
                    <td>Discount:</td>
                    <td class="text-end">-₱{{ number_format($discountAmount, 2) }}</td>
                </tr>
            @endif
            <tr>
                <td>Tax (12%):</td>
                <td class="text-end">₱{{ number_format($tax, 2) }}</td>
            </tr>
            <tr class="fw-bold">
                <td>Total:</td>
                <td class="text-end">₱{{ number_format($total, 2) }}</td>
            </tr>
        </table>

        @if(count($cart) > 0)
            <form action="{{ route('cart.checkout') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="total_amount" value="{{ $total }}">

                @if($discount)
                    <input type="hidden" name="discount_id" value="{{ $discount->id }}">
                @endif

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success">Checkout</button>
                </div>
            </form>
        @endif
    </div>
@endsection --}}
