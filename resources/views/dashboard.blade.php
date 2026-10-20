@extends('layouts.app')

@section('title', 'Dashboard - Portal Mahasiswa')

@section('content')
    <!-- Sambutan Dashboard -->
    <div style="background: #fff; border: 1px solid var(--gray-border); border-radius: var(--radius-lg); padding: 1.75rem 2rem; margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.25rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                <span class="pill-badge prodi" style="font-size: 0.75rem;">Semester Ganjil 2026/2027</span>
                <span style="font-size: 0.8rem; color: var(--gray-text-sub);">&bull; Pangkalan Data Terpadu</span>
            </div>
            <h1 style="font-size: 1.55rem; font-weight: 800; color: var(--dark); margin: 0; letter-spacing: -0.3px;">
                Pangkalan Data Mahasiswa
            </h1>
            <p style="color: var(--gray-text-sub); font-size: 0.92rem; margin-top: 4px;">
                Administrasi master data akademik, validasi identitas unik mahasiswa, dan pemantauan distribusi program studi.
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                Daftar Mahasiswa
            </a>
            <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary">
                <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
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
                <div class="stat-label">Total Mahasiswa Terdaftar</div>
                <div class="stat-value">{{ number_format($totalMahasiswa) }} <span style="font-size: 0.9rem; font-weight: 500; color: var(--gray-text-sub);">orang</span></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon info">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">Program Studi Aktif</div>
                <div class="stat-value">{{ number_format($totalProdi) }} <span style="font-size: 0.9rem; font-weight: 500; color: var(--gray-text-sub);">jurusan</span></div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon warning">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">Angkatan Terdata</div>
                <div class="stat-value">{{ number_format($totalAngkatan) }} <span style="font-size: 0.9rem; font-weight: 500; color: var(--gray-text-sub);">angkatan</span></div>
            </div>
        </div>
    </div>

    <!-- Layout Dua Kolom: Tabel Terbaru & Widget Kalender -->
    <div style="display: grid; grid-template-columns: 2fr 1.1fr; gap: 1.5rem; align-items: start;">
        <!-- Kolom Kiri: Mahasiswa Terbaru -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Mahasiswa Baru Terdaftar</div>
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            <th>NPM</th>
                            <th>Program Studi</th>
                            <th>Angkatan</th>
                            <th style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mahasiswaTerbaru as $index => $mhs)
                            @php
                                $colorIdx = $index % 6;
                                $inisial = strtoupper(substr($mhs->nama, 0, 1));
                            @endphp
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div class="mhs-avatar avatar-color-{{ $colorIdx }}">
                                            {{ $inisial }}
                                        </div>
                                        <div>
                                            <a href="{{ route('mahasiswa.show', $mhs->id) }}" style="font-weight: 600; color: var(--dark);">
                                                {{ $mhs->nama }}
                                            </a>
                                            <div style="font-size: 0.75rem; color: var(--gray-text-sub);">
                                                Lahir: {{ $mhs->tanggal_lahir_masked }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="npm-badge">{{ $mhs->npm }}</span></td>
                                <td><span class="pill-badge prodi">{{ $mhs->prodi }}</span></td>
                                <td><span class="pill-badge angkatan">{{ $mhs->angkatan }}</span></td>
                                <td style="text-align: right;">
                                    <a href="{{ route('mahasiswa.show', $mhs->id) }}" class="btn btn-secondary btn-sm">
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

        <!-- Kolom Kanan: Agenda Akademik & Sebaran Singkat -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Widget Agenda Akademik -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Agenda Akademik</div>
                </div>
                <div class="card-body" style="padding-top: 0.5rem; padding-bottom: 0.5rem;">
                    <div class="widget-item">
                        <div class="widget-date-badge">
                            <div class="widget-date-day">20</div>
                            <div class="widget-date-month">Okt</div>
                        </div>
                        <div>
                            <div style="font-size: 0.88rem; font-weight: 700; color: var(--dark);">Sinkronisasi Data Mahasiswa Baru</div>
                            <div style="font-size: 0.78rem; color: var(--gray-text-sub); margin-top: 2px;">Pembaruan identitas induk mahasiswa ke pangkalan data terpusat.</div>
                        </div>
                    </div>

                    <div class="widget-item">
                        <div class="widget-date-badge">
                            <div class="widget-date-day">28</div>
                            <div class="widget-date-month">Okt</div>
                        </div>
                        <div>
                            <div style="font-size: 0.88rem; font-weight: 700; color: var(--dark);">Batas Verifikasi Profil Mahasiswa</div>
                            <div style="font-size: 0.78rem; color: var(--gray-text-sub); margin-top: 2px;">Pemeriksaan kelengkapan data diri dan nama orang tua.</div>
                        </div>
                    </div>

                    <div class="widget-item">
                        <div class="widget-date-badge">
                            <div class="widget-date-day">05</div>
                            <div class="widget-date-month">Nov</div>
                        </div>
                        <div>
                            <div style="font-size: 0.88rem; font-weight: 700; color: var(--dark);">Integrasi Layanan Surat Online</div>
                            <div style="font-size: 0.78rem; color: var(--gray-text-sub); margin-top: 2px;">Aktivasi pengajuan surat aktif kuliah berbasis NPM.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Widget Sebaran Singkat -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Sebaran Mahasiswa</div>
                    <a href="{{ route('statistik.index') }}" style="font-size: 0.82rem; font-weight: 600;">Detail &rarr;</a>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach ($statistikProdi as $stat)
                            @php
                                $percent = $totalMahasiswa > 0 ? round(($stat->total / $totalMahasiswa) * 100) : 0;
                            @endphp
                            <div>
                                <div style="display: flex; justify-content: space-between; font-size: 0.82rem; font-weight: 600; margin-bottom: 4px;">
                                    <span>{{ $stat->prodi }}</span>
                                    <span style="color: var(--primary);">{{ $stat->total }} mhs</span>
                                </div>
                                <div style="width: 100%; height: 6px; background: #e2e8f0; border-radius: 999px; overflow: hidden;">
                                    <div style="width: {{ $percent }}%; height: 100%; background: var(--primary); border-radius: 999px;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
