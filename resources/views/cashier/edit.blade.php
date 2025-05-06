```php
@extends('layouts.pos')

@section('title', 'Edit Order #' . $order->id)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Order #{{ $order->id }}</h2>
        <a href="{{ route('cashier.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            Order Details
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3">
                    <strong>Order Date:</strong> {{ $order->order_date->format('M d, Y h:i A') }}
                </div>
                <div class="col-md-3">
                    <strong>Status:</strong> 
                    <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'voided' ? 'danger' : 'warning') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="col-md-3">
                    <strong>Cashier:</strong> {{ $order->employee->name ?? 'N/A' }}
                </div>
                <div class="col-md-3">
                    <strong>Customer:</strong> {{ $order->customer_name ?? 'Walk-in Customer' }}
                </div>
            </div>
            
            <form action="{{ route('cashier.update', $order) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subtotal = 0; @endphp
                            @foreach ($order->products as $product)
                                @php 
                                    $itemTotal = $product->pivot->price * $product->pivot->quantity;
                                    $subtotal += $itemTotal;
                                @endphp
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>₱{{ number_format($product->pivot->price, 2) }}</td>
                                    <td>
                                        <div class="input-group">
                                            <button type="button" class="btn btn-outline-secondary quantity-btn" data-action="decrease" data-id="{{ $product->id }}">-</button>
                                            <input type="number" name="quantities[{{ $product->id }}]" value="{{ $product->pivot->quantity }}" min="1" class="form-control text-center quantity-input">
                                            <button type="button" class="btn btn-outline-secondary quantity-btn" data-action="increase" data-id="{{ $product->id }}">+</button>
                                        </div>
                                    </td>
                                    <td>₱{{ number_format($itemTotal, 2) }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-item" data-id="{{ $product->id }}">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Subtotal</strong></td>
                                <td colspan="2">₱{{ number_format($subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Tax (12%)</strong></td>
                                <td colspan="2">₱{{ number_format($subtotal * 0.12, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Discount</strong></td>
                                <td colspan="2">
                                    <div class="input-group">
                                        <input type="number" name="discount" value="{{ $order->discount ?? 0 }}" min="0" max="100" class="form-control">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total</strong></td>
                                <td colspan="2" class="fw-bold">₱{{ number_format($subtotal + ($subtotal * 0.12) - ($subtotal * ($order->discount ?? 0) / 100), 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="mb-3">
                    <label for="status" class="form-label">Update Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="voided" {{ $order->status === 'voided' ? 'selected' : '' }}>Voided</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3">{{ $order->notes ?? '' }}</textarea>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save"></i> Update Order
                    </button>
                    <a href="{{ route('cashier.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                    <button type="button" class="btn btn-info" id="printReceipt">
                        <i class="bi bi-printer"></i> Print Receipt
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('cart')
<div class="cart-header">
    <h3>Order #{{ $order->id }}</h3>
    <p class="text-light">{{ $order->order_date->format('M d, Y h:i A') }}</p>
</div>

<div class="customer-info mb-4">
    <h5>Customer Information</h5>
    <p>
        <strong>Name:</strong> {{ $order->customer_name ?? 'Walk-in Customer' }}<br>
        <strong>Contact:</strong> {{ $order->customer_contact ?? 'N/A' }}
    </p>
</div>

<div class="cashier-details mb-4">
    <h5>Order Details</h5>
    <p>
        <strong>Cashier:</strong> {{ $order->employee->name ?? 'N/A' }}<br>
        <strong>Status:</strong> 
        <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'voided' ? 'danger' : 'warning') }}">
            {{ ucfirst($order->status) }}
        </span>
    </p>
</div>

<div class="cart-items mb-3">
    @php $subtotal = 0; @endphp
    
    @foreach ($order->products as $product)
        @php 
            $itemTotal = $product->pivot->price * $product->pivot->quantity;
            $subtotal += $itemTotal;
        @endphp
        <div class="cart-item">
            <div class="d-flex justify-content-between">
                <div>
                    <strong>{{ $product->name }}</strong>
                    <div>{{ $product->pivot->quantity }} × ₱{{ number_format($product->pivot->price, 2) }}</div>
                </div>
                <div class="text-end">
                    <strong>₱{{ number_format($itemTotal, 2) }}</strong>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="cart-summary">
    <div class="d-flex justify-content-between mb-2">
        <span>Subtotal</span>
        <strong>₱{{ number_format($subtotal, 2) }}</strong>
    </div>
    
    <div class="d-flex justify-content-between mb-2">
        <span>Tax (12%)</span>
        <strong>₱{{ number_format($subtotal * 0.12, 2) }}</strong>
    </div>
    
    <div class="d-flex justify-content-between mb-3">
        <span>Discount ({{ $order->discount ?? 0 }}%)</span>
        <strong>-₱{{ number_format($subtotal * ($order->discount ?? 0) / 100, 2) }}</strong>
    </div>
    
    <div class="total-price">
        Total: ₱{{ number_format($subtotal + ($subtotal * 0.12) - ($subtotal * ($order->discount ?? 0) / 100), 2) }}
    </div>
    
    <div class="action-buttons">
        <button class="action-button" id="voidOrderBtn">Void Order</button>
        <button class="action-button" id="printReceiptBtn">Print Receipt</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Handle quantity buttons
        $('.quantity-btn').click(function() {
            var action = $(this).data('action');
            var input = $(this).siblings('.quantity-input');
            var currentQty = parseInt(input.val());
            
            if (action === 'increase') {
                input.val(currentQty + 1);
            } else if (action === 'decrease' && currentQty > 1) {
                input.val(currentQty - 1);
            }
            
            // Recalculate prices
            updateSubtotals();
        });
        
        // Remove item button
        $('.remove-item').click(function() {
            var productId = $(this).data('id');
            
            if (confirm('Are you sure you want to remove this item from the order?')) {
                // Add a hidden input to mark this product for removal
                $('<input>').attr({
                    type: 'hidden',
                    name: 'remove_items[]',
                    value: productId
                }).appendTo('form');
                
                // Hide the row
                $(this).closest('tr').addClass('table-danger').fadeOut(500);
            }
        });
        
        // Function to update subtotals when quantities change
        function updateSubtotals() {
            var subtotal = 0;
            
            $('tbody tr').each(function() {
                var price = parseFloat($(this).find('td:eq(1)').text().replace('₱', '').replace(',', ''));
                var quantity = parseInt($(this).find('.quantity-input').val());
                var itemTotal = price * quantity;
                
                $(this).find('td:eq(3)').text('₱' + itemTotal.toFixed(2));
                subtotal += itemTotal;
            });
            
            var tax = subtotal * 0.12;
            var discountPercent = parseFloat($('input[name="discount"]').val()) || 0;
            var discountAmount = subtotal * (discountPercent / 100);
            var total = subtotal + tax - discountAmount;
            
            // Update the table footer
            $('tfoot tr:eq(0) td:last').text('₱' + subtotal.toFixed(2));
            $('tfoot tr:eq(1) td:last').text('₱' + tax.toFixed(2));
            $('tfoot tr:eq(3) td:last').text('₱' + total.toFixed(2));
        }
        
        // Update when discount changes
        $('input[name="discount"]').on('input', function() {
            updateSubtotals();
        });
        
        // Void order button
        $('#voidOrderBtn, #printReceiptBtn').click(function() {
            var action = $(this).attr('id') === 'voidOrderBtn' ? 'void' : 'print';
            
            if (action === 'void') {
                if (confirm('Are you sure you want to void this order?')) {
                    // Set status to voided and submit the form
                    $('#status').val('voided');
                    $('form').submit();
                }
            } else {
                // Print receipt functionality
                window.print();
            }
        });
    });
</script>
@endsection
```