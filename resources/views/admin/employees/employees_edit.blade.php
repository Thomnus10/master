@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
<div class="container">
    <h2>Edit Employee</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('employee.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="Fname" class="form-control" value="{{ $employee->Fname }}" required>
        </div>

        <div class="mb-3">
            <label>Middle Name</label>
            <input type="text" name="Mname" class="form-control" value="{{ $employee->Mname }}">
        </div>

        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="Lname" class="form-control" value="{{ $employee->Lname }}" required>
        </div>

        <div class="mb-3">
            <label>Position</label>
            <select name="position_id" class="form-control" required>
                @foreach($positions as $position)
                    <option value="{{ $position->id }}" {{ $employee->position_id == $position->id ? 'selected' : '' }}>
                        {{ $position->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>User Account</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $employee->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->email }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.employee') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
