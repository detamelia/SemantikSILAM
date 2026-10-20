<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    /**
     * Menampilkan analisis dan statistik pangkalan data mahasiswa.
     */
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();

        // Statistik per Angkatan
        $statistikAngkatan = Mahasiswa::select('angkatan', DB::raw('count(*) as total'))
            ->groupBy('angkatan')
            ->orderBy('angkatan', 'asc')
            ->get();

        // Statistik per Program Studi
        $statistikProdi = Mahasiswa::select('prodi', DB::raw('count(*) as total'))
            ->groupBy('prodi')
            ->orderBy('total', 'desc')
            ->get();

        // Rekapitulasi Matriks Prodi x Angkatan
        $semuaAngkatan = Mahasiswa::distinct()->pluck('angkatan')->sort()->values();
        $semuaProdi = Mahasiswa::distinct()->pluck('prodi')->sort()->values();

        $matrix = [];
        foreach ($semuaProdi as $p) {
            $matrix[$p] = [];
            foreach ($semuaAngkatan as $a) {
                $matrix[$p][$a] = Mahasiswa::where('prodi', $p)->where('angkatan', $a)->count();
            }
        }

        return view('statistik.index', compact(
            'totalMahasiswa',
            'statistikAngkatan',
            'statistikProdi',
            'semuaAngkatan',
            'semuaProdi',
            'matrix'
        ));
    }
}
