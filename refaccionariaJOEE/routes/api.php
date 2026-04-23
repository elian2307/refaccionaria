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

Route::resource('users', UsersController::class);
Route::resource('direccion', DireccionesController::class);
Route::resource('subasta', SubastasController::class);
Route::resource('oferta', OfertasController::class);
Route::resource('pedido', PedidosController::class);
Route::resource('resena', ResenasController::class);
Route::resource('imgSubasta', ImgSubastasController::class);