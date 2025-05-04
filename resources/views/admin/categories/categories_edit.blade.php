@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="container">
    <h2>Edit Category</h2>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update Category</button>
    </form>
</div>
@endsection
