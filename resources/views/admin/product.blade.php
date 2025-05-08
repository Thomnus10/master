@extends('layouts.app')

@section('title', 'All Products')

@section('content')
<div class="content-wrapper">
    <h2 class="mb-4">All Products</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add New Product</a>
    <a href="{{ route('admin.inventory') }}" class="btn btn-secondary mb-3">Back</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
                <th>Unit</th>
                <th style="width: 150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>₱{{ number_format($product->price, 2) }}</td>
                <td>{{ $product->category->name ?? 'N/A' }}</td>
                <td>{{ $product->unit->type ?? 'N/A' }}</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6">No products found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
