<?php

use App\Http\Controllers\Area\BarangController;
use App\Http\Controllers\Area\DashboardController;
use App\Http\Controllers\Area\PesananController;
use App\Http\Controllers\Area\ProfilController;
use App\Http\Controllers\Area\UserController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guest'])->group(
    function () {
        Route::get('/', [LoginController::class, 'index'])->name('login');
        Route::post('/auth', [LoginController::class, 'auth']);
    }
);


Route::group(['middleware' => ['auth', 'preventBackHistory']], function () {

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/pesanan', [PesananController::class, 'pesanan']);
    Route::post('/pesanan/tambah', [PesananController::class, 'tambah']);
    Route::post('/pesanan/edit', [PesananController::class, 'edit']);

    Route::get('/permintaan', [PesananController::class, 'permintaan']);
    Route::get('/riwayat', [PesananController::class, 'riwayat']);

    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user/tambah', [UserController::class, 'tambah']);
    Route::post('/user/edit', [UserController::class, 'edit']);
    Route::post('/user/hapus', [UserController::class, 'hapus']);

    Route::get('/barang', [BarangController::class, 'index']);
    Route::post('/barang/tambah', [BarangController::class, 'tambah']);
    Route::post('/barang/edit', [BarangController::class, 'edit']);
    Route::post('/barang/hapus', [BarangController::class, 'hapus']);

    Route::get('/profil', [ProfilController::class, 'index']);
    Route::post('/profil/edit', [ProfilController::class, 'edit']);
});
