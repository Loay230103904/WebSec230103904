<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;



class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle user registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user); // Auto-login after registration

        return redirect()->route('home')->with('success', 'Registration successful!');
    }

    // Show the login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login request
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('home')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }


    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        // Check if old password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}
