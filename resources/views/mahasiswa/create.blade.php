@extends('layouts.app')

@section('title', 'Tambah Mahasiswa Baru - Sistem A')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Data Mahasiswa</h1>
            <p class="page-description">Daftarkan mahasiswa baru ke Sistem A. Data sensitif akan dienkripsi secara otomatis.</p>
        </div>
        <div>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; align-items: start;">
        <!-- Form Input -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Formulir Identitas Mahasiswa</div>
            </div>
            <div class="card-body">
                <form action="{{ route('mahasiswa.store') }}" method="POST">
                    @csrf

                    <div class="form-grid">
                        <!-- NPM -->
                        <div class="form-group">
                            <label class="form-label" for="npm">
                                NPM (Nomor Pokok Mahasiswa) <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="npm" 
                                name="npm" 
                                class="input-control" 
                                placeholder="Contoh: 22081010001" 
                                value="{{ old('npm') }}"
                                required
                            >
                            <div class="form-hint">Digunakan sebagai identitas unik utama (Unique Identifier).</div>
                            @error('npm')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Angkatan -->
                        <div class="form-group">
                            <label class="form-label" for="angkatan">
                                Tahun Angkatan <span class="required">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="angkatan" 
                                name="angkatan" 
                                class="input-control" 
                                placeholder="Contoh: 2023" 
                                min="2015" 
                                max="2030" 
                                value="{{ old('angkatan', date('Y')) }}"
                                required
                            >
                            <div class="form-hint">Tahun mahasiswa pertama kali terdaftar.</div>
                            @error('angkatan')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="form-group form-full">
                            <label class="form-label" for="nama">
                                Nama Lengkap Mahasiswa <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="nama" 
                                name="nama" 
                                class="input-control" 
                                placeholder="Masukkan nama lengkap sesuai identitas" 
                                value="{{ old('nama') }}"
                                required
                            >
                            @error('nama')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Program Studi -->
                        <div class="form-group form-full">
                            <label class="form-label" for="prodi">
                                Program Studi <span class="required">*</span>
                            </label>
                            <select id="prodi" name="prodi" class="input-control" required>
                                <option value="">-- Pilih Program Studi --</option>
                                @foreach($prodiOptions as $opt)
                                    <option value="{{ $opt }}" {{ old('prodi') == $opt ? 'selected' : '' }}>
                                        {{ $opt }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prodi')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tanggal Lahir Asli -->
                        <div class="form-group">
                            <label class="form-label" for="tanggal_lahir">
                                Tanggal Lahir Asli <span class="required">*</span>
                            </label>
                            <input 
                                type="date" 
                                id="tanggal_lahir" 
                                name="tanggal_lahir" 
                                class="input-control" 
                                value="{{ old('tanggal_lahir') }}"
                                required
                            >
                            <div class="form-hint">Tanggal lahir mahasiswa sesuai dokumen kependudukan.</div>
                            @error('tanggal_lahir')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Ibu Kandung -->
                        <div class="form-group">
                            <label class="form-label" for="nama_ibu">
                                Nama Ibu Kandung <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="nama_ibu" 
                                name="nama_ibu" 
                                class="input-control" 
                                placeholder="Nama ibu kandung" 
                                value="{{ old('nama_ibu') }}"
                                required
                            >
                            <div class="form-hint">Data keluarga disimpan secara aman dan terenkripsi.</div>
                            @error('nama_ibu')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-top: 2rem; display: flex; gap: 12px; justify-content: flex-end;">
                        <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            Simpan Mahasiswa
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Panel Petunjuk Pengisian -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 1rem;">Panduan Pengisian</div>
                </div>
                <div class="card-body" style="font-size: 0.88rem; line-height: 1.6;">
                    <div style="margin-bottom: 1rem;">
                        <strong style="color: var(--dark);">1. Nomor Pokok Mahasiswa</strong>
                        <p style="color: var(--gray-text-sub); margin-top: 4px;">
                            Pastikan NPM sesuai dengan kartu identitas mahasiswa resmi dan belum terdaftar sebelumnya.
                        </p>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <strong style="color: var(--dark);">2. Program Studi & Angkatan</strong>
                        <p style="color: var(--gray-text-sub); margin-top: 4px;">
                            Pilih program studi dan tahun masuk akademik mahasiswa yang bersangkutan.
                        </p>
                    </div>

                    <div>
                        <strong style="color: var(--dark);">3. Keamanan Data</strong>
                        <p style="color: var(--gray-text-sub); margin-top: 4px;">
                            Data keluarga disimpan secara aman dengan proteksi enkripsi pada pangkalan data terpusat.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
