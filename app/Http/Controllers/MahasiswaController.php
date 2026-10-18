<?php

namespace App\Http\Controllers;

use App\Http\Requests\MahasiswaRequest;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa dengan fitur pencarian dan filter.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $prodiFilter = $request->query('prodi');

        $query = Mahasiswa::query();

        // Pencarian berdasarkan NPM atau Nama
        if (!empty($search)) {
            $query->search($search);
        }

        // Filter berdasarkan Program Studi
        if (!empty($prodiFilter)) {
            $query->where('prodi', $prodiFilter);
        }

        // Urutkan berdasarkan yang terbaru dengan pagination
        $mahasiswas = $query->latest()->paginate(10)->withQueryString();

        // Daftar program studi unik untuk dropdown filter
        $daftarProdi = Mahasiswa::distinct()->pluck('prodi')->filter()->sort();

        return view('mahasiswa.index', compact('mahasiswas', 'search', 'prodiFilter', 'daftarProdi'));
    }

    /**
     * Menampilkan form untuk menambahkan data mahasiswa baru.
     */
    public function create()
    {
        // Opsi rekomendasi program studi
        $prodiOptions = [
            'Informatika',
            'Sistem Informasi',
            'Teknologi Informasi',
            'Teknik Elektro',
            'Sains Data',
            'Teknik Komputer',
        ];

        return view('mahasiswa.create', compact('prodiOptions'));
    }

    /**
     * Menyimpan data mahasiswa baru ke database PostgreSQL.
     */
    public function store(MahasiswaRequest $request)
    {
        // Validasi lolos melalui MahasiswaRequest
        $validated = $request->validated();

        // Simpan data mahasiswa.
        // Nama ibu akan dienkripsi secara otomatis oleh Eloquent Cast 'encrypted'.
        // Tanggal lahir asli tersimpan aman di database.
        $mahasiswa = Mahasiswa::create($validated);

        return redirect()
            ->route('mahasiswa.index')
            ->with('success', "Data mahasiswa {$mahasiswa->nama} (NPM: {$mahasiswa->npm}) berhasil ditambahkan!");
    }

    /**
     * Menampilkan detail informasi mahasiswa.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        // Data payload yang akan diterima oleh Sistem B saat memanggil REST API
        $apiPreviewPayload = $mahasiswa->toSistemBApiPayload();

        return view('mahasiswa.show', compact('mahasiswa', 'apiPreviewPayload'));
    }

    /**
     * Menampilkan form edit data mahasiswa.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        $prodiOptions = [
            'Informatika',
            'Sistem Informasi',
            'Teknologi Informasi',
            'Teknik Elektro',
            'Sains Data',
            'Teknik Komputer',
        ];

        return view('mahasiswa.edit', compact('mahasiswa', 'prodiOptions'));
    }

    /**
     * Memperbarui data mahasiswa.
     */
    public function update(MahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validated();

        $mahasiswa->update($validated);

        return redirect()
            ->route('mahasiswa.show', $mahasiswa->id)
            ->with('success', "Data mahasiswa {$mahasiswa->nama} (NPM: {$mahasiswa->npm}) berhasil diperbarui!");
    }

    /**
     * Menghapus data mahasiswa dari database.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $nama = $mahasiswa->nama;
        $npm = $mahasiswa->npm;

        $mahasiswa->delete();

        return redirect()
            ->route('mahasiswa.index')
            ->with('success', "Data mahasiswa {$nama} (NPM: {$npm}) berhasil dihapus dari sistem.");
    }
}
