<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileViewController extends Controller
{
    public function show()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'current_password' => 'nullable|required_with:password|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Verificar contraseña actual si se quiere cambiar la contraseña
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'La contraseña actual no es correcta.',
                ]);
            }
        }

        // Actualizar datos básicos
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->direccion = $validated['direccion'] ?? $user->direccion;
        $user->telefono = $validated['telefono'] ?? $user->telefono;

        // Actualizar contraseña solo si se proporciona
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('status', 'Perfil actualizado correctamente');
    }
}
