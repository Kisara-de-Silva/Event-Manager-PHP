<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.dashboard', [
            'user' => auth()->user(),
            'recentEvents' => auth()->user()->events()
                ->latest()
                ->take(3)
                ->get()
        ]);
    }
}
