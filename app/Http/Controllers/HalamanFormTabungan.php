<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HalamanFormTabungan extends Controller
{
    public function index()
    {
        return view('halaman_form_tabungan');
    }
}
