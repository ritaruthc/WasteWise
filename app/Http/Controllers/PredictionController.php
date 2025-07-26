<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    public function predict(Request $request)
    {
        $image = $request->file('image');
        // Kirim gambar ke API Python Anda
        $prediction = $this->sendToAPI($image);
        return view('upload', ['prediction' => $prediction]);
    }

    private function sendToAPI($image)
    {
        // Implementasi pengiriman gambar ke API Python Anda
        // dan mengembalikan hasilnya
    }
}


