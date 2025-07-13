<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use Illuminate\Http\Request;

class LaporanKunjunganController extends Controller
{
    public function index()
    {
        $laporanKunjungan = BukuTamu::latest()->paginate(10);

        return view('dashboard.laporan.index', [
            'title'             => 'Laporan Kunjung',
            'laporanKunjungan'  => $laporanKunjungan
        ]);
    }
}
