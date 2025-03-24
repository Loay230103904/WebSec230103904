<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the users (Admins only).
     */
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') {  // ✅ تحقق بدون ميدل وير
            return abort(403, 'Unauthorized action.');
        }

        $query = User::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

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
        if (Auth::user()->role !== 'admin') {
            return abort(403, 'Unauthorized action.');
        }

        return view('users.create');
    }

    /**
     * Store a newly created user in the database (Admins only).
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,employee,user',
            'credit' => 'nullable|numeric|min:0', // ✅ New: Validate credit

        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, 
            'credit' => $request->credit ?? 0, // ✅ New: Set default credit to 0

        ]);

        return redirect()->route('users.index')->with('success', 'User added successfully.');
    }

    /**
     * Display the specified user (Self or Admins only).
     */
    public function show(User $user)
    {
        if (Auth::user()->id !== $user->id && Auth::user()->role !== 'admin') {
            return abort(403, 'Unauthorized action.');
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $authUser = Auth::user();

        if ($authUser->id !== $user->id && $authUser->role !== 'admin' && 
            !($authUser->role === 'employee' && $user->role !== 'admin')) {
            return abort(403, 'Unauthorized action.');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in the database.
     */
    public function update(Request $request, User $user)
    {
        $authUser = Auth::user();

        if ($authUser->id !== $user->id && $authUser->role !== 'admin' && 
            !($authUser->role === 'employee' && $user->role !== 'admin')) {
            return abort(403, 'Unauthorized action.');
        }

        if ($authUser->role === 'admin') {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:6|confirmed',
                'credit' => 'nullable|numeric|min:0', // ✅ New: Validate credit

            ]);
        } elseif ($authUser->role === 'employee' || $authUser->id === $user->id) {
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
        if (Auth::user()->role !== 'admin') {
            return abort(403, 'Unauthorized action.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function profile()
{
    $user = Auth::user();
    return view('users.profile', compact('user'));
}

public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:6|confirmed',
        'credit' => $request->credit ?? $user->credit, // ✅ New: Update credit

    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('users.profile')->with('success', 'Profile updated successfully.');
}


public function addCredit(Request $request, User $user)
{
    // Only Admins and Employees can add credit
    if (!Auth::user()->isAdmin() && !Auth::user()->isEmployee()) {
        return abort(403, 'Unauthorized action.');
    }

    // Validate request
    $request->validate([
        'amount' => 'required|numeric|min:1',
    ]);

    // Add credit to user account
    $user->credit += $request->amount;
    $user->save();

    return redirect()->back()->with('success', 'Credit added successfully!');
}


}
