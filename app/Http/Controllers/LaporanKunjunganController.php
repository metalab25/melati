<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanKunjunganController extends Controller
{
    public function index()
    {
        $laporanKunjungan = BukuTamu::latest()->paginate(10);

        return view('dashboard.laporan.index', [
            'title' => 'Laporan Kunjungan',
            'laporanKunjungan' => $laporanKunjungan
        ]);
    }

    public function cetak(Request $request)
    {
        $jenis = $request->jenis;
        $title = 'Laporan Kunjungan ' . ucfirst($jenis);

        if ($jenis == 'mingguan') {
            $minggu = $request->minggu;
            $startDate = Carbon::parse($minggu)->startOfWeek();
            $endDate = Carbon::parse($minggu)->endOfWeek();

            $laporanKunjungan = BukuTamu::whereBetween('tgl_kunjungan', [$startDate, $endDate])
                ->orderBy('tgl_kunjungan')
                ->get();

            $title .= ' (' . $startDate->translatedFormat('d F Y') . ' - ' . $endDate->translatedFormat('d F Y') . ')';
        } else {
            $bulan = $request->bulan;
            $startDate = Carbon::parse($bulan)->startOfMonth();
            $endDate = Carbon::parse($bulan)->endOfMonth();

            $laporanKunjungan = BukuTamu::whereBetween('tgl_kunjungan', [$startDate, $endDate])
                ->orderBy('tgl_kunjungan')
                ->get();

            $title .= ' ' . $startDate->translatedFormat('F Y');
        }

        return view('dashboard.laporan.cetak', [
            'title' => $title,
            'laporanKunjungan' => $laporanKunjungan,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }
}
