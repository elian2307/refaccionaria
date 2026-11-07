<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\img_subasta;

class ImgSubastasController extends Controller
{
    public function index()
    {
        $imagenes = img_subasta::all();

        return response([
            'success' => true,
            'imagenes' => $imagenes
        ], 200);
    }

    public function create()
    {
        return response([
            'success' => true,
            'msg' => 'Form for creating image (API usually does not need this)'
        ], 200);
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'subasta_id' => 'required|exists:subastas,id',
            'url' => 'nullable|string|max:255'
        ]);

        $img = img_subasta::create($validateData);

        return response([
            'success' => true,
            'msg' => 'Imagen agregada correctamente',
            'img' => $img
        ], 201);
    }

    public function show($id)
    {
        $img = img_subasta::find($id);

        if (!$img) {
            return response([
                'success' => false,
                'msg' => 'Imagen no encontrada'
            ], 404);
        }

        return response([
            'success' => true,
            'img' => $img
        ], 200);
    }

    public function edit($id)
    {
        $img = img_subasta::find($id);

        if (!$img) {
            return response([
                'success' => false,
                'msg' => 'Imagen no encontrada'
            ], 404);
        }

        return response([
            'success' => true,
            'msg' => 'Form for editing image',
            'img' => $img
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $img = img_subasta::find($id);

        if (!$img) {
            return response([
                'success' => false,
                'msg' => 'Imagen no encontrada'
            ], 404);
        }

        $validateData = $request->validate([
            'url' => 'nullable|string|max:255'
        ]);

        $img->update($validateData);

        return response([
            'success' => true,
            'msg' => 'Imagen actualizada',
            'img' => $img
        ], 200);
    }

    public function destroy($id)
    {
        $img = img_subasta::find($id);

        if (!$img) {
            return response([
                'success' => false,
                'msg' => 'Imagen no encontrada'
            ], 404);
        }

        $img->delete();

        return response([
            'success' => true,
            'msg' => 'Imagen eliminada'
        ], 200);
    }
}