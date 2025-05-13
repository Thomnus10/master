@extends('layouts.pos')

@section('title', 'POS System')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="mb-3" style="color: var(--primary-accent); font-weight: 600;">Point of Sale</h2>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="productScanForm" method="POST" action="{{ route('cart.scanProductId') }}">
                        @csrf
                        <div class="input-group mb-4">
                            <input type="text" class="form-control form-control-lg" 
                                   id="productInput" name="product_id" 
                                   placeholder="Scan barcode or enter product ID" autofocus>
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-plus-lg me-1"></i> Add
                            </button>
                        </div>
                    </form>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 style="color: var(--primary-accent); margin-bottom: 0;">Products</h4>
                                <div class="form-group mb-0">
                                    <input type="text" id="productSearch" class="form-control form-control-sm" placeholder="Search products...">
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>₱{{ number_format($product->price, 2) }}</td>
                                            <td>
                                                <span class="badge {{ $product->totalInventoryQuantity() > 10 ? 'bg-success' : ($product->totalInventoryQuantity() > 5 ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $product->totalInventoryQuantity() }}
                                                </span>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('cart.addToCart') }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="bi bi-cart-plus"></i> Add
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('cart')
<div class="cart-header">
    <h3>Current Order</h3>
</div>

<div class="customer-info">
    @if(session('current_discount'))
    <div class="alert alert-success p-2 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-tag-fill me-1"></i>
                <span>{{ session('current_discount')['name'] }}</span>
            </div>
            <form method="POST" action="{{ route('discounts.remove') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="bi bi-x"></i>
                </button>
            </form>
        </div>
    </div>
    @endif
</div>

<div class="cart-items">
    @php
        $subtotal = 0;
        $taxRate = 0.12;
    @endphp
    
    @foreach($cart as $item)
    <div class="cart-item">
        <div class="d-flex justify-content-between">
            <div>
                <strong>{{ $item['name'] }}</strong><br>
                <small>₱{{ number_format($item['price'], 2) }} × {{ $item['quantity'] }}</small>
            </div>
            <div class="text-end">
                <span class="fw-bold">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                <form method="POST" action="{{ route('cart.removeFromCart', $item['id']) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger ms-2">×</button>
                </form>
            </div>
        </div>
        <form method="POST" action="{{ route('cart.updateQuantity') }}" class="mt-2">
            @csrf
            <input type="hidden" name="product_id" value="{{ $item['id'] }}">
            <div class="input-group input-group-sm">
                <button type="button" class="btn btn-outline-secondary decrease-qty">-</button>
                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" 
                       class="form-control text-center" onchange="this.form.submit()">
                <button type="button" class="btn btn-outline-secondary increase-qty">+</button>
            </div>
        </form>
    </div>
    @php
        $subtotal += $item['price'] * $item['quantity'];
    @endphp
    @endforeach
    
    @if(empty($cart))
    <div class="text-center py-4">
        <div style="opacity: 0.7;">
            <i class="bi bi-cart" style="font-size: 2rem;"></i>
            <p class="mt-2">Your cart is empty</p>
        </div>
    </div>
    @endif
</div>

<div class="cart-summary mt-auto">
    <div class="total-price">
        <div class="d-flex justify-content-between">
            <span>Subtotal:</span>
            <span>₱{{ number_format($subtotal, 2) }}</span>
        </div>
        
        @php
            $tax = $subtotal * $taxRate;
            $discountAmount = 0;
            
            if(session('current_discount')) {
                $discount = session('current_discount');
                if($discount['type'] === 'percentage') {
                    $discountAmount = $subtotal * ($discount['value'] / 100);
                } else {
                    $discountAmount = $discount['value'];
                }
            }
            
            $total = $subtotal + $tax - $discountAmount;
        @endphp
        
        <div class="d-flex justify-content-between">
            <span>Tax (12%):</span>
            <span>₱{{ number_format($tax, 2) }}</span>
        </div>
        
        @if($discountAmount > 0)
        <div class="d-flex justify-content-between">
            <span>Discount:</span>
            <span class="text-danger">-₱{{ number_format($discountAmount, 2) }}</span>
        </div>
        @endif
        
        <div class="d-flex justify-content-between fw-bold fs-5 mt-2">
            <span>Total:</span>
            <span>₱{{ number_format($total, 2) }}</span>
        </div>
    </div>
    
    <div class="action-buttons">
        @if(!empty($cart))
        <button type="button" class="action-button" data-bs-toggle="modal" data-bs-target="#discountModal">
            <i class="bi bi-tag me-1"></i> Discount
        </button>
        
        <form method="POST" action="{{ route('cart.clearCart') }}">
            @csrf
            <button type="submit" class="action-button">
                <i class="bi bi-trash me-1"></i> Clear
            </button>
        </form>
        
        <button type="button" class="action-button payment" data-bs-toggle="modal" data-bs-target="#paymentModal">
            <i class="bi bi-credit-card me-1"></i> Process Payment
        </button>
        @endif
    </div>
</div>

<!-- Discount Modal -->
<div class="modal fade" id="discountModal" tabindex="-1" aria-labelledby="discountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="discountModalLabel">Apply Discount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('discounts.apply') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="discountSelect" class="form-label">Select Discount</label>
                        <select class="form-select" id="discountSelect" name="discount_id" required>
                            <option value="">-- Select Discount --</option>
                            @foreach($activeDiscounts as $discount)
                            <option value="{{ $discount->id }}">
                                {{ $discount->name }} - 
                                @if($discount->type === 'percentage')
                                    {{ $discount->value }}%
                                @else
                                    ₱{{ number_format($discount->value, 2) }}
                                @endif
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Apply Discount</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="color: var(--primary-accent);">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Process Payment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('cart.checkout') }}">
                @csrf
                <input type="hidden" name="total_amount" value="{{ $total }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Payment Method</label>
                                <div class="payment-method-options">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" checked>
                                        <label class="form-check-label d-flex align-items-center" for="cash">
                                            <span class="payment-icon me-2">💵</span>
                                            <span>Cash</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="payment_method" id="card" value="card">
                                        <label class="form-check-label d-flex align-items-center" for="card">
                                            <span class="payment-icon me-2">💳</span>
                                            <span>Credit/Debit Card</span>
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" id="mobile" value="mobile">
                                        <label class="form-check-label d-flex align-items-center" for="mobile">
                                            <span class="payment-icon me-2">📱</span>
                                            <span>GCash/Mobile Payment</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3" id="referenceNumberField" style="display: none;">
                                <label for="payment_reference_number" class="form-label fw-bold">Reference Number</label>
                                <input type="text" class="form-control" id="payment_reference_number" name="payment_reference_number" placeholder="Enter reference number">
                            </div>
                            
                            <div class="mb-3" id="amountTenderedField">
                                <label for="amount_tendered" class="form-label fw-bold">Amount Tendered</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" class="form-control" id="amount_tendered" name="amount_tendered" 
                                           step="0.01" min="{{ $total }}" required placeholder="0.00">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="notes" class="form-label fw-bold">Notes (Optional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Add any special instructions..."></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="receipt-summary p-3">
                                <h5 class="mb-3 text-center" style="color: var(--primary-accent);">Order Summary</h5>
                                
                                <div class="receipt-items mb-3">
                                    @foreach($cart as $item)
                                    <div class="d-flex justify-content-between mb-2">
                                        <div>
                                            <span class="fw-bold">{{ $item['name'] }}</span><br>
                                            <small>{{ $item['quantity'] }} × ₱{{ number_format($item['price'], 2) }}</small>
                                        </div>
                                        <span>₱{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <div class="receipt-totals">
                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                        <span>Subtotal:</span>
                                        <span>₱{{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                        <span>Tax (12%):</span>
                                        <span>₱{{ number_format($tax, 2) }}</span>
                                    </div>
                                    @if($discountAmount > 0)
                                    <div class="d-flex justify-content-between py-2 border-bottom">
                                        <span>Discount:</span>
                                        <span class="text-danger">-₱{{ number_format($discountAmount, 2) }}</span>
                                    </div>
                                    @endif
                                    <div class="d-flex justify-content-between py-2 fw-bold fs-5" style="color: var(--complementary-accent);">
                                        <span>Total:</span>
                                        <span>₱{{ number_format($total, 2) }}</span>
                                    </div>
                                </div>
                                
                                <div class="alert alert-info mt-3 mb-0">
                                    <div class="d-flex justify-content-between">
                                        <strong>Change:</strong>
                                        <span id="changeAmount" class="fw-bold">₱0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Complete Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Focus product input on page load
    document.getElementById('productInput').focus();
    
    // Show/hide reference number field based on payment method
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const referenceField = document.getElementById('referenceNumberField');
    const amountTenderedField = document.getElementById('amountTenderedField');
    const amountTenderedInput = document.getElementById('amount_tendered');
    const changeAmount = document.getElementById('changeAmount');
    const totalDue = {{ $total }};
    
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            if (this.value === 'cash') {
                referenceField.style.display = 'none';
                amountTenderedField.style.display = 'block';
                amountTenderedInput.required = true;
                amountTenderedInput.value = '';
                changeAmount.textContent = '₱0.00';
                changeAmount.style.color = '';
            } else {
                referenceField.style.display = 'block';
                amountTenderedField.style.display = 'none';
                amountTenderedInput.required = false;
                amountTenderedInput.value = totalDue.toFixed(2);
                changeAmount.textContent = '₱0.00';
                changeAmount.style.color = '';
            }
        });
    });
    
    // Calculate change in real-time
    if (amountTenderedInput) {
        amountTenderedInput.addEventListener('input', function() {
            const tendered = parseFloat(this.value) || 0;
            const change = tendered - totalDue;
            
            if (change >= 0) {
                changeAmount.textContent = '₱' + change.toFixed(2);
                changeAmount.style.color = 'var(--success-color)';
            } else {
                changeAmount.textContent = '₱0.00';
                changeAmount.style.color = 'var(--danger-color)';
            }
        });
    }
    
    // Submit form on Enter key in product input
    document.getElementById('productInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('productScanForm').submit();
        }
    });
    
    // Product search functionality
    document.getElementById('productSearch').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const productRows = document.querySelectorAll('tbody tr');
        
        productRows.forEach(row => {
            const productName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const productId = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            
            if (productName.includes(searchTerm) || productId.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Quantity controls
    document.querySelectorAll('.decrease-qty').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const currentVal = parseInt(input.value);
            if (currentVal > 1) {
                input.value = currentVal - 1;
                input.dispatchEvent(new Event('change'));
            }
        });
    });
    
    document.querySelectorAll('.increase-qty').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentElement.querySelector('input');
            const currentVal = parseInt(input.value);
            input.value = currentVal + 1;
            input.dispatchEvent(new Event('change'));
        });
    });
});
</script>
@endsection