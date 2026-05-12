<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response([
            'success' => true,
            'users' => $users
        ], 200);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users',
            'email_verified_at' => 'nullable|date',
            'password' => 'required|string|min:6',
            'rol' => 'nullable|in:admin,vendedor,comprador',
            'tipo_usuario' => 'nullable|in:taller,refaccionaria,flotilla,admin,usuario',
            'id_fiscal' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'reputacion' => 'nullable|numeric',
            'is_premium' => 'nullable|boolean',
            'fecha_registro' => 'nullable|date',
            'foto_perfil' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $user = User::create($validateData);

        return response([
            'success' => true,
            'msg' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response([
                'success' => false,
                'msg' => 'User not found'
            ], 404);
        }

        return response([
            'success' => true,
            'user' => $user
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response([
                'success' => false,
                'msg' => 'User not found'
            ], 404);
        }

        $validateData = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'apellidos' => 'nullable|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,'.$id,
            'email_verified_at' => 'nullable|date',
            'password' => 'nullable|string|min:6',
            'rol' => 'nullable|in:admin,vendedor,comprador',
            'tipo_usuario' => 'nullable|in:taller,refaccionaria,flotilla,admin,usuario',
            'id_fiscal' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'reputacion' => 'nullable|numeric',
            'is_premium' => 'nullable|boolean',
            'fecha_registro' => 'nullable|date',
            'foto_perfil' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $user->update($validateData);

        return response([
            'success' => true,
            'msg' => 'User updated successfully',
            'user' => $user
        ], 200);
    }

    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response([
                'success' => false,
                'msg' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response([
            'success' => true,
            'msg' => 'User deleted successfully'
        ], 200);
    }
}