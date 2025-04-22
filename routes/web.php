<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\TopupController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\PeminjamanController;

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

// Route::get('/', function () {
//     return redirect()->route('guest.dashboard');
// });

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [GuestController::class, 'index'])->name('guest.dashboard');

Route::get('/Books', [GuestController::class, 'indexBooks'])->name('guest.books');



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

    //Route Users Admin
    Route::prefix('users/admin')->group(function () {
        Route::get('/', [UsersController::class, 'indexAdmin'])->name('users.admin.index');
        Route::post('/store', [UsersController::class, 'storeAdmin'])->name('users.admin.store');
        Route::put('/{id}', [UsersController::class, 'storeAdmin'])->name('users.admin.update');
        Route::delete('/{id}', [UsersController::class, 'delete'])->name('users.admin.delete');
        Route::get('/invoice', [UsersController::class, 'invoiceAdmin'])->name('users.admin.invoice');
    });    

    //Route Users Supervisor
    Route::prefix('users/supervisor')->group(function () {
        Route::get('/', [UsersController::class, 'indexSupervisor'])->name('users.supervisor.index');
        Route::post('/store', [UsersController::class, 'storeSupervisor'])->name('users.supervisor.store');
        Route::put('/{id}', [UsersController::class, 'storeSupervisor'])->name('users.supervisor.update');
        Route::delete('/{id}', [UsersController::class, 'delete'])->name('users.supervisor.delete');
        Route::get('/invoice', [UsersController::class, 'invoiceSupervisor'])->name('users.supervisor.invoice');
    });    

    //Route Users Petugas
    Route::prefix('users/petugas')->group(function () {
        Route::get('/', [UsersController::class, 'indexPetugas'])->name('users.petugas.index');
        Route::post('/store', [UsersController::class, 'storePetugas'])->name('users.petugas.store');
        Route::put('/{id}', [UsersController::class, 'storePetugas'])->name('users.petugas.update');
        Route::delete('/{id}', [UsersController::class, 'delete'])->name('users.petugas.delete');
        Route::get('/invoice', [UsersController::class, 'invoicePetugas'])->name('users.petugas.invoice');
    });    

    // Route Member
    Route::prefix('Member')->name('Member.')->group(function () {
        Route::get('/', [MemberController::class, 'index'])->name('index');
        Route::post('/', [MemberController::class, 'store'])->name('store');
        Route::delete('/{id}', [MemberController::class, 'delete'])->name('delete');
        Route::get('/invoice', [MemberController::class, 'invoice'])->name('invoice');
        
        // Sudah ada sebelumnya:
        Route::get('/books', [BooksController::class, 'indexMember'])->name('Books.index');
        Route::get('/promo', [PromoController::class, 'indexMember'])->name('Promo.index');
        Route::get('/peminjaman', [MemberController::class, 'riwayatPeminjaman'])->name('Peminjaman.index');
        Route::get('/pengembalian', [MemberController::class, 'riwayatPengembalian'])->name('Pengembalian.index');
    });
    
    //Route Settings
    Route::get('/Settings', [SettingsController::class, 'index'])->name('Settings');
    Route::put('/Settings/update/{id}', [SettingsController::class, 'update'])->name('Settings.update');

    // Route Kategori
    Route::prefix('Kategori')->name('Kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::delete('/{id}', [KategoriController::class, 'delete'])->name('delete');
        Route::get('/invoice', [KategoriController::class, 'invoice'])->name('invoice');
    });

    // Route Author
    Route::prefix('Author')->name('Author.')->group(function () {
        Route::get('/', [AuthorController::class, 'index'])->name('index');
        Route::post('/', [AuthorController::class, 'store'])->name('store');
        Route::delete('/{id}', [AuthorController::class, 'delete'])->name('delete');
        Route::get('/invoice', [AuthorController::class, 'invoice'])->name('invoice');
    });

    // Route Publisher
    Route::prefix('Publisher')->name('Publisher.')->group(function () {
        Route::get('/', [PublisherController::class, 'index'])->name('index');
        Route::post('/', [PublisherController::class, 'store'])->name('store');
        Route::delete('/{id}', [PublisherController::class, 'delete'])->name('delete');
        Route::get('/invoice', [PublisherController::class, 'invoice'])->name('invoice');
    });

    // Route Books
    Route::prefix('Books')->group(function () {
        Route::get('/', [BooksController::class, 'indexBooks'])->name('Books.index');
        Route::get('/member', [BooksController::class, 'indexMember'])->name('Member.books.index');
    
        Route::post('/', [BooksController::class, 'storeBooks'])->name('Books.store');
    
        // Ganti {id} menjadi {kode_books} untuk konsisten
        Route::put('/{kode_books}', [BooksController::class, 'update'])->name('Books.update');
    
        Route::delete('/{kode_books}', [BooksController::class, 'delete'])->name('Books.delete');
    
        Route::get('/invoice', [BooksController::class, 'invoice'])->name('Books.invoice');
    });    

    // Top Up Route
    Route::prefix('Topup')->name('Topup.')->group(function () {
        Route::get('/', [TopupController::class, 'index'])->name('index');
        Route::get('/member', [TopupController::class, 'indexMember'])->name('member.index');
        Route::post('/proses', [TopupController::class, 'store'])->name('store');
        Route::put('/{kode_topups}/status', [TopupController::class, 'updateStatus'])->name('updateStatus'); // Perbaikan di sini
        Route::post('/invoice', [TopupController::class, 'invoiceTopup'])->name('invoice');
    });

    // Route Promo
    Route::prefix('Promo')->name('Promo.')->group(function () {
        Route::get('/', [PromoController::class, 'index'])->name('index');
        
        // Promo khusus member
        Route::get('/member', [PromoController::class, 'memberPromo'])->name('member.index');
        
        Route::post('/store', [PromoController::class, 'store'])->name('store');
        
        // Menggunakan route model binding
        Route::delete('/{kode_promo}', [PromoController::class, 'delete'])->name('delete');
        
        Route::get('/invoice', [PromoController::class, 'invoice'])->name('invoice');
    });


    Route::prefix('Peminjaman')->name('Peminjaman.')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('index');
        Route::get('/member', [PeminjamanController::class, 'indexMember'])->name('member.index');
        Route::post('/store/{kode_books}', [PeminjamanController::class, 'store'])->name('store');
        Route::put('/{id}', [PeminjamanController::class, 'update'])->name('update');
        Route::delete('/delete/{kode_books}', [PeminjamanController::class, 'destroy'])->name('delete');
        Route::get('/invoice', [PeminjamanController::class, 'invoice'])->name('invoice');
    });

    //Route Pengembalian
    Route::prefix('Pengembalian')->group(function () {
        Route::get('/', [UsersController::class, 'indexPengembalian'])->name('Pengembalian.index');
        Route::get('/member', [UsersController::class, 'indexPeminjaman'])->name('Member.peminjaman.index');
        Route::post('/store', [UsersController::class, 'storePengembalian'])->name('Pengembalian.store');
        Route::put('/{id}', [UsersController::class, 'storePengembalian'])->name('Pengembalian.update');
        Route::delete('/{id}', [UsersController::class, 'delete'])->name('Pengembalian.delete');
        Route::get('/invoice', [UsersController::class, 'invoice'])->name('Pengembalian.invoice');
    });

});