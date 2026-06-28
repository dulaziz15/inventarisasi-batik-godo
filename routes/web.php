<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InformationController;
use App\Http\Controllers\Admin\MotifController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/katalog', [PublicController::class, 'catalog'])->name('catalog');
Route::get('/katalog/{motif}', [PublicController::class, 'show'])->name('motifs.show');
Route::get('/tentang', [PublicController::class, 'about'])->name('about');
Route::get('/kontak', [PublicController::class, 'contact'])->name('contact');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function (): void {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/motifs/export', [MotifController::class, 'export'])->name('motifs.export');
        Route::resource('/motifs', MotifController::class)->except(['show']);
        Route::get('/informasi-umum', [InformationController::class, 'edit'])->name('information.edit');
        Route::put('/informasi-umum', [InformationController::class, 'update'])->name('information.update');
        Route::get('/password', [AccountController::class, 'editPassword'])->name('account.password');
        Route::put('/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
    });
