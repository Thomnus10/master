@extends('layouts.pos')

@section('title', 'POS Cashier Screen')

@section('content')
    <div class="products-section">
        <div class="search-bar">
            <input type="text" placeholder="Search products...">
            <button>Search</button>
        </div>

        <div class="categories">
            <div class="category active">All Products</div>
            <div class="category">Beverages</div>
            <div class="category">Snacks</div>
            <div class="category">Desserts</div>
        </div>

        <div class="products-grid">
            <!-- Example product -->
            <div class="product">
                <div class="product-image">Image</div>
                <div class="product-name">Latte</div>
                <div class="product-price">$4.00</div>
            </div>
        </div>
    </div>

    <div class="cart-section">
        <div class="cart-header">
            <div class="cart-title">Current Order</div>
            <button class="cart-clear">Clear All</button>
        </div>

        <div class="cart-items">
            <div class="cart-item">
                <div class="cart-item-info">
                    <div class="cart-item-name">Latte</div>
                    <div class="cart-item-price">$4.00</div>
                </div>
                <div class="cart-item-controls">
                    <button class="cart-quantity-btn">-</button>
                    <div class="cart-quantity">1</div>
                    <button class="cart-quantity-btn">+</button>
                </div>
            </div>
        </div>

        <div class="cart-summary">
            <div class="cart-subtotal">
                <div>Subtotal</div>
                <div>$4.00</div>
            </div>
            <div class="cart-tax">
                <div>Tax (8%)</div>
                <div>$0.32</div>
            </div>
            <div class="cart-total">
                <div>Total</div>
                <div>$4.32</div>
            </div>

            <div class="cart-actions">
                <button class="cart-action-btn cart-hold-btn">Hold</button>
                <button class="cart-action-btn cart-checkout-btn">Checkout</button>
            </div>
        </div>
    </div>
@endsection
