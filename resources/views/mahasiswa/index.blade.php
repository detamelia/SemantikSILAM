@extends('layouts.app')

@section('title', 'Daftar Mahasiswa - Portal Mahasiswa')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Pangkalan Data Mahasiswa</h1>
            <p class="page-description">Kelola informasi data induk mahasiswa, verifikasi identitas, dan administrasi akademik.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('prodi.index') }}" class="btn btn-secondary">
                Direktori Prodi
            </a>
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
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
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
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
                        <th>Mahasiswa</th>
                        <th>NPM</th>
                        <th>Program Studi</th>
                        <th>Angkatan</th>
                        <th>Tanggal Lahir</th>
                        <th style="text-align: right; width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mahasiswas as $index => $mhs)
                        @php
                            $colorIdx = ($mahasiswas->firstItem() + $index) % 6;
                            $inisial = strtoupper(substr($mhs->nama, 0, 1));
                        @endphp
                        <tr>
                            <td style="color: var(--gray-text-sub);">
                                {{ $mahasiswas->firstItem() + $index }}
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div class="mhs-avatar avatar-color-{{ $colorIdx }}">
                                        {{ $inisial }}
                                    </div>
                                    <div>
                                        <a href="{{ route('mahasiswa.show', $mhs->id) }}" style="font-weight: 600; color: var(--dark);">
                                            {{ $mhs->nama }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="npm-badge">{{ $mhs->npm }}</span>
                            </td>
                            <td>
                                <span class="pill-badge prodi">{{ $mhs->prodi }}</span>
                            </td>
                            <td>
                                <span class="pill-badge angkatan">{{ $mhs->angkatan }}</span>
                            </td>
                            <td style="color: var(--gray-text-sub); font-size: 0.88rem;">
                                {{ $mhs->tanggal_lahir_masked }}
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
                            <td colspan="7" style="text-align: center; color: var(--gray-text-sub); padding: 3rem 1rem;">
                                <div style="font-size: 1.1rem; font-weight: 600; color: var(--dark); margin-bottom: 6px;">Data tidak ditemukan</div>
                                <p style="font-size: 0.9rem;">
                                    @if(request('search') || request('prodi'))
                                        Coba sesuaikan kata kunci pencarian atau reset filter.
                                    @else
                                        Belum ada data mahasiswa yang tersimpan.
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
