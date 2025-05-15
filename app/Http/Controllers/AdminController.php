<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalEvents = \App\Models\Event::count();
        
        return view('admin.dashboard', compact('totalUsers', 'totalEvents'));
    }

    public function listUsers()
    {
        $users = User::where('role', '!=', 'admin')->paginate(10);
        return view('admin.users.index', compact('users'));
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
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }
}