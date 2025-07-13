<?php

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use App\Models\Staf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $tamus      = BukuTamu::limit(5)->get();
        $tamuToday  = BukuTamu::whereDate('created_at', Carbon::today())->count();
        $tamuAllCount  = BukuTamu::count();
        $stafsAll   = Staf::count();

        return view('dashboard.index', [
            'title'     => 'Dashboard',
            'tamus'     => $tamus,
            'tamuToday' => $tamuToday,
            'tamuAllCount' => $tamuAllCount,
            'stafsAll'  => $stafsAll
        ]);
    }
}
