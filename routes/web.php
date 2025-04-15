<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\PublisherController;
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

// Rute Register
Route::get('/register', [AuthController::class, 'register'])->name('register.index');
Route::post('/register/store', [AuthController::class, 'registerStore'])->name('register.store');


// Rute logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute setelah login
Route::middleware(['auth'])->group(function () {
    Route::get('/Dashboard', function () {
        return view('dashboard.index');
    })->name('Dashboard');

    //Route Users
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::post('/users/store', [UsersController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UsersController::class, 'store'])->name('users.update');
    Route::delete('/users/{id}', [UsersController::class, 'delete'])->name('users.delete');
    Route::get('/users/invoice', [UsersController::class, 'invoice'])->name('users.invoice');
    
    //Route Settings
    Route::get('/Settings', [SettingsController::class, 'index'])->name('Settings');
    Route::put('/Settings/update/{id}', [SettingsController::class, 'update'])->name('Settings.update');

    //Route Kategori
    Route::get('/Kategori', [KategoriController::class, 'index'])->name('Kategori.index');
    Route::post('/Kategori', [KategoriController::class, 'store'])->name('Kategori.store');
    Route::delete('/Kategori/{id}', [KategoriController::class, 'delete'])->name('Kategori.delete');
    Route::get('/Kategori/invoice', [KategoriController::class, 'invoice'])->name('Kategori.invoice');

    //Route Author
    Route::get('/Author', [AuthorController::class, 'index'])->name('Author.index');
    Route::post('/Author', [AuthorController::class, 'store'])->name('Author.store');
    Route::delete('/Author/{id}', [AuthorController::class, 'delete'])->name('Author.delete');
    Route::get('/Author/invoice', [AuthorController::class, 'invoice'])->name('Author.invoice');

    //Route Publisher
    Route::get('/Publisher', [PublisherController::class, 'index'])->name('Publisher.index');
    Route::post('/Publisher', [PublisherController::class, 'store'])->name('Publisher.store');
    Route::delete('/Publisher/{id}', [PublisherController::class, 'delete'])->name('Publisher.delete');
    Route::get('/Publisher/invoice', [PublisherController::class, 'invoice'])->name('Publisher.invoice');

    //Route Member
    Route::get('/Member', [MemberController::class, 'index'])->name('Member.index');
    Route::post('/Member', [MemberController::class, 'store'])->name('Member.store');
    Route::delete('/Member/{id}', [MemberController::class, 'delete'])->name('Member.delete');
    Route::get('/Member/invoice', [MemberController::class, 'invoice'])->name('Member.invoice');

    //Route Promo
    Route::get('/Promo', [PromoController::class, 'index'])->name('Promo.index');
    Route::post('/Promo', [PromoController::class, 'store'])->name('Promo.store');
    Route::delete('/Promo/{id}', [PromoController::class, 'delete'])->name('Promo.delete');
    Route::get('/Promo/invoice', [PromoController::class, 'invoice'])->name('Promo.invoice');

});