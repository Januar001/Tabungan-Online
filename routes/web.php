<?php

use App\Livewire\CekPengajuan;
use App\Livewire\Admin\Dashboard;

// --- CONTROLLER & KOMPONEN YANG DIGUNAKAN ---
// Controller untuk Halaman Publik Anda
use App\Livewire\RiwayatPengajuan;
// Komponen Livewire untuk Admin Panel
use App\Livewire\Admin\PengajuanList;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\UserManagement;
use App\Livewire\Admin\PengajuanDetail;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HalamanFormTabungan;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. ROUTE UNTUK HALAMAN PUBLIK (FORM ANDA)
// =========================================================================
// Ini adalah halaman yang bisa diakses siapa saja tanpa perlu login.
Route::get('/', [HalamanFormTabungan::class, 'index'])->name('halaman.index');
// Route::get('/form', [HalamanFormTabungan::class, 'form'])->name('halaman.form');
Route::get('/cek-pengajuan', CekPengajuan::class)->name('pengajuan.cek');


// =========================================================================
// 2. ROUTE BAWAAN BREEZE UNTUK USER YANG SUDAH LOGIN
// =========================================================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', \App\Http\Middleware\RedirectIfAdmin::class])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/form', [HalamanFormTabungan::class, 'form'])->name('halaman.form');
    Route::get('/riwayat-pengajuan', RiwayatPengajuan::class)->name('pengajuan.riwayat');
});


// =========================================================================
// 3. ROUTE KHUSUS UNTUK ADMIN PANEL (LIVEWIRE)
// =========================================================================
// Route ini hanya bisa diakses oleh user yang sudah login DAN berstatus admin.
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/pengajuan', PengajuanList::class)->name('pengajuan.index');
    Route::get('/pengajuan/{pengajuan}', PengajuanDetail::class)->name('pengajuan.detail');
    Route::get('/users', UserManagement::class)
        ->name('users.index') // <-- Nama ini digabung dengan 'admin.' menjadi 'admin.users.index'
        ->middleware('superadmin'); 

    // PINDAHKAN ROUTE DOKUMEN KE SINI
    Route::get('/dokumen/{path}', [\App\Http\Controllers\DokumenController::class, 'show'])
        ->name('dokumen.show') // Nama akhirnya akan menjadi 'admin.dokumen.show'
        ->where('path', '.*');
});


// =========================================================================
// 4. ROUTE OTENTIKASI (LOGIN, REGISTER, DLL) DARI BREEZE
// =========================================================================
require __DIR__.'/auth.php';