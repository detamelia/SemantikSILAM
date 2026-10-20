@extends('layouts.app')

@section('title', 'Statistik Akademik - Portal Mahasiswa')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Statistik & Analisis Akademik</h1>
            <p class="page-description">Rekapitulasi sebaran data mahasiswa berdasarkan angkatan masuk dan program studi.</p>
        </div>
        <div>
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                Lihat Daftar Mahasiswa
            </a>
        </div>
    </div>

    <!-- Dua Kolom: Distribusi Angkatan & Distribusi Prodi -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
        <!-- Distribusi per Angkatan -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Sebaran per Tahun Masuk (Angkatan)</div>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @forelse ($statistikAngkatan as $a)
                        @php
                            $persen = $totalMahasiswa > 0 ? round(($a->total / $totalMahasiswa) * 100) : 0;
                        @endphp
                        <div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.9rem; font-weight: 600; margin-bottom: 6px;">
                                <span>Angkatan {{ $a->angkatan }}</span>
                                <span style="color: var(--primary);">{{ $a->total }} Mahasiswa ({{ $persen }}%)</span>
                            </div>
                            <div style="width: 100%; height: 10px; background: #e2e8f0; border-radius: 999px; overflow: hidden;">
                                <div style="width: {{ $persen }}%; height: 100%; background: linear-gradient(90deg, #4338ca, #6366f1); border-radius: 999px;"></div>
                            </div>
                        </div>
                    @empty
                        <p style="color: var(--gray-text-sub); text-align: center;">Belum ada data angkatan.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Distribusi per Program Studi -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Sebaran per Program Studi</div>
            </div>
            <div class="card-body">
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    @forelse ($statistikProdi as $p)
                        @php
                            $persen = $totalMahasiswa > 0 ? round(($p->total / $totalMahasiswa) * 100) : 0;
                        @endphp
                        <div>
                            <div style="display: flex; justify-content: space-between; font-size: 0.9rem; font-weight: 600; margin-bottom: 6px;">
                                <span>{{ $p->prodi }}</span>
                                <span style="color: var(--secondary);">{{ $p->total }} Mahasiswa ({{ $persen }}%)</span>
                            </div>
                            <div style="width: 100%; height: 10px; background: #e2e8f0; border-radius: 999px; overflow: hidden;">
                                <div style="width: {{ $persen }}%; height: 100%; background: linear-gradient(90deg, #0284c7, #38bdf8); border-radius: 999px;"></div>
                            </div>
                        </div>
                    @empty
                        <p style="color: var(--gray-text-sub); text-align: center;">Belum ada data program studi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Matriks Persebaran: Program Studi x Angkatan -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Matriks Rekapitulasi: Program Studi x Tahun Angkatan</div>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Program Studi</th>
                        @foreach ($semuaAngkatan as $a)
                            <th style="text-align: center;">Angkatan {{ $a }}</th>
                        @endforeach
                        <th style="text-align: right;">Total Mahasiswa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($semuaProdi as $p)
                        @php
                            $subtotalProdi = 0;
                        @endphp
                        <tr>
                            <td style="font-weight: 600; color: var(--dark);">
                                {{ $p }}
                            </td>
                            @foreach ($semuaAngkatan as $a)
                                @php
                                    $val = $matrix[$p][$a] ?? 0;
                                    $subtotalProdi += $val;
                                @endphp
                                <td style="text-align: center;">
                                    @if($val > 0)
                                        <span class="npm-badge" style="background: #eef2ff; color: #4338ca; border-color: #c7d2fe;">
                                            {{ $val }}
                                        </span>
                                    @else
                                        <span style="color: #cbd5e1;">-</span>
                                    @endif
                                </td>
                            @endforeach
                            <td style="text-align: right; font-weight: 700; color: var(--primary);">
                                {{ $subtotalProdi }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background: #f8fafc; font-weight: 700;">
                        <td>TOTAL KESELURUHAN</td>
                        @foreach ($semuaAngkatan as $a)
                            @php
                                $totalKolom = 0;
                                foreach ($semuaProdi as $p) {
                                    $totalKolom += ($matrix[$p][$a] ?? 0);
                                }
                            @endphp
                            <td style="text-align: center; color: var(--dark);">{{ $totalKolom }}</td>
                        @endforeach
                        <td style="text-align: right; color: var(--primary); font-size: 1.05rem;">
                            {{ $totalMahasiswa }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
