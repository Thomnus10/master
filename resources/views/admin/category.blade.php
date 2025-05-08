@extends('layouts.app')

@section('title', 'All Categories')

@section('content')
<div class="main-content">
    <div class="content-wrapper">
        <h2 class="mb-4">All Categories</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add Category</a>
        <a href="{{ route('admin.inventory') }}" class="btn btn-secondary mb-3">Back</a>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th style="width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2">No categories found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
