@extends('layouts.app')

@section('title', 'Edit Inventory')

@section('content')
<div class="container">
    <h2>Edit Inventory</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('inventories.update', $inventory->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Select Product -->
        <div class="form-group">
            <label for="product_id">Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $inventory->product_id == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Expiration Date Input -->
        <div class="form-group">
            <label for="expiration_date">Expiration Date</label>
            <input type="date" name="expiration_date" id="expiration_date" class="form-control" value="{{ $inventory->expiration_date }}" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success mt-3">Update Inventory</button>

        <!-- Cancel Button -->
        <a href="{{ route('admin.inventory') }}" class="btn btn-secondary mt-3 ml-2">Cancel</a>
    </form>
</div>
@endsection
