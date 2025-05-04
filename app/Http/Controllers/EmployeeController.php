<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
{
    $employees = Employee::with(['position', 'user'])->get();
    return view('admin.employee', compact('employees'));
}


    public function create()
    {
        $positions = Position::all();
        $users = User::all();
        return view('admin.employees.employees_create', compact('positions', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Fname' => 'required|string|max:255',
            'Mname' => 'nullable|string|max:255',
            'Lname' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,id',
            'user_id' => 'required|exists:users,id',
        ]);

        Employee::create($validated);

        return redirect()->route('admin.employee')->with('success', 'Employee created successfully.');
    }

    public function edit(Employee $employee)
    {
        $positions = Position::all();
        $users = User::all();
        return view('admin.employees.employees_edit', compact('employee', 'positions', 'users'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'Fname' => 'required|string|max:255',
            'Mname' => 'nullable|string|max:255',
            'Lname' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $employee->update($validated);

        return redirect()->route('admin.employee')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('admin.employee')->with('success', 'Employee deleted successfully.');
    }
}
