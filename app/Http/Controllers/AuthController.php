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
use Throwable;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {

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

            if (!Auth::attempt($credentials)) {
                return back()->withErrors([
                    'login' => 'Credenciales inválidas.',
                ])->withInput();
            }

            $request->session()->regenerate();

            return redirect()->route('redirect');
        } catch (Throwable $e) {

            Log::error('Error al iniciar sesión: ' . $e->getMessage(), ['exception' => $e]);

            return back()->withErrors([
                'login' => 'Ocurrió un error al iniciar sesión. Intentalo más tarde'
            ])->withInput();
        }
    }

    public function register(Request $request)
    {
        try {

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
        } catch (Throwable $e) {

            Log::error('Error al registrar nuevo usuario: ' . $e->getMessage(), ['exception' => $e]);

            return back()->withErrors([
                'register' => 'Ocurrió un error al registrarse'
            ])->withInput();
        }
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
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
        try {
            $request->validate(
                ['email' => 'required|email:rfc,dns'],
                [
                    'email.required' => 'El correo es obligatorio.',
                    'email.email' => 'El correo no tiene un formato válido.',
                ]
            );

            $status = Password::sendResetLink(
                $request->only('email')
            );

            return back()->with('status', ($status));
        } catch (\Exception $e) {

            Log::error('Error enviando el correo de restablecimiento: ' . $e->getMessage(), ['exception' => $e]);

            return back()->withErrors([
                'error' => 'Error enviando el correo de restablecimiento.'
            ]);
        }
    }

    public function resetPasswordForm(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        try {

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

            return redirect()->route('login')->with('status', ($status));
        } catch (Throwable $e) {

            Log::error('Error al reestablecer contraseña: ' . $e->getMessage(), ['exception' => $e]);

            return back()->withErrors([
                'error' => 'Ocurrió un error al restablecer la contraseña'
            ]);
        }
    }
}
