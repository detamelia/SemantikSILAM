<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard utama Sistem Informasi Data Mahasiswa.
     */
    public function index()
    {
        // Hitung ringkasan statistik
        $totalMahasiswa = Mahasiswa::count();
        $totalProdi = Mahasiswa::distinct('prodi')->count('prodi');
        $totalAngkatan = Mahasiswa::distinct('angkatan')->count('angkatan');

        // Statistik jumlah mahasiswa per prodi
        $statistikProdi = Mahasiswa::select('prodi', DB::raw('count(*) as total'))
            ->groupBy('prodi')
            ->orderBy('total', 'desc')
            ->get();

        // 5 data mahasiswa terbaru
        $mahasiswaTerbaru = Mahasiswa::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalMahasiswa',
            'totalProdi',
            'totalAngkatan',
            'statistikProdi',
            'mahasiswaTerbaru'
        ));
    }
}
