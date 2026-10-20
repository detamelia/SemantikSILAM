<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdiController extends Controller
{
    /**
     * Menampilkan daftar program studi beserta statistik mahasiswa dan info akreditasi.
     */
    public function index()
    {
        // Data program studi universitas
        $prodiMaster = [
            [
                'kode' => 'IF-55201',
                'nama' => 'Informatika',
                'jenjang' => 'S1 (Sarjana)',
                'akreditasi' => 'Unggul',
                'fakultas' => 'Fakultas Ilmu Komputer',
                'kaprodi' => 'Dr. Eng. Hendra Kurniawan, S.T., M.Kom.',
                'ruang' => 'Gedung Rektorat Lt. 3',
                'deskripsi' => 'Fokus pada pengembangan rekayasa perangkat lunak, kecerdasan buatan, komputasi awan, dan Semantic Web.',
            ],
            [
                'kode' => 'SI-57201',
                'nama' => 'Sistem Informasi',
                'jenjang' => 'S1 (Sarjana)',
                'akreditasi' => 'Unggul',
                'fakultas' => 'Fakultas Ilmu Komputer',
                'kaprodi' => 'Dr. Rina Damayanti, S.Kom., M.T.',
                'ruang' => 'Gedung Rektorat Lt. 3',
                'deskripsi' => 'Fokus pada integrasi proses bisnis, manajemen sistem informasi enterprise, tata kelola TI, dan audit sistem.',
            ],
            [
                'kode' => 'SD-55202',
                'nama' => 'Sains Data',
                'jenjang' => 'S1 (Sarjana)',
                'akreditasi' => 'Baik Sekali',
                'fakultas' => 'Fakultas Ilmu Komputer',
                'kaprodi' => 'Bambang Prasetyo, M.Sc., Ph.D.',
                'ruang' => 'Gedung Sains Terpadu Lt. 2',
                'deskripsi' => 'Mempelajari pengolahan big data, pemodelan statistik lanjutan, machine learning, dan knowledge representation.',
            ],
            [
                'kode' => 'TI-55203',
                'nama' => 'Teknologi Informasi',
                'jenjang' => 'S1 (Sarjana)',
                'akreditasi' => 'Baik Sekali',
                'fakultas' => 'Fakultas Ilmu Komputer',
                'kaprodi' => 'Agus Priyono, S.Kom., M.Cs.',
                'ruang' => 'Gedung Lab Komputer Lt. 2',
                'deskripsi' => 'Pengelolaan infrastruktur jaringan komputer, keamanan siber, administrasi sistem, dan teknologi internet.',
            ],
            [
                'kode' => 'TE-20201',
                'nama' => 'Teknik Elektro',
                'jenjang' => 'S1 (Sarjana)',
                'akreditasi' => 'Baik Sekali',
                'fakultas' => 'Fakultas Teknik',
                'kaprodi' => 'Ir. Dedi Irawan, M.T., IPM.',
                'ruang' => 'Gedung Laboratorium Teknik Lt. 1',
                'deskripsi' => 'Bidang sistem kendali otomatis, robotika, sistem tenaga listrik, dan instrumentasi digital.',
            ],
            [
                'kode' => 'TK-56201',
                'nama' => 'Teknik Komputer',
                'jenjang' => 'S1 (Sarjana)',
                'akreditasi' => 'Baik Sekali',
                'fakultas' => 'Fakultas Ilmu Komputer',
                'kaprodi' => 'Fajar Santoso, S.T., M.Eng.',
                'ruang' => 'Gedung Lab Hardware Lt. 1',
                'deskripsi' => 'Perancangan sistem tertanam (embedded systems), Internet of Things (IoT), dan arsitektur perangkat keras komputer.',
            ],
        ];

        // Hitung jumlah mahasiswa per prodi dari database PostgreSQL
        $jumlahPerProdi = Mahasiswa::select('prodi', DB::raw('count(*) as total'))
            ->groupBy('prodi')
            ->pluck('total', 'prodi')
            ->toArray();

        // Gabungkan data
        $daftarProdi = array_map(function ($prodi) use ($jumlahPerProdi) {
            $prodi['total_mahasiswa'] = $jumlahPerProdi[$prodi['nama']] ?? 0;
            return $prodi;
        }, $prodiMaster);

        $totalSemuaMahasiswa = Mahasiswa::count();

        return view('prodi.index', compact('daftarProdi', 'totalSemuaMahasiswa'));
    }
}
