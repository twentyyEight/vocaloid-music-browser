<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function signup()
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
        }
    }

    public function registercheck(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = USER::Create($validation);
        Auth::login($user);

        return redirect()->route('redirect');
    }

    public function redirectUser() 
    {
        if (Auth::check() && Auth::user()->role==1) {
            return view('admin');
        }
        else if (Auth::check() && Auth::user()->role==0) {
            return view('user');
        }
        else {
            return redirect()->route('login');
        }    
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
