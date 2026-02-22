<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            if (!Auth::user()->role == 1) {

                $userId = Auth::id();
                return redirect()->route('profile', $userId);
            }

            $users = User::select('id', 'name', 'email', 'role', 'created_at', 'updated_at')->get();
            
            return view('dashboard.index', compact('users'));
        } catch (Throwable $e) {

            Log::error('Error al acceder al dashboard: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('home')->with(['error' => 'Error al acceder al dashboard']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate(
                [
                    'email' => 'required|email|unique:users,email,' . $id,
                    'name' => 'required|unique:users,name,' . $id . '|min:4',
                    'role' => 'required|in:0,1'
                ],
                [
                    'email.required' => 'El correo es obligatorio.',
                    'email.email' => 'El correo no tiene un formato válido.',
                    'email.unique' => 'Este correo ya está registrado.',

                    'name.required' => 'El nombre es obligatorio.',
                    'name.unique' => 'Este nombre ya está registrado.',
                    'name.min' => 'El nombre debe tener al menos 4 caracteres.',

                    'role.required' => 'El rol es obligatorio',
                    'role.in' => 'El rol seleccionado no es válido.',
                ]
            );

            User::where('id', '=', $id)->update($validated);

            return back()->with('error', 'No se pudo actualizar el usuario');

            //return back()->with('success', 'Usuario actualizado correctamente.');
        } catch (Throwable $e) {

            Log::error('Error al actualizar usuario: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'No se pudo actualizar el usuario');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            User::destroy($id);
            return back()->with('success', 'Usuario eliminado correctamente.');

        } catch (Throwable $e) {

            Log::error('Error al eliminar usuario: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'No se pudo eliminar el usuario');
        }
    }
}
