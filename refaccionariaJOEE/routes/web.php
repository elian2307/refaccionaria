<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::redirect('/home', '/dash');

Route::middleware(['auth'])->group(function () {

    Route::get('/dash', function () {
        return view('dash.layout.main');
    });

    Route::get('/dash/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/dash/statics', [AdminController::class, 'statics']);
});

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dash/users', [AdminController::class, 'users']);
    Route::get('/dash/settings', [AdminController::class, 'settings']);

    Route::post('/dash/users/update/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/dash/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
});

Route::middleware(['auth', 'role:admin,vendedor,comprador'])->group(function () {

    Route::get('/dash/orders', [AdminController::class, 'orders']);
    Route::get('/dash/reviews', [AdminController::class, 'reviews']);
});

Route::middleware(['auth', 'role:admin,vendedor'])->group(function () {

    Route::post('/dash/orders/update/{id}', [AdminController::class, 'updateOrder'])->name('orders.update');

    Route::get('/dash/auctions', [AdminController::class, 'auctions']);
    Route::post('/dash/auctions/store', [AdminController::class, 'storeAuction'])->name('auctions.store');
    Route::post('/dash/auctions/update/{id}', [AdminController::class, 'updateAuction'])->name('auctions.update');
    Route::delete('/dash/auctions/delete/{id}', [AdminController::class, 'deleteAuction'])->name('auctions.delete');
});

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::delete('/dash/orders/delete/{id}', [AdminController::class, 'deleteOrder'])->name('orders.delete');
    Route::delete('/dash/reviews/delete/{id}', [AdminController::class, 'deleteReview'])->name('reviews.delete');
});

Route::middleware(['auth', 'role:admin,comprador'])->group(function () {

    Route::get('/dash/offers', [AdminController::class, 'offers']);
    Route::post('/dash/offers/store', [AdminController::class, 'storeOffer'])->name('offers.store');
    Route::post('/dash/offers/update/{id}', [AdminController::class, 'updateOffer'])->name('offers.update');
    Route::delete('/dash/offers/delete/{id}', [AdminController::class, 'deleteOffer'])->name('offers.delete');
});