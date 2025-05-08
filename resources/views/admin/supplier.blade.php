
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Suppliers</h1>
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary">Add New Supplier</a>
        
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->phone }}</td>
                        <td>
                            <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
