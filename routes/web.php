<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/izin', function () {
    return view('izin');
});

Route::get('/telat', function () {
    return view('telat');
});

Route::get('/checkin', function () {
    return view('checkin'); 
});

Route::get('/checkout', function () {
    return view('checkout'); 
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/tutorial', function () {
    return view('tutorial');
});
// Route::get('/welcome', function () {
//     //echo "Welcome tho Sonic";
//     return view('hello');
// });

// Route::get('/form', function () {
//     //echo "Welcome tho Sonic";
//     return view('form');
// });

// Route::get('/profile/{username}', [MainController::class, 'ProfilePage']);

// Route::get('home', [MainController::class, 'HomePage']);

Route::prefix('admin')->group(function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/presensi', [AdminController::class, 'presensi'])->name('admin.presensi');
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::get('/register', [AdminController::class, 'register'])->name('admin.register');
});
