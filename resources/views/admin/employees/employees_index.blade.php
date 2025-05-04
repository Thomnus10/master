{{-- @extends('layouts.app')

@section('title', 'Employees')

@section('content')
    <h2>Employee List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->Fname }} {{ $employee->Lname }}</td>
                    <td>{{ $employee->position->name ?? 'N/A' }}</td>
                    <td>{{ $employee->user->email ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.employees.employee_edit', $employee->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form method="POST" action="{{ route('admin.employee.destroy', $employee->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection --}}
