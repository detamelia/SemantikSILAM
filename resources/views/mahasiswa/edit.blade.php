@extends('layouts.app')

@section('title', 'Ubah Data Mahasiswa - Sistem A')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Ubah Data Mahasiswa</h1>
            <p class="page-description">Perbarui informasi mahasiswa: <strong>{{ $mahasiswa->nama }}</strong> ({{ $mahasiswa->npm }})</p>
        </div>
        <div>
            <a href="{{ route('mahasiswa.show', $mahasiswa->id) }}" class="btn btn-secondary">
                &larr; Kembali ke Detail
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; align-items: start;">
        <!-- Form Edit -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Perbarui Formulir Mahasiswa</div>
            </div>
            <div class="card-body">
                <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST">
                    @csrf
                    @method('PUT')

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
                                value="{{ old('npm', $mahasiswa->npm) }}"
                                required
                            >
                            <div class="form-hint">Identitas unik mahasiswa.</div>
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
                                min="2015" 
                                max="2030" 
                                value="{{ old('angkatan', $mahasiswa->angkatan) }}"
                                required
                            >
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
                                value="{{ old('nama', $mahasiswa->nama) }}"
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
                                    <option value="{{ $opt }}" {{ old('prodi', $mahasiswa->prodi) == $opt ? 'selected' : '' }}>
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
                                value="{{ old('tanggal_lahir', $mahasiswa->tanggal_lahir ? $mahasiswa->tanggal_lahir->format('Y-m-d') : '') }}"
                                required
                            >
                            <div class="form-hint">Tanggal lahir mahasiswa sesuai dokumen resmi.</div>
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
                                value="{{ old('nama_ibu', $mahasiswa->nama_ibu) }}"
                                required
                            >
                            <div class="form-hint">Data keluarga disimpan secara aman dan terenkripsi.</div>
                            @error('nama_ibu')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-top: 2rem; display: flex; gap: 12px; justify-content: flex-end;">
                        <a href="{{ route('mahasiswa.show', $mahasiswa->id) }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Tambahan -->
        <div class="card">
            <div class="card-header">
                <div class="card-title" style="font-size: 1rem;">Informasi Sinkronisasi</div>
            </div>
            <div class="card-body" style="font-size: 0.88rem;">
                <p style="color: var(--gray-text-sub); margin-bottom: 12px;">
                    Pembaruan data mahasiswa ini akan langsung diperbarui pada pangkalan data dan endpoint layanan verifikasi.
                </p>
                <div style="background: #f8fafc; border: 1px solid var(--gray-border); padding: 10px; border-radius: 8px;">
                    <div style="font-size: 0.75rem; text-transform: uppercase; color: var(--gray-text-sub); font-weight: 700;">Subject URI:</div>
                    <code style="font-size: 0.82rem; color: var(--primary); word-break: break-all;">{{ $mahasiswa->semantic_uri }}</code>
                </div>
            </div>
        </div>
    </div>
@endsection
