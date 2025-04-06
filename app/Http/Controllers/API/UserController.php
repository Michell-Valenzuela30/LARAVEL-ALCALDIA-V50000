<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('role');

        // Filtrar por rol si se proporciona
        if ($request->has('role')) {
            $query->whereHas('role', function ($q) use ($request) {
                $q->where('name', $request->input('role'));
            });
        }

        $perPage = $request->input('per_page', 15);
        $users = $query->paginate($perPage);

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'role' => 'required|string|exists:roles,name',
        ]);

        // Verificar que solo un usuario root pueda crear otro usuario root
        if ($request->input('role') === 'root' && auth()->user()->role->name !== 'root') {
            return response()->json(['message' => 'Solo un usuario root puede crear un usuario root'], 403);
        }

        // Obtener el rol
        $role = Role::where('name', $request->input('role'))->firstOrFail();

        // Crear el usuario
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'direccion' => $request->input('direccion'),
            'telefono' => $request->input('telefono'),
            'role_id' => $role->id,
        ]);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'direccion' => $user->direccion,
            'telefono' => $user->telefono,
            'role' => $user->role ? $user->role->name : null, // Asegurar que el rol se envía como un string
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'role' => 'sometimes|required|string|exists:roles,name',
        ]);

        $currentUser = auth()->user();

        // Si se intenta actualizar el rol...
        if ($request->has('role')) {
            $newRole = $request->input('role');
            // Verificar que solo un usuario root pueda asignar el rol "root"
            if ($newRole === 'root' && $currentUser->role->name !== 'root') {
                return response()->json(['message' => 'Solo un usuario root puede asignar el rol root'], 403);
            }
            // Además, si el usuario a actualizar ya es root y se está intentando modificar, permitir solo si el usuario autenticado es root
            if ($user->isRoot() && $currentUser->role->name !== 'root') {
                return response()->json(['message' => 'Solo un usuario root puede modificar un usuario root'], 403);
            }
        }

        // Actualizar datos básicos
        if ($request->has('name')) {
            $user->name = $request->input('name');
        }

        if ($request->has('email')) {
            $user->email = $request->input('email');
        }

        // Solo actualizar la contraseña si se ha proporcionado un valor no vacío
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        if ($request->has('direccion')) {
            $user->direccion = $request->input('direccion');
        }

        if ($request->has('telefono')) {
            $user->telefono = $request->input('telefono');
        }

        // Actualizar rol si se envía el campo
        if ($request->has('role')) {
            $role = Role::where('name', $request->input('role'))->firstOrFail();
            $user->role_id = $role->id;
        }

        $user->save();

        return response()->json($user->load('role'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $currentUser = auth()->user();

        // Evitar eliminar el propio usuario autenticado
        if ($currentUser->id === $user->id) {
            return response()->json(['message' => 'No puedes eliminar tu propio usuario'], 400);
        }

        // Si el usuario a eliminar es root, solo lo puede eliminar otro usuario root
        if ($user->isRoot() && $currentUser->role->name !== 'root') {
            return response()->json(['message' => 'Solo un usuario root puede eliminar un usuario root'], 403);
        }

        // Evitar eliminar el último usuario root
        if (
            $user->isRoot() && User::whereHas('role', function ($q) {
                $q->where('name', 'root');
            })->count() <= 1
        ) {
            return response()->json(['message' => 'No puedes eliminar el último usuario root'], 400);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }
}
