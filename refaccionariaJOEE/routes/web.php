<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/signup', function () {
    return view('signup');
});

Route::get('/auth', function () {
    return view('php.auth');
});

Route::get('/dash', function () {
    return view('dash.layout.main');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dash/dashboard', [AdminController::class, 'dashboard']);
Route::get('/dash/statics', [AdminController::class, 'statics']);
Route::get('/dash/users', [AdminController::class, 'users']);
Route::get('/dash/orders', [AdminController::class, 'orders']);
Route::get('/dash/offers', [AdminController::class, 'offers']);
Route::get('/dash/auctions', [AdminController::class, 'auctions']);
Route::get('/dash/reviews', [AdminController::class, 'reviews']);
Route::get('/dash/settings', [AdminController::class, 'settings']);

Route::post('/dash/users/update/{id}', [AdminController::class, 'updateUser'])->name('users.update');
Route::delete('/dash/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');

Route::post('/dash/orders/update/{id}', [AdminController::class, 'updateOrder'])->name('orders.update');
Route::delete('/dash/orders/delete/{id}', [AdminController::class, 'deleteOrder'])->name('orders.delete');

Route::delete('/dash/reviews/delete/{id}', [AdminController::class, 'deleteReview'])->name('reviews.delete');
