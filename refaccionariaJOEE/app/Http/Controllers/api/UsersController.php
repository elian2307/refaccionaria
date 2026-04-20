<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        if ($users->isEmpty()) {
            return response([
                'success' => false,
                'message' => 'No users found'
            ], 404);
        } else {
            return response([
                'success' => true,
                'users' => $users
            ], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response([
            'success' => false,
            'message' => 'Method not allowed for API'
        ], 405);
    }

    /**
     * Store a newly created resource in storage.
     */
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

        $validateData['password'] = Hash::make($validateData['password']);

        $user = User::create($validateData);

        if ($user) {
            return response([
                'success' => true,
                'message' => 'User created successfully',
                'user' => $user
            ], 201);
        } else {
            return response([
                'success' => false,
                'message' => 'User creation failed'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if ($user) {
            return response([
                'success' => true,
                'user' => $user
            ], 200);
        } else {
            return response([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response([
            'success' => false,
            'message' => 'Method not allowed for API'
        ], 405);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response([
                'success' => false,
                'message' => 'User not found'
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

        if (!empty($validateData['password'])) {
            $validateData['password'] = Hash::make($validateData['password']);
        } else {
            unset($validateData['password']);
        }

        $user->update($validateData);

        return response([
            'success' => true,
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }
        
        $user->delete();
        
        return response([
            'success' => true,
            'message' => 'User deleted successfully'
        ], 200);
    }
}
