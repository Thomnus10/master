@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Request Product from Supplier</h2>
    <form action="{{ route('products.request') }}" method="POST">
        @csrf
        <select name="product_id" required>
            @foreach ($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>

        <select name="supplier_id" required>
            @foreach ($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
            @endforeach
        </select>

        <input type="number" name="quantity" placeholder="Quantity" required>
        <input type="number" step="0.01" name="price" placeholder="Unit Price" required>
        <button type="submit" class="btn btn-primary">Request Product</button>
    </form>
</div>
@endsection
