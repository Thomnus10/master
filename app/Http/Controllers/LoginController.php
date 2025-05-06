<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show Login Form
    public function showLoginForm()
    {
        return view('index'); // Adjust view name if needed
    }

    // Handle Login
    public function login(Request $request)
    {
        // Validate the input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Get credentials from the request
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        // Attempt login
        if (Auth::attempt($credentials)) {
            // Check the user's role and redirect accordingly
            $user = Auth::user();
            if ($user->role_id == '1') {
                return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
            } elseif ($user->role_id == '2') {
                return redirect()->route('cashier.index'); // Redirect to cashier dashboard
            }
        } else {
            return back()->withErrors(['login_error' => 'Invalid credentials!']);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();  // Log out the authenticated user
        $request->session()->invalidate();  // Invalidate the session
        $request->session()->regenerateToken();  // Regenerate the CSRF token

        return redirect('/');  // Redirect to the login page or your desired route
    }
}
