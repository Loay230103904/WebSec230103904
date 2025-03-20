<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller
{
    /**
     * Display a listing of the users (Admins only).
     */
    public function index(Request $request)
    {
        // Only admins with 'view_users' permission can access
        if (!Auth::user()->can('view_users')) {
            return abort(403, 'Unauthorized action.');
        }

        $query = User::query();

        // Filter by name if provided
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Filter by email if provided
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        $users->appends($request->all());

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user (Admins only).
     */
    public function create()
    {
        // Only admins can create users
        if (!Auth::user()->can('edit_users')) {
            return abort(403, 'Unauthorized action.');
        }

        return view('users.create');
    }

    /**
     * Store a newly created user in the database (Admins only).
     */
    public function store(Request $request)
    {
        // Only admins can store new users
        if (!Auth::user()->can('edit_users')) {
            return abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,employee,user',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign the selected role using Spatie
        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User added successfully.');
    }

    /**
     * Display the specified user (Self or Admins only).
     */
    public function show(User $user)
    {
        // Allow the user to see their own profile or admins to see all users
        if (!Auth::user()->can('view_users') && Auth::user()->id !== $user->id) {
            return abort(403, 'Unauthorized action.');
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     * Admins can edit any user, Employees can edit general info, and Users can edit themselves.
     */
    public function edit(User $user)
    {
        $authUser = Auth::user();

        // Admins can edit anyone
        // Employees can edit users as long as they are not admins
        // Regular users can only edit themselves
        if ($authUser->id !== $user->id && !$authUser->can('edit_users') && !($authUser->hasRole('employee') && !$user->hasRole('admin'))) {
            return abort(403, 'Unauthorized action.');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in the database.
     * Admins can update everything, Employees can update general info, Users can update their profile only.
     */
    public function update(Request $request, User $user)
    {
        $authUser = Auth::user();

        // Check if the user has the right permissions
        if ($authUser->id !== $user->id && !$authUser->can('edit_users') && !($authUser->hasRole('employee') && !$user->hasRole('admin'))) {
            return abort(403, 'Unauthorized action.');
        }

        // Validation rules based on role
        if ($authUser->can('edit_users')) {
            // Admin: Can update everything
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:6|confirmed',
            ]);
        } elseif ($authUser->hasRole('employee')) {
            // Employee: Can only update name
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
        } elseif ($authUser->id === $user->id) {
            // Regular user: Can only update their own name
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
        } else {
            abort(403);
        }

        $user->name = $request->name;
        if ($request->filled('email')) {
            $user->email = $request->email;
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from the database (Admins only).
     */
    public function destroy(User $user)
    {
        // Only admins can delete users
        if (!Auth::user()->can('delete_users')) {
            return abort(403, 'Unauthorized action.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
