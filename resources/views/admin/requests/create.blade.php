@extends('layouts.app')

@section('title', 'Request Product')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Request a Product from Supplier</h2>
            </div>

            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('requests.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="product_id" class="form-label">Product *</label>
                            <select name="product_id" id="product_id" class="form-select" required>
                                <option value="">-- Select Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                        data-stock="{{ $inventoryQuantities[$product->id] ?? 0 }}"
                                        data-price="{{ $product->price }}">
                                        {{ $product->name }}
                                        ({{ $product->category->name ?? 'No Category' }})
                                        - Stock: {{ $inventoryQuantities[$product->id] ?? 0 }}
                                        {{ $product->unit->type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="supplier_id" class="form-label">Supplier *</label>
                            <select name="supplier_id" id="supplier_id" class="form-select" required>
                                <option value="">-- Select Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity *</label>
                            <input type="number" name="quantity" id="quantity" class="form-control" required min="1">
                            <div class="form-text">Current stock: <span id="current-stock">0</span></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Price Information</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text">Original Price</span>
                                <input type="text" class="form-control" id="original-price" readonly>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text">Supplier Price (10% off)</span>
                                <input type="text" class="form-control" id="supplier-price" readonly>
                                <input type="hidden" name="price" id="supplier-price-hidden">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('requests.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Send Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productSelect = document.getElementById('product_id');
            const quantityInput = document.getElementById('quantity');
            const currentStockSpan = document.getElementById('current-stock');
            const originalPriceInput = document.getElementById('original-price');
            const supplierPriceInput = document.getElementById('supplier-price');
            const supplierPriceHidden = document.getElementById('supplier-price-hidden');

            productSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const stock = selectedOption.getAttribute('data-stock');
                const price = selectedOption.getAttribute('data-price');

                currentStockSpan.textContent = stock;

                if (price) {
                    const originalPrice = parseFloat(price).toFixed(2);
                    const discountedPrice = (originalPrice * 0.9).toFixed(2); // 10% discount

                    originalPriceInput.value = '₱' + originalPrice;
                    supplierPriceInput.value = '₱' + discountedPrice;
                    supplierPriceHidden.value = discountedPrice;
                } else {
                    originalPriceInput.value = '';
                    supplierPriceInput.value = '';
                    supplierPriceHidden.value = '';
                }
            });


            // Calculate estimated cost when quantity changes
            quantityInput.addEventListener('input', function () {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                if (selectedOption) {
                    const price = selectedOption.getAttribute('data-price');
                    calculateEstimatedCost(price, this.value);
                }
            });

            function calculateEstimatedCost(price, quantity) {
                if (price && quantity) {
                    const cost = (parseFloat(price) * parseInt(quantity)).toFixed(2);
                    estimatedCostInput.value = cost;
                } else {
                    estimatedCostInput.value = '';
                }
            }
        });
    </script>
@endsection