@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Supplier Details</h1>
        <p><strong>Name:</strong> {{ $supplier->name }}</p>
        <p><strong>Contact:</strong> {{ $supplier->contact }}</p>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
@endsection
