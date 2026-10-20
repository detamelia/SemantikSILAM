@extends('layouts.app')

@section('title', 'Direktori Program Studi - Portal Mahasiswa')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Program Studi</h1>
            <p class="page-description">Daftar program studi aktif, akreditasi akademik, dan sebaran mahasiswa terdaftar.</p>
        </div>
        <div style="font-size: 0.9rem; color: var(--gray-text-sub); font-weight: 500;">
            Total: <strong>{{ count($daftarProdi) }}</strong> Program Studi Terdaftar
        </div>
    </div>

    <!-- Grid Kartu Program Studi -->
    <div class="grid-cards">
        @foreach ($daftarProdi as $p)
            <div class="prodi-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                    <div>
                        <span class="npm-badge" style="font-size: 0.75rem;">{{ $p['kode'] }}</span>
                        <div style="font-size: 0.78rem; color: var(--gray-text-sub); margin-top: 4px;">{{ $p['jenjang'] }}</div>
                    </div>
                    <div>
                        @if($p['akreditasi'] === 'Unggul')
                            <span class="pill-badge unggul">Akreditasi {{ $p['akreditasi'] }}</span>
                        @else
                            <span class="pill-badge baik">Akreditasi {{ $p['akreditasi'] }}</span>
                        @endif
                    </div>
                </div>

                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--dark); margin-bottom: 6px;">
                    {{ $p['nama'] }}
                </h3>

                <p style="font-size: 0.85rem; color: var(--gray-text-sub); line-height: 1.5; margin-bottom: 16px; flex: 1;">
                    {{ $p['deskripsi'] }}
                </p>

                <div style="background: #f8fafc; border: 1px solid var(--gray-border); border-radius: var(--radius-md); padding: 12px; margin-bottom: 16px; font-size: 0.82rem;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                        <span style="color: var(--gray-text-sub);">Fakultas:</span>
                        <span style="font-weight: 600; color: var(--dark);">{{ $p['fakultas'] }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                        <span style="color: var(--gray-text-sub);">Ketua Prodi:</span>
                        <span style="font-weight: 600; color: var(--dark);">{{ $p['kaprodi'] }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--gray-text-sub);">Lokasi:</span>
                        <span style="font-weight: 600; color: var(--dark);">{{ $p['ruang'] }}</span>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 12px; border-top: 1px solid var(--gray-border);">
                    <div>
                        <span style="font-size: 0.78rem; color: var(--gray-text-sub);">Total Mahasiswa:</span>
                        <div style="font-size: 1.25rem; font-weight: 800; color: var(--primary);">
                            {{ $p['total_mahasiswa'] }} <span style="font-size: 0.8rem; font-weight: 500; color: var(--gray-text-sub);">mhs</span>
                        </div>
                    </div>
                    <a href="{{ route('mahasiswa.index', ['prodi' => $p['nama']]) }}" class="btn btn-secondary btn-sm">
                        Lihat Mahasiswa &rarr;
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
