@extends('layouts.app')

@section('title', 'Detail Mahasiswa - ' . $mahasiswa->nama)

@section('content')
    <div style="max-width: 800px; margin: 0 auto;">
        <div class="page-header" style="margin-bottom: 1.5rem;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                    <span class="npm-badge" style="font-size: 0.95rem;">{{ $mahasiswa->npm }}</span>
                    <span class="pill-badge prodi">{{ $mahasiswa->prodi }}</span>
                </div>
                <h1 class="page-title">{{ $mahasiswa->nama }}</h1>
                <p class="page-description">Informasi biodata dan status akademik mahasiswa.</p>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                    &larr; Kembali
                </a>
                <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-secondary">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Ubah
                </a>
                <button 
                    type="button" 
                    class="btn btn-danger btn-sm" 
                    onclick="confirmDelete('{{ route('mahasiswa.destroy', $mahasiswa->id) }}', '{{ addslashes($mahasiswa->nama) }}', '{{ $mahasiswa->npm }}')"
                >
                    Hapus
                </button>
            </div>
        </div>

        <!-- Kartu Detail Mahasiswa -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Biodata Mahasiswa</div>
            </div>
            <div class="card-body">
                <div class="info-list">
                    <div class="info-item">
                        <div class="info-key">NPM</div>
                        <div class="info-value" style="font-family: var(--font-mono); color: var(--primary);">
                            {{ $mahasiswa->npm }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-key">Tahun Angkatan</div>
                        <div class="info-value">{{ $mahasiswa->angkatan }}</div>
                    </div>

                    <div class="info-item full-width">
                        <div class="info-key">Nama Lengkap</div>
                        <div class="info-value">{{ $mahasiswa->nama }}</div>
                    </div>

                    <div class="info-item full-width">
                        <div class="info-key">Program Studi</div>
                        <div class="info-value">{{ $mahasiswa->prodi }}</div>
                    </div>

                    <div class="info-item full-width">
                        <div class="info-key">Tanggal Lahir</div>
                        <div class="info-value">
                            {{ $mahasiswa->tanggal_lahir_masked_text }}
                        </div>
                        <div style="font-size: 0.8rem; color: var(--gray-text-sub); margin-top: 4px;">
                            * Ditampilkan dengan tanggal yang disamarkan untuk perlindungan data pribadi.
                        </div>
                    </div>

                    <div class="info-item full-width">
                        <div class="info-key">Nama Ibu Kandung</div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2px;">
                            <div id="ibuText" class="info-value" style="font-family: var(--font-mono); letter-spacing: 2px;">
                                &bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;
                            </div>
                            <button 
                                type="button" 
                                id="btnToggleIbu"
                                class="btn btn-secondary btn-sm"
                                onclick="toggleNamaIbu()"
                            >
                                Tampilkan
                            </button>
                        </div>
                        <div style="font-size: 0.78rem; color: var(--gray-text-sub); margin-top: 6px;">
                            Data tersimpan secara aman dalam bentuk terenkripsi.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let isRevealed = false;
        const realNamaIbu = "{{ addslashes($mahasiswa->nama_ibu) }}";

        function toggleNamaIbu() {
            const ibuText = document.getElementById('ibuText');
            const btn = document.getElementById('btnToggleIbu');

            if (!isRevealed) {
                ibuText.textContent = realNamaIbu;
                ibuText.style.letterSpacing = 'normal';
                ibuText.style.color = 'var(--dark)';
                btn.textContent = 'Sembunyikan';
                isRevealed = true;
            } else {
                ibuText.textContent = '••••••••••••••••';
                ibuText.style.letterSpacing = '2px';
                btn.textContent = 'Tampilkan';
                isRevealed = false;
            }
        }
    </script>
@endsection
