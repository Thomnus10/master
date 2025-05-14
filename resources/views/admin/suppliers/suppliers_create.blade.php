@extends('layouts.app')

@section('title', 'Add Supplier')

@section('content')
    <div class="container">
        <h2>Add New Supplier</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('suppliers.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Supplier Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="contact">Contact Number</label>
                <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact') }}" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Save Supplier</button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary mt-3 ml-2">Cancel</a>
        </form>
    </div>
@endsection
