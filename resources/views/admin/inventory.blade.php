@extends('layouts.app')

@section('title', 'Inventory List')

@section('content')
<div class="container">
    <h2>Inventory List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Action Buttons Section -->
    <div class="mb-3">
        <a href="{{ route('inventories.create') }}" class="btn btn-primary mb-3">Add Stock</a>
        <a href="{{ route('products.index') }}" class="btn btn-primary mb-3 ml-2">Products</a>
        <a href="{{ route('categories.index') }}" class="btn btn-primary mb-3 ml-2">Categories</a> 
    </div>

    <!-- Inventory Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Expiration Date</th>
                <th>Category</th> <!-- Added Category Column -->
                <th>Description</th>
                <th>Suppliers</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inventories as $inventory)
                <tr>
                    <!-- Accessing product details through the inventory -->
                    <td>{{ $inventory->product->name ?? 'N/A' }}</td>
                    <td>{{ $inventory->product->suppliers->sum('pivot.quantity') }} {{$inventory->product->unit->type}}</td>
                    <td>{{ \Carbon\Carbon::parse($inventory->expiration_date)->format('F d, Y') }}</td>
                    <td>{{ $inventory->product->category->name ?? 'N/A' }}</td> <!-- Displaying Category Name -->
                    <td>{{ $inventory->product->description ?? 'N/A' }}</td>
                    <td>
                        @forelse ($inventory->product->suppliers as $supplier)
                            <div>
                                <strong>{{ $supplier->name }}</strong><br>
                                <small>Price: ₱{{ number_format($supplier->pivot->price, 2) }}</small><br>
                                <small>Quantity: {{ $supplier->pivot->quantity }}</small>
                            </div>
                        @empty
                            <span class="text-muted">No suppliers</span>
                        @endforelse
                    </td>
                    
                    <td>₱ {{ $inventory->product->price ?? 'N/A' }}</td>

                    <td>
                        <a href="{{ route('products.edit', $inventory->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No inventory records found.</td> <!-- Adjusted colspan for new column -->
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
