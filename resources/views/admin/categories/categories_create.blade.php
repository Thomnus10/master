@extends('layouts.app')

@section('title', 'Add Category')

@section('content')
<div class="container">
    <h2>Add Category</h2>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Save Category</button>
        <!-- Cancel Button -->
        <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3 ml-2">Back</a>
    </form>
</div>
@endsection
