<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Rute login hanya untuk pengguna yang belum login
Route::get('/login', [AuthController::class, 'index'])
    ->name('login')
    ->middleware(['guest', 'prevent-back-to-login']);
Route::post('/login-proses', [AuthController::class, 'login_proses'])->name('login-proses');

// Rute logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute setelah login
Route::middleware(['auth'])->group(function () {
    Route::get('/Dashboard', function () {
        return view('dashboard.index');
    })->name('Dashboard');

    //Route Users
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UsersController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UsersController::class, 'delete'])->name('users.delete');
    Route::get('/users/invoice', [UsersController::class, 'invoice'])->name('users.invoice');
    
    //Route Settings
    Route::get('/Settings', [SettingsController::class, 'index'])->name('Settings');
    Route::put('/Settings/update/{id}', [SettingsController::class, 'update'])->name('Settings.update');

    //Route Merk
    Route::get('/Merk', [MerkController::class, 'index'])->name('Merk.index');
    Route::post('/Merk', [MerkController::class, 'store'])->name('Merk.store');
    Route::delete('/Merk/{id}', [MerkController::class, 'delete'])->name('Merk.delete');
    Route::get('/Merk/invoice', [MerkController::class, 'invoice'])->name('Merk.invoice');

    //Route Kategori
    Route::get('/Kategori', [KategoriController::class, 'index'])->name('Kategori.index');
    Route::post('/Kategori', [KategoriController::class, 'store'])->name('Kategori.store');
    Route::delete('/Kategori/{id}', [KategoriController::class, 'delete'])->name('Kategori.delete');
    Route::get('/Kategori/invoice', [KategoriController::class, 'invoice'])->name('Kategori.invoice');

    //Route Ruangan
    Route::get('/Ruangan', [RuanganController::class, 'index'])->name('Ruangan.index');
    Route::get('/Ruangan/create', [RuanganController::class, 'create'])->name('Ruangan.create');
    Route::post('/Ruangan', [RuanganController::class, 'store'])->name('Ruangan.store');
    Route::get('/Ruangan/{id}/edit', [RuanganController::class, 'edit'])->name('Ruangan.edit');
    Route::put('/Ruangan/{id}', [RuanganController::class, 'update'])->name('Ruangan.update');
    Route::delete('/Ruangan/{id}', [RuanganController::class, 'delete'])->name('Ruangan.delete');
    Route::get('/Ruangan/invoice', [RuanganController::class, 'invoice'])->name('Ruangan.invoice');

    //Route Barang
    Route::get('/Barang', [BarangController::class, 'index'])->name('Barang.index');
    Route::get('/Barang/create', [BarangController::class, 'create'])->name('Barang.create');
    Route::post('/Barang', [BarangController::class, 'store'])->name('Barang.store');
    Route::get('/Barang/{id}/edit', [BarangController::class, 'edit'])->name('Barang.edit');
    Route::put('/Barang/{id}', [BarangController::class, 'update'])->name('Barang.update');
    Route::delete('/Barang/{id}', [BarangController::class, 'delete'])->name('Barang.delete');
    Route::get('/Barang/invoice', [BarangController::class, 'invoice'])->name('Barang.invoice');

    //Route Meja
    Route::get('/Meja', [MejaController::class, 'index'])->name('Meja.index');
    Route::get('/Meja/create', [MejaController::class, 'create'])->name('Meja.create');
    Route::post('/Meja', [MejaController::class, 'store'])->name('Meja.store');
    Route::get('/Meja/{id}/edit', [MejaController::class, 'edit'])->name('Meja.edit');
    Route::put('/Meja/{id}', [MejaController::class, 'update'])->name('Meja.update');
    Route::delete('/Meja/{id}', [MejaController::class, 'delete'])->name('Meja.delete');
    Route::get('/Meja/invoice', [MejaController::class, 'invoice'])->name('Meja.invoice');

    //Route Pengajuan
    Route::get('/Pengajuan', [PengajuanController::class, 'index'])->name('Pengajuan.index');
    Route::get('/Pengajuan/create', [PengajuanController::class, 'create'])->name('Pengajuan.create');
    Route::post('/Pengajuan', [PengajuanController::class, 'store'])->name('Pengajuan.store');
    Route::post('/Pengajuan/approve/{id}', [PengajuanController::class, 'approve'])->name('Pengajuan.approve');
    Route::post('/Pengajuan/reject/{id}', [PengajuanController::class, 'reject'])->name('Pengajuan.reject');
    Route::get('/Pengajuan/invoice', [PengajuanController::class, 'invoice'])->name('Pengajuan.invoice');

    //Route Pengaduan
    Route::get('/Pengaduan', [PengaduanController::class, 'index'])->name('Pengaduan.index');
    Route::get('/Pengaduan/create', [PengaduanController::class, 'create'])->name('Pengaduan.create');
    Route::post('/Pengaduan', [PengaduanController::class, 'store'])->name('Pengaduan.store');
    Route::post('/Pengaduan/approve/{id}', [PengaduanController::class, 'approve'])->name('Pengaduan.approve');
    Route::post('/Pengaduan/reject/{id}', [PengaduanController::class, 'reject'])->name('Pengaduan.reject');
    Route::get('/Pengaduan/invoice', [PengaduanController::class, 'invoice'])->name('Pengaduan.invoice');

});