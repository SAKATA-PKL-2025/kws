<?php

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\PublicController;
use Illuminate\Support\Facades\Route;

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

// Halaman Publik Silsilah Keluarga
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/tentang', [PublicController::class, 'about'])->name('about');
Route::get('/galeri', [PublicController::class, 'gallery'])->name('gallery');
Route::get('/cari-anggota', [PublicController::class, 'search'])->name('search.members');
Route::get('/kebijakan-privasi', function () {
    return view('public.privacy');
})->name('privacy');

// Route lama (bisa dihapus jika tidak dipakai)
// Route::get('/', [IndexController::class, 'index'])->name('index');

Route::prefix('/product')->name('product.')->controller(ProductController::class)->group(function () {
    Route::get('', 'index')->name('index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
