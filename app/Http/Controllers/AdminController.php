<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function listUsers()
    {
        return view('admin.users.index', [
            'users' => User::where('role', '!=', 'admin')->paginate(10)
        ]);
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:user,admin'
        ]);

        $user->update($validated);
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
}