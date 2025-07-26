<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KlasifikasiController extends Controller
{
    public function index()
    {
        return view('klasifikasi');
    }
}