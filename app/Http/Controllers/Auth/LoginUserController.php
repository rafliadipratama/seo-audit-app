<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginUserController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login-user');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(
            ['email' => $request->email, 'password' => $request->password, 'role' => 'user'],
            $request->filled('remember')
        )) {
            $request->session()->regenerate();
            return redirect()->intended('/user/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah, atau Anda bukan user.',
        ]);
    }
}
