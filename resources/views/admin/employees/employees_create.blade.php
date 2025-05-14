@extends('layouts.app')

@section('title', 'Create Employee')

@section('content')
<div class="container">
    <h2>Create Employee</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('employees.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="Fname" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Middle Name</label>
            <input type="text" name="Mname" class="form-control">
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="Lname" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Position</label>
            <select name="position_id" class="form-control" required>
                <option value="">Select Position</option>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}">{{ $position->position_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>User Account</label>
            <select name="user_id" class="form-control" required>
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->email }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('admin.employee') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
