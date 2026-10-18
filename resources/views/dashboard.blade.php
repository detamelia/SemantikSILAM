@extends('layouts.app')

@section('title', 'Dashboard - Sistem Informasi Data Mahasiswa')

@section('content')
    <!-- Banner Sambutan & Semantic Web Readiness -->
    <div class="banner-semantic">
        <div>
            <span class="badge-tag">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                Sistem 1 (Sistem A) Beroperasi
            </span>
            <h1 class="banner-title">Sistem Informasi Data Mahasiswa Terintegrasi</h1>
            <p class="banner-desc">
                Sistem master penyedia data mahasiswa berbasis <strong>PostgreSQL</strong> dan <strong>Laravel</strong>. 
                Dilengkapi enkripsi data pribadi, penyamaran tanggal lahir ke tanggal 1, REST API untuk verifikasi identitas di Sistem B, 
                serta skema RDF/OWL untuk pemodelan Semantic Web.
            </p>
        </div>
        <div>
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-secondary" style="font-weight: 700;">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Mahasiswa
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon primary">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Mahasiswa</div>
                <div class="stat-value">{{ number_format($totalMahasiswa) }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon info">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">Program Studi</div>
                <div class="stat-value">{{ number_format($totalProdi) }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon warning">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">Jumlah Angkatan</div>
                <div class="stat-value">{{ number_format($totalAngkatan) }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon success">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">Keamanan Data</div>
                <div class="stat-value" style="font-size: 1.25rem; color: var(--success); margin-top: 6px;">AES-256 Aktif</div>
            </div>
        </div>
    </div>

    <!-- Dua Kolom: Distribusi Prodi & Mahasiswa Terbaru -->
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; align-items: start;">
        <!-- Distribusi Program Studi -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Distribusi Program Studi</div>
            </div>
            <div class="card-body" style="padding: 1.25rem;">
                @if($statistikProdi->isEmpty())
                    <p style="color: var(--gray-text-sub); text-align: center; padding: 1.5rem 0;">Belum ada data mahasiswa.</p>
                @else
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach ($statistikProdi as $stat)
                            @php
                                $percent = $totalMahasiswa > 0 ? round(($stat->total / $totalMahasiswa) * 100) : 0;
                            @endphp
                            <div>
                                <div style="display: flex; justify-content: space-between; font-size: 0.88rem; font-weight: 600; margin-bottom: 4px;">
                                    <span>{{ $stat->prodi }}</span>
                                    <span style="color: var(--primary);">{{ $stat->total }} mhs ({{ $percent }}%)</span>
                                </div>
                                <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 999px; overflow: hidden;">
                                    <div style="width: {{ $percent }}%; height: 100%; background: var(--primary); border-radius: 999px;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Tabel Mahasiswa Terbaru -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Mahasiswa Terbaru</div>
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>NPM</th>
                            <th>Nama</th>
                            <th>Program Studi</th>
                            <th>Tgl Lahir (Disamarkan)</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswaTerbaru as $mhs)
                            <tr>
                                <td><span class="npm-badge">{{ $mhs->npm }}</span></td>
                                <td style="font-weight: 600;">{{ $mhs->nama }}</td>
                                <td><span class="pill-badge prodi">{{ $mhs->prodi }}</span></td>
                                <td>
                                    <span class="pill-badge masked" title="Tanggal lahir asli disamarkan ke tanggal 1 sesuai aturan">
                                        {{ $mhs->tanggal_lahir_masked }}
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <a href="{{ route('mahasiswa.show', $mhs->id) }}" class="btn btn-secondary btn-sm" title="Lihat Detail">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--gray-text-sub); padding: 2rem;">
                                    Belum ada data mahasiswa yang tersimpan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
