<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        return view('dash.layout.main'); 
    }

    private function renderView($view, $data = []) {
    if (request()->ajax()) {
        return view('dash.sections.' . $view, $data);
    }
    return view('dash.layout.main', $data);
    }

    public function dashboard() {
    return $this->renderView('dash');
    }

    public function statics() {
    return $this->renderView('stats');
    }

    public function users() {
    return $this->renderView('users', ['users' => User::all()]);
    }

    public function orders() {
    return $this->renderView('orders');
    }

    public function offers() {
    return $this->renderView('offers');
    }
    
    public function auctions() {
    return $this->renderView('auctions');
    }

    public function reviews() {
    return $this->renderView('reviews');
    }

    public function settings() {
    return $this->renderView('settings');
    }


    public function updateUser(Request $request, $id) {
    try {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'tipo_usuario' => 'required|in:taller,refaccionaria,flotilla,admin,usuario',
            'id_fiscal' => 'required|string|unique:users,id_fiscal,' . $id,
            'telefono' => 'required|string',
            'reputacion' => 'numeric|min:0|max:5',
        ]);

        $user->nombre = $request->nombre;
        $user->email = $request->email;
        $user->tipo_usuario = $request->tipo_usuario;
        $user->id_fiscal = $request->id_fiscal;
        $user->telefono = $request->telefono;
        $user->reputacion = $request->reputacion;
        
        $user->is_premium = $request->has('is_premium');

        $user->save();

        return response()->json([
            'success' => true, 
            'message' => 'User updated successfully!']);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
    }
    public function deleteUser($id) {
    try {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}


}
