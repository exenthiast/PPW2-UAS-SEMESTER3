<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index() {
        $totalMale = Pegawai::where('gender', 'male')->count();
        $totalFemale = Pegawai::where('gender', 'female')->count();

        $topPekerjaan = Pekerjaan::withCount('pegawai')
                        ->orderBy('pegawai_count', 'desc')
                        ->take(5)
                        ->get();

        $labelPekerjaan = $topPekerjaan->pluck('nama');
        $dataPekerjaan = $topPekerjaan->pluck('pegawai_count');

        return view('index', compact('totalMale', 'totalFemale', 'labelPekerjaan', 'dataPekerjaan'));
    }
}
