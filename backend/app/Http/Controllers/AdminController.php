<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\pedido;
use App\Models\resena;
use App\Models\oferta;
use App\Models\subasta;
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
        $user = auth()->user();
        if ($user->rol === 'admin') {
            $orders = pedido::all();
        } else {
            $subastaIds = subasta::where('user_id', $user->id)->pluck('id');
            $ofertaIds = oferta::where('proveedor_id', $user->id)->pluck('id');
            $orders = pedido::whereIn('subasta_id', $subastaIds)
                            ->orWhereIn('oferta_id', $ofertaIds)
                            ->get();
        }
        return $this->renderView('orders', ['orders' => $orders]);
    }

    public function offers() {
    return $this->renderView('offers', [
        'offers' => oferta::all(),
        'users' => User::all(),
        'auctions' => subasta::all()
    ]);
}
    
    public function auctions() {
    return $this->renderView('auctions', [
        'auctions' => subasta::all(),
        'users' => User::all()
    ]);
}

    public function reviews() {
    return $this->renderView('reviews', ['reviews' => resena::all()]);
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


    public function updateOrder(Request $request, $id) {
    try {
        $order = pedido::findOrFail($id);

        $validated = $request->validate([
            'estado_pago' => 'required|in:pendiente,pagado,reembolsado',
            'estado_envio' => 'required|in:pendiente,enviado,entregado',
            'numero_rastreo' => 'nullable|string|max:255',
        ]);

        $order->estado_pago = $request->estado_pago;
        $order->estado_envio = $request->estado_envio;
        if ($request->has('numero_rastreo')) {
            $order->numero_rastreo = $request->numero_rastreo;
        }

        $order->save();

        return response()->json([
            'success' => true, 
            'message' => 'Order updated successfully!']);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
    }

    public function deleteOrder($id) {
    try {
        $order = pedido::findOrFail($id);
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
    }

    public function deleteReview($id) {
    try {
        $review = resena::findOrFail($id);
        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
    }
    public function storeOffer(Request $request) {
    try {
        $validated = $request->validate([
            'subasta_id' => 'required|exists:subastas,id',
            'proveedor_id' => 'required|exists:users,id',
            'precio_ofertado' => 'required|numeric|min:0',
            'dias_entrega' => 'required|integer|min:0',
            'condicion_pieza' => 'required|in:nueva,usada,reconstruida',
            'meses_garantia' => 'required|integer|min:0',
            'es_aceptada' => 'required|boolean',
            'fecha_oferta' => 'required|date',
        ]);

        oferta::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Offer created successfully!'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function updateOffer(Request $request, $id) {
        try {
            $offer = oferta::findOrFail($id);

            $validated = $request->validate([
                'subasta_id' => 'required|exists:subastas,id',
                'proveedor_id' => 'required|exists:users,id',
                'precio_ofertado' => 'required|numeric|min:0',
                'dias_entrega' => 'required|integer|min:0',
                'condicion_pieza' => 'required|in:nueva,usada,reconstruida',
                'meses_garantia' => 'required|integer|min:0',
                'es_aceptada' => 'required|boolean',
                'fecha_oferta' => 'required|date',
            ]);

            $offer->subasta_id = $request->subasta_id;
            $offer->proveedor_id = $request->proveedor_id;
            $offer->precio_ofertado = $request->precio_ofertado;
            $offer->dias_entrega = $request->dias_entrega;
            $offer->condicion_pieza = $request->condicion_pieza;
            $offer->meses_garantia = $request->meses_garantia;
            $offer->es_aceptada = $request->es_aceptada;
            $offer->fecha_oferta = $request->fecha_oferta;

            $offer->save();

            return response()->json([
                'success' => true,
                'message' => 'Offer updated successfully!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteOffer($id) {
        try {
            $offer = oferta::findOrFail($id);
            $offer->delete();

            return response()->json([
                'success' => true,
                'message' => 'Offer deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
        }
        public function storeAuction(Request $request) {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'marca_vehiculo' => 'required|string|max:255',
                'modelo_vehiculo' => 'required|string|max:255',
                'anio_vehiculo' => 'required|string|max:255',
                'nombre_refaccion' => 'required|string|max:255',
                'descripcion_problema' => 'required|string|max:255',
                'urgencia' => 'required|in:baja,media,alta',
                'estado' => 'required|in:abierta,cerrada,cancelada,finalizada',
                'fecha_expiracion' => 'nullable|date',
            ]);

            subasta::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Auction created successfully!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateAuction(Request $request, $id) {
        try {
            $auction = subasta::findOrFail($id);

            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'marca_vehiculo' => 'required|string|max:255',
                'modelo_vehiculo' => 'required|string|max:255',
                'anio_vehiculo' => 'required|string|max:255',
                'nombre_refaccion' => 'required|string|max:255',
                'descripcion_problema' => 'required|string|max:255',
                'urgencia' => 'required|in:baja,media,alta',
                'estado' => 'required|in:abierta,cerrada,cancelada,finalizada',
                'fecha_expiracion' => 'nullable|date',
            ]);

            $auction->user_id = $request->user_id;
            $auction->marca_vehiculo = $request->marca_vehiculo;
            $auction->modelo_vehiculo = $request->modelo_vehiculo;
            $auction->anio_vehiculo = $request->anio_vehiculo;
            $auction->nombre_refaccion = $request->nombre_refaccion;
            $auction->descripcion_problema = $request->descripcion_problema;
            $auction->urgencia = $request->urgencia;
            $auction->estado = $request->estado;
            $auction->fecha_expiracion = $request->fecha_expiracion;

            $auction->save();

            return response()->json([
                'success' => true,
                'message' => 'Auction updated successfully!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteAuction($id) {
        try {
            $auction = subasta::findOrFail($id);
            $auction->delete();

            return response()->json([
                'success' => true,
                'message' => 'Auction deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
