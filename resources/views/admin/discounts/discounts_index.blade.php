@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manage Discounts</h2>
    <a href="{{ route('discounts.create') }}" class="btn btn-primary mb-3">Add New Discount</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Discount Number</th>
                <th>Name</th>
                <th>Type</th>
                <th>Value</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($discounts as $discount)
            <tr>
                <td>{{ $discount->id}}</td>
                <td>{{ $discount->name }}</td>
                <td>{{ ucfirst($discount->type) }}</td>
                <td>
                    @if($discount->type == 'percentage')
                        {{ $discount->value }}%
                    @else
                        ₱{{ number_format($discount->value, 2) }}
                    @endif
                </td>
                <td>
                    <span class="badge bg-{{ $discount->is_active ? 'success' : 'danger' }}">
                        {{ $discount->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('discounts.edit', $discount) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('discounts.destroy', $discount) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection