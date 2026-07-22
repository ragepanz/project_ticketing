<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PesertaController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/peserta');

Route::prefix('peserta')->name('peserta.')->group(function () {
    Route::get('/', [PesertaController::class, 'index'])->name('index');
    Route::get('/cek-pesanan', [PesertaController::class, 'searchOrder'])->name('search-order');
    Route::post('/cek-pesanan', [PesertaController::class, 'findOrder'])->name('find-order');
    Route::get('/{event}', [PesertaController::class, 'detail'])->name('detail');
    Route::get('/{event}/daftar', [PesertaController::class, 'form'])->name('form');
    Route::post('/{event}/daftar', [PesertaController::class, 'storeForm'])->name('store-form')->middleware('throttle:10,1');
    Route::get('/{event}/review', [PesertaController::class, 'review'])->name('review');
    Route::get('/{event}/bayar', [PesertaController::class, 'payment'])->name('payment');
    Route::post('/{event}/confirm', [PesertaController::class, 'confirm'])->name('confirm')->middleware('throttle:5,1');
    Route::get('/{event}/tiket', [PesertaController::class, 'ticket'])->name('ticket');
});

Route::prefix('client')->name('client.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\ClientController::class, 'login'])->name('login');
    Route::post('/login', [\App\Http\Controllers\ClientController::class, 'authenticate'])->name('authenticate')->middleware('throttle:5,1');
    Route::get('/register', [\App\Http\Controllers\ClientController::class, 'register'])->name('register');
    Route::post('/register', [\App\Http\Controllers\ClientController::class, 'storeRegister'])->name('store-register')->middleware('throttle:3,1');
    Route::get('/logout', [\App\Http\Controllers\ClientController::class, 'logout'])->name('logout');

    Route::middleware('client.auth')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\ClientController::class, 'dashboard'])->name('dashboard');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('authenticate')->middleware('throttle:5,1');
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/events', [AdminController::class, 'events'])->name('events');
        Route::post('/events', [AdminController::class, 'storeEvent'])->name('events.store');
        Route::put('/events/{event}', [AdminController::class, 'updateEvent'])->name('events.update');
        Route::delete('/events/{event}', [AdminController::class, 'destroyEvent'])->name('events.destroy');
        Route::get('/participants', [AdminController::class, 'participants'])->name('participants');
        Route::get('/scan', [AdminController::class, 'scan'])->name('scan');
        Route::post('/scan/process', [AdminController::class, 'processScan'])->name('scan.process');
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/export-csv', [AdminController::class, 'exportCsv'])->name('export-csv');

        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

        Route::get('/password', [AdminController::class, 'passwordForm'])->name('password.form');
        Route::put('/password', [AdminController::class, 'updatePassword'])->name('password.update');
    });
});
