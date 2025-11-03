<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- CONTROLLER ---
use App\Http\Controllers\PageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminBeritaController;
use App\Http\Controllers\AdminAparaturController;
use App\Http\Controllers\AdminVillageProfileController; 
use App\Http\Controllers\AdminGaleriController;
use App\Http\Controllers\AuthController; // <-- 1. TAMBAHKAN INI

// --- RUTE HALAMAN PUBLIK ---

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/profil-desa', [PageController::class, 'profil'])->name('profil');
Route::get('/struktur', [PageController::class, 'struktur'])->name('struktur'); 
Route::get('/galeri', [PageController::class, 'galeri'])->name('galeri');
Route::get('/berita', [PageController::class, 'berita'])->name('berita');
Route::get('/berita/{post}', [PageController::class, 'showBerita'])->name('berita.show');

// --- RUTE AUTENTIKASI (LOGIN/LOGOUT) ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- RUTE ADMIN (GABUNGAN) ---

// 2. TAMBAHKAN ->middleware('auth') UNTUK MELINDUNGI SEMUA RUTE ADMIN
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('berita', AdminBeritaController::class)->parameters(['berita' => 'berita']);
    Route::resource('aparatur', AdminAparaturController::class);
    Route::get('/profile', [AdminVillageProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminVillageProfileController::class, 'update'])->name('profile.update');
    Route::get('/galeri', [AdminGaleriController::class, 'index'])->name('galeri.index');
    Route::post('/galeri', [AdminGaleriController::class, 'store'])->name('galeri.store');
    Route::delete('/galeri/{galeri}', [AdminGaleriController::class, 'destroy'])->name('galeri.destroy');

});

