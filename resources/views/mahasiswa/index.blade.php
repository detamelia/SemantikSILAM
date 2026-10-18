@extends('layouts.app')

@section('title', 'Daftar Mahasiswa - Sistem A')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Daftar Mahasiswa</h1>
            <p class="page-description">Kelola data master mahasiswa, enkripsi data pribadi, dan identitas unik NPM.</p>
        </div>
        <div>
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Mahasiswa
            </a>
        </div>
    </div>

    <!-- Filter & Pencarian Bar -->
    <div class="filter-bar">
        <form action="{{ route('mahasiswa.index') }}" method="GET" class="search-form">
            <div class="input-group">
                <input 
                    type="text" 
                    name="search" 
                    class="input-control" 
                    placeholder="Cari berdasarkan NPM atau Nama..." 
                    value="{{ request('search') }}"
                >
            </div>

            <div style="min-width: 180px;">
                <select name="prodi" class="input-control" onchange="this.form.submit()">
                    <option value="">Semua Program Studi</option>
                    @foreach ($daftarProdi as $p)
                        <option value="{{ $p }}" {{ request('prodi') == $p ? 'selected' : '' }}>
                            {{ $p }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-secondary">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Cari
            </button>

            @if(request('search') || request('prodi'))
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary" title="Reset Pencarian">
                    Reset
                </a>
            @endif
        </form>

        <div style="font-size: 0.88rem; color: var(--gray-text-sub); font-weight: 500;">
            Total: <strong>{{ $mahasiswas->total() }}</strong> mahasiswa terdaftar
        </div>
    </div>

    <!-- Tabel Data Mahasiswa -->
    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>NPM (ID Unik)</th>
                        <th>Nama Lengkap</th>
                        <th>Program Studi</th>
                        <th>Angkatan</th>
                        <th>Tanggal Lahir (Disamarkan)</th>
                        <th>Data Sensitif</th>
                        <th style="text-align: right; width: 170px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswas as $index => $mhs)
                        <tr>
                            <td style="color: var(--gray-text-sub);">
                                {{ $mahasiswas->firstItem() + $index }}
                            </td>
                            <td>
                                <span class="npm-badge">{{ $mhs->npm }}</span>
                            </td>
                            <td style="font-weight: 600; color: var(--dark);">
                                <a href="{{ route('mahasiswa.show', $mhs->id) }}">
                                    {{ $mhs->nama }}
                                </a>
                            </td>
                            <td>
                                <span class="pill-badge prodi">{{ $mhs->prodi }}</span>
                            </td>
                            <td>
                                <span class="pill-badge angkatan">{{ $mhs->angkatan }}</span>
                            </td>
                            <td>
                                <span class="pill-badge masked" title="Disamarkan ke tanggal 1 sesuai arahan tugas (tanggal asli tersimpan aman)">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right: 4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $mhs->tanggal_lahir_masked }}
                                </span>
                            </td>
                            <td>
                                <span class="pill-badge secure" title="Nama ibu kandung dienkripsi menggunakan Laravel AES-256">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="margin-right: 4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    Nama Ibu Terenkripsi
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <a href="{{ route('mahasiswa.show', $mhs->id) }}" class="btn btn-secondary btn-icon" title="Detail Mahasiswa">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('mahasiswa.edit', $mhs->id) }}" class="btn btn-secondary btn-icon" title="Ubah Data">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <button 
                                        type="button" 
                                        class="btn btn-secondary btn-icon" 
                                        style="color: var(--danger);" 
                                        title="Hapus Mahasiswa"
                                        onclick="confirmDelete('{{ route('mahasiswa.destroy', $mhs->id) }}', '{{ addslashes($mhs->nama) }}', '{{ $mhs->npm }}')"
                                    >
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: var(--gray-text-sub); padding: 3rem 1rem;">
                                <div style="font-size: 1.1rem; font-weight: 600; color: var(--dark); margin-bottom: 6px;">Tidak ada mahasiswa ditemukan</div>
                                <p style="font-size: 0.9rem;">
                                    @if(request('search') || request('prodi'))
                                        Coba ubah kata kunci pencarian atau reset filter.
                                    @else
                                        Silakan tambahkan data mahasiswa baru melalui tombol di atas atau jalankan seeder.
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $mahasiswas->links() }}
    </div>
@endsection
