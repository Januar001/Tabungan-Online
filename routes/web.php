<?php

use App\Http\Controllers\HalamanFormTabungan;
use Illuminate\Support\Facades\Route;

Route::get('/', [HalamanFormTabungan::class, 'index'])
    ->name('halaman.form.tabungan');

Route::get('/form', [HalamanFormTabungan::class, 'form'])
    ->name('halaman.form.tabungan');