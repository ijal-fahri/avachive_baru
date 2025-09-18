<?php

namespace App\Http\Controllers\pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomePelangganController extends Controller
{
    public function index()
    {
        return view ('pelanggan.home');
    }
}
