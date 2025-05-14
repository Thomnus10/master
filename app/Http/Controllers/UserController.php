<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::all();
        return view('admin.user', compact('users'));
    }

    // ✅ Show user creation form
    public function create()
    {
        return view('admin.users.users_create');
    }

    
    public function store(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:15', 
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'role_id' => 'required|in:1,2', // Validate role_id
    ]);

    $user = User::create([
        'username' => $request->username, 
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $request->role_id, // ✅ Save role
    ]);

    return redirect()->route('admin.user')->with('success', 'User added successfully!');
}



    
    public function edit(User $user)
    {
        return view('admin.users.users_edit', compact('user'));
    }

    
    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));

        return redirect()->route('admin.user')->with('success', 'User updated successfully!');
    }

    
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user')->with('success', 'User deleted successfully!');
    }
}
