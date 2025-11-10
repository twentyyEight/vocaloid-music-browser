<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credential)) {
            return back()->withErrors([
                'login' => 'Las credenciales no coinciden con nuestros registros.',
            ])->withInput();
        }

        return redirect()->route('redirect');
    }

    public function register(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|unique:users,name|min:4',
            'email' => 'required|unique:users,email|email|email:rfc,dns',
            'password' => 'required|min:8'
        ]);

        $user = User::Create($validation);
        Auth::login($user);

        return redirect()->route('redirect');
    }

    public function redirection()
    {
        if (!Auth::check()) {
            return redirect()->route('home');
        }

        if (Auth::user()->role == 1) {
            return redirect()->route('dashboard');
        }

        if (Auth::user()->role == 0) {
            return redirect()->route('profile');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
