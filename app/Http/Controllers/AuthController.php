<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function logincheck(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credential)) {
            return redirect()->route('redirect');
        } else {
            return back()->withErrors([
                'login' => 'Las credenciales no coinciden con nuestros registros.',
            ])->withInput();
        }
    }

    public function registercheck(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|unique:users,name|min:4',
            'email' => 'required|unique:users,email|email|email:rfc,dns',
            'password' => 'required|min:8'
        ]);

        $user = User::Create($validation);
        Auth::login($user);

        return redirect()->route('redirection');
    }

    public function redirection()
    {
        if (Auth::check() && Auth::user()->role == 1) {
            return redirect()->route('admin');
        } else if (Auth::check() && Auth::user()->role == 0) {
            return redirect()->route('user');
        } else {
            return redirect()->route('login');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
