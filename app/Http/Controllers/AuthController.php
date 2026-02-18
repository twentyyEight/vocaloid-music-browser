<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                'email.required' => 'El correo es obligatorio.',
                'password.required' => 'La contraseña es obligatoria.',
            ]
        );

        $user = User::where('email', $credentials['email'])->first();

        if (!Auth::attempt($credentials) || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'login' => 'Credenciales invalidas.',
            ])->withInput();
        }

        return redirect()->route('redirect');
    }

    public function register(Request $request)
    {
        $validation = $request->validate(
            [
                'name' => 'required|unique:users,name|min:4',
                'email' => 'required|email:rfc,dns|unique:users,email',
                'password' => 'required|min:8'
            ],
            [
                'name.required' => 'El nombre es obligatorio.',
                'name.unique' => 'Este nombre ya está registrado.',
                'name.min' => 'El nombre debe tener al menos 4 caracteres.',

                'email.required' => 'El correo es obligatorio.',
                'email.email' => 'El correo no tiene un formato válido.',
                'email.unique' => 'Este correo ya está registrado.',

                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener mínimo 8 caracteres.',
            ]
        );

        $validation['password'] = Hash::make($validation['password']);

        $user = User::Create($validation);

        // event(new Registered($user));

        Auth::login($user);

        return redirect()->route('redirect');
    }

    public function redirection()
    {
        if (Auth::user()->role == 1) {
            return redirect()->route('dashboard');
        }

        if (Auth::user()->role == 0) {

            $userId = Auth::id();
            return redirect()->route('profile', $userId);
        }

        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('redirect');
    }

    public function sendEmailVerificationLink(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        try {

            $status = Password::sendResetLink(
                $request->only('email')
            );
        } catch (\Exception $e) {
            Log::error('Error sending password reset link: ' . $e->getMessage(), ['exception' => $e]);

            return back()->withErrors([
                'email' => 'Error enviando el correo de restablecimiento. Comprueba la configuración de mail y los logs.'
            ]);
        }

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', ($status))
            : back()->withErrors(['email' => ($status)]);
    }

    public function resetPasswordForm(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
