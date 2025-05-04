@extends('layouts.app')

@section('title', 'Add Inventory')

@section('content')
<div class="container">
    <h2>Add Inventory</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('inventories.store') }}" method="POST">
        @csrf

        <!-- Select Product -->
        <div class="form-group">
            <label for="product_id">Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="" disabled selected>Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Quantity Input -->
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" required>
        </div>

        <!-- Expiration Date Input -->
        <div class="form-group">
            <label for="expiration_date">Expiration Date</label>
            <input type="date" name="expiration_date" id="expiration_date" class="form-control" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary mt-3">Save Inventory</button>

        <!-- Cancel Button -->
        <a href="{{ route('admin.inventory') }}" class="btn btn-secondary mt-3 ml-2">Back</a>
    </form>
</div>
@endsection
