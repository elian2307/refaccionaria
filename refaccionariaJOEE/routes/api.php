<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UsersController;
use App\Http\Controllers\api\DireccionesController;
use App\Http\Controllers\api\SubastasController;
use App\Http\Controllers\api\OfertasController;
use App\Http\Controllers\api\PedidosController;
use App\Http\Controllers\api\ResenasController;
use App\Http\Controllers\api\ImgSubastasController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\GamificacionController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas públicas
Route::get('/subasta', [SubastasController::class, 'index']);
Route::get('/subasta/{id}', [SubastasController::class, 'show']);

Route::middleware('jwt')->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::put('/user', [AuthController::class, 'updateUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/gamificacion', [GamificacionController::class, 'show']);

    Route::resource('users', UsersController::class);
    Route::resource('direccion', DireccionesController::class);
    Route::resource('subasta', SubastasController::class)->except(['index']);
    Route::resource('oferta', OfertasController::class);
    Route::resource('pedido', PedidosController::class);
    Route::resource('resena', ResenasController::class);
    Route::resource('imgSubasta', ImgSubastasController::class);
});