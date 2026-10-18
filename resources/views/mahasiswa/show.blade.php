@extends('layouts.app')

@section('title', 'Detail Mahasiswa - ' . $mahasiswa->nama)

@section('content')
    <div class="page-header">
        <div>
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                <span class="npm-badge" style="font-size: 0.95rem;">{{ $mahasiswa->npm }}</span>
                <span class="pill-badge prodi">{{ $mahasiswa->prodi }}</span>
            </div>
            <h1 class="page-title">{{ $mahasiswa->nama }}</h1>
            <p class="page-description">Detail data mahasiswa dan kesiapan integrasi Sistem B & Semantic Web.</p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('mahasiswa.index') }}" class="btn btn-secondary">
                &larr; Kembali
            </a>
            <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-secondary">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Ubah Data
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

    <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 1.5rem; align-items: start;">
        <!-- Kolom Kiri: Informasi Mahasiswa & Privasi -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Informasi Utama -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Informasi Mahasiswa</div>
                </div>
                <div class="card-body">
                    <div class="info-list">
                        <div class="info-item">
                            <div class="info-key">NPM (Nomor Pokok Mahasiswa)</div>
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

                        <!-- Tanggal Lahir (Disamarkan ke tanggal 1) -->
                        <div class="info-item full-width" style="border-left: 4px solid var(--warning);">
                            <div class="info-key">Tanggal Lahir (Disamarkan ke Tanggal 1)</div>
                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: gap: 8px;">
                                <div class="info-value" style="color: var(--warning-text);">
                                    {{ $mahasiswa->tanggal_lahir_masked_text }} ({{ $mahasiswa->tanggal_lahir_masked }})
                                </div>
                                <span class="pill-badge masked" style="font-size: 0.75rem;">
                                    Sesuai Ketentuan Tugas
                                </span>
                            </div>
                            <div style="font-size: 0.8rem; color: var(--gray-text-sub); margin-top: 6px;">
                                * Catatan: Tanggal lahir asli tersimpan di database PostgreSQL, namun saat ditampilkan selalu menggunakan tanggal 1 untuk perlindungan privasi.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perlindungan Data Sensitif (Nama Ibu) -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="display: flex; align-items: center; gap: 8px;">
                        <svg width="20" height="20" fill="none" stroke="var(--success)" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Perlindungan Data Sensitif (Enkripsi)
                    </div>
                    <span class="pill-badge secure">AES-256 Protected</span>
                </div>
                <div class="card-body">
                    <div class="info-item full-width" style="border-left: 4px solid var(--success);">
                        <div class="info-key">Nama Ibu Kandung</div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div id="ibuText" class="info-value" style="font-family: var(--font-mono); letter-spacing: 2px;">
                                &bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;
                            </div>
                            <button 
                                type="button" 
                                id="btnToggleIbu"
                                class="btn btn-secondary btn-sm"
                                onclick="toggleNamaIbu()"
                            >
                                Perlihatkan (Admin)
                            </button>
                        </div>
                        <div style="font-size: 0.8rem; color: var(--gray-text-sub); margin-top: 8px;">
                            Data tersimpan di tabel <code>mahasiswas.nama_ibu</code> dalam bentuk cipher text terenkripsi. 
                            Atribut ini <strong>TIDAK PERNAH</strong> dikembalikan pada respons REST API Sistem B demi memenuhi prinsip minimalisasi data.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Kesiapan Integrasi Sistem B & Semantic Web -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Integrasi REST API Sistem B -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="display: flex; align-items: center; gap: 8px;">
                        <svg width="20" height="20" fill="none" stroke="var(--primary)" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Respons REST API untuk Sistem B
                    </div>
                </div>
                <div class="card-body">
                    <p style="font-size: 0.85rem; color: var(--gray-text-sub); margin-bottom: 10px;">
                        Endpoint yang dipanggil oleh Sistem B:
                    </p>
                    <div class="code-box" style="margin-bottom: 12px; font-size: 0.8rem;">
                        <span style="color: #38bdf8;">GET</span> /api/mahasiswa/<span style="color: #facc15;">{{ $mahasiswa->npm }}</span>
                    </div>

                    <p style="font-size: 0.85rem; color: var(--gray-text-sub); margin-bottom: 6px;">
                        Payload JSON yang dikembalikan (Prinsip Minimalisasi Data):
                    </p>
                    <pre class="code-box" style="max-height: 220px;"><code>{
  "success": true,
  "message": "Data mahasiswa berhasil diverifikasi.",
  "data": {
    "npm": "{{ $mahasiswa->npm }}",
    "nama": "{{ $mahasiswa->nama }}",
    "prodi": "{{ $mahasiswa->prodi }}",
    "angkatan": "{{ $mahasiswa->angkatan }}",
    "uri_semantik": "{{ $mahasiswa->semantic_uri }}"
  }
}</code></pre>
                    <div style="margin-top: 12px; text-align: right;">
                        <a href="{{ url('/api/mahasiswa/' . $mahasiswa->npm) }}" target="_blank" class="btn btn-secondary btn-sm">
                            Buka API JSON &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Kesiapan Semantic Web (RDF / OWL) -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="display: flex; align-items: center; gap: 8px;">
                        <svg width="20" height="20" fill="none" stroke="var(--secondary)" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        Pemodelan Semantic Web
                    </div>
                </div>
                <div class="card-body">
                    <div style="margin-bottom: 12px;">
                        <div class="info-key">Subject URI Mahasiswa:</div>
                        <code class="code-box" style="display: block; font-size: 0.82rem; word-break: break-all; margin-top: 4px;">
                            &lt;{{ $mahasiswa->semantic_uri }}&gt;
                        </code>
                    </div>

                    <div style="margin-bottom: 12px;">
                        <div class="info-key">Ontology Class:</div>
                        <span class="pill-badge prodi">mhs:Mahasiswa</span>
                    </div>

                    <div style="text-align: right;">
                        <a href="{{ url('/api/mahasiswa/' . $mahasiswa->npm . '/rdf') }}" target="_blank" class="btn btn-secondary btn-sm">
                            Lihat RDF Turtle &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Toggle Nama Ibu -->
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
                btn.textContent = 'Perlihatkan (Admin)';
                isRevealed = false;
            }
        }
    </script>
@endsection
