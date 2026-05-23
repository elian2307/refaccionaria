<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistroUsuarioMail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Throwable;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|in:vendedor,comprador',
            'telefono' => 'required|string|max:20',
            'tipo_usuario' => 'required|in:taller,refaccionaria,flotilla,usuario',
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => $request->password,
            'rol' => $request->rol,
            'telefono' => $request->telefono,
            'reputacion' => 5.00,
            'fecha_registro' => now()->toDateString(),
            'puntos_gamificacion' => 0,
            'tipo_usuario' => $request->tipo_usuario,
        ]);

        $this->enviarCorreoSeguro($user->email, new RegistroUsuarioMail($user));

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Could not create token'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Invalid credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Could not create token'
            ], 500);
        }

        $user = JWTAuth::setToken($token)->toUser();

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user,
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ], 200);
    }

    public function logout()
    {
        try {
            auth('api')->logout();

            return response()->json([
                'success' => true,
                'msg' => 'Successfully logged out'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Failed to logout',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getUser()
    {
        try {
            $user = auth('api')->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'msg' => 'User not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Failed to fetch user profile',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            $user = Auth::guard('api')->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'msg' => 'User not found'
                ], 404);
            }

            $validated = $request->validate([
                'nombre' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
            ]);

            $user->update($validated);

            return response()->json([
                'success' => true,
                'user' => $user
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Failed to update user'
            ], 500);
        }
    }

    private function enviarCorreoSeguro(string $email, $mailable): void
    {
        try {
            Mail::to($email)->send($mailable);
        } catch (Throwable $e) {
            report($e);
        }
    }
}