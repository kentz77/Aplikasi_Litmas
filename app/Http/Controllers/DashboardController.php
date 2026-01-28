<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSurat  = 120;
        $suratMasuk  = 80;
        $suratKeluar = 40;

        return view('dashboard', compact(
            'totalSurat',
            'suratMasuk',
            'suratKeluar'
        ));
    }
}
