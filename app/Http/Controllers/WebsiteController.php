<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use App\Models\Staf;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index(Request $request)
    {
        $stafs = Staf::orderBy('nama')->get();

        return view('website.index', [
            'title' => 'Formulir Buku Tamu',
            'stafs' => $stafs,
        ]);
    }
}
