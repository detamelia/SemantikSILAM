@extends('layouts.app')

@section('title', 'Dokumentasi REST API & Semantic Web - Sistem A')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Dokumentasi REST API & Pemodelan Semantic Web</h1>
            <p class="page-description">Spesifikasi teknis integrasi Sistem A dengan Sistem B serta skema ontologi RDF/OWL.</p>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Live API Tester Box -->
    <div class="card" style="margin-bottom: 2rem; border-color: var(--primary-border);">
        <div class="card-header" style="background: var(--primary-light);">
            <div class="card-title" style="color: var(--primary); display: flex; align-items: center; gap: 8px;">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                Pengujian Interaktif REST API (Live API Tester)
            </div>
            <span class="pill-badge" style="background: #fff; color: var(--primary); font-weight: 700;">Lokal</span>
        </div>
        <div class="card-body">
            <p style="font-size: 0.9rem; color: var(--gray-text-sub); margin-bottom: 1rem;">
                Gunakan form di bawah ini untuk menguji respons REST API yang akan dipanggil oleh <strong>Sistem B</strong>.
            </p>

            <div style="display: flex; gap: 10px; max-width: 600px; margin-bottom: 1rem;">
                <input 
                    type="text" 
                    id="testNpmInput" 
                    class="input-control" 
                    placeholder="Masukkan NPM (contoh: 22081010001)" 
                    value="22081010001"
                >
                <button type="button" class="btn btn-primary" onclick="testApi()">
                    Uji REST API
                </button>
                <button type="button" class="btn btn-secondary" onclick="testRdf()">
                    Uji RDF Turtle
                </button>
            </div>

            <div id="testResultWrapper" style="display: none;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <div style="font-size: 0.82rem; font-weight: 700; text-transform: uppercase; color: var(--gray-text-sub);">
                        Status HTTP: <span id="testStatusCode" style="color: var(--success);">-</span>
                    </div>
                    <div id="testUrl" style="font-family: var(--font-mono); font-size: 0.8rem; color: var(--gray-text-sub);"></div>
                </div>
                <pre class="code-box"><code id="testOutput">// Hasil respons API akan ditampilkan di sini...</code></pre>
            </div>
        </div>
    </div>

    <!-- Spesifikasi Endpoint REST API -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-header">
            <div class="card-title">Spesifikasi Endpoint REST API</div>
        </div>
        <div class="card-body">
            <!-- Endpoint 1 -->
            <div style="margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                    <span class="pill-badge" style="background: #e0f2fe; color: #0369a1; font-weight: 700;">GET</span>
                    <code style="font-size: 1rem; font-weight: 600;">/api/mahasiswa/{npm}</code>
                </div>
                <p style="font-size: 0.9rem; color: var(--gray-text-sub); margin-bottom: 10px;">
                    Mengambil data identitas mahasiswa berdasarkan NPM untuk verifikasi pengajuan surat di Sistem B.
                </p>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <div class="info-key">Parameter URL:</div>
                        <ul style="font-size: 0.88rem; margin-left: 1.25rem; color: var(--dark-muted);">
                            <li><code>npm</code> (string, required): Nomor Pokok Mahasiswa yang dicari.</li>
                        </ul>

                        <div class="info-key" style="margin-top: 10px;">Header Opsional:</div>
                        <ul style="font-size: 0.88rem; margin-left: 1.25rem; color: var(--dark-muted);">
                            <li><code>X-API-KEY</code>: Token otentikasi (jika diaktifkan pada .env).</li>
                        </ul>
                    </div>

                    <div>
                        <div class="info-key">Contoh Respons Sukses (HTTP 200):</div>
                        <pre class="code-box" style="font-size: 0.78rem;"><code>{
  "success": true,
  "message": "Data mahasiswa berhasil diverifikasi.",
  "data": {
    "npm": "22081010001",
    "nama": "Ahmad Fauzi",
    "prodi": "Informatika",
    "angkatan": "2022",
    "uri_semantik": "http://example.org/resource/mahasiswa/22081010001"
  }
}</code></pre>
                    </div>
                </div>

                <div style="margin-top: 10px;">
                    <div class="info-key">Contoh Respons Tidak Ditemukan (HTTP 404):</div>
                    <pre class="code-box" style="font-size: 0.78rem;"><code>{
  "success": false,
  "error_code": "MAHASISWA_NOT_FOUND",
  "message": "Mahasiswa dengan NPM '99999999' tidak ditemukan pada basis data Sistem A."
}</code></pre>
                </div>
            </div>

            <hr style="border: none; border-top: 1px solid var(--gray-border); margin: 1.5rem 0;">

            <!-- Endpoint 2 -->
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                    <span class="pill-badge" style="background: #e0f2fe; color: #0369a1; font-weight: 700;">GET</span>
                    <code style="font-size: 1rem; font-weight: 600;">/api/mahasiswa/{npm}/rdf</code>
                </div>
                <p style="font-size: 0.9rem; color: var(--gray-text-sub);">
                    Mengembalikan representasi RDF Turtle individual mahasiswa untuk integrasi Semantic Web.
                </p>
            </div>
        </div>
    </div>

    <!-- Dokumentasi Ontologi Semantic Web -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Pemodelan Ontologi Semantic Web (RDF & OWL)</div>
        </div>
        <div class="card-body">
            <p style="font-size: 0.92rem; color: var(--dark-muted); margin-bottom: 1.25rem;">
                Sistem A menggunakan skema ontologi berbasis W3C Standard (RDF, RDFS, OWL, XSD) dengan namespace berikut:
            </p>

            <pre class="code-box" style="margin-bottom: 1.5rem;"><code>@prefix mhs: &lt;http://example.org/ontology/mahasiswa#&gt; .
@prefix res: &lt;http://example.org/resource/mahasiswa/&gt; .
@prefix owl: &lt;http://www.w3.org/2002/07/owl#&gt; .
@prefix xsd: &lt;http://www.w3.org/2001/XMLSchema#&gt; .</code></pre>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Entitas</th>
                            <th>Tipe Ontologi</th>
                            <th>Domain & Range</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>mhs:Mahasiswa</code></td>
                            <td><span class="pill-badge prodi">owl:Class</span></td>
                            <td>-</td>
                            <td>Kelas entitas mahasiswa.</td>
                        </tr>
                        <tr>
                            <td><code>mhs:npm</code></td>
                            <td><span class="pill-badge angkatan">owl:DatatypeProperty</span></td>
                            <td>Domain: <code>mhs:Mahasiswa</code><br>Range: <code>xsd:string</code></td>
                            <td>Nomor Pokok Mahasiswa (Identitas pembeda unik).</td>
                        </tr>
                        <tr>
                            <td><code>mhs:namaMahasiswa</code></td>
                            <td><span class="pill-badge angkatan">owl:DatatypeProperty</span></td>
                            <td>Domain: <code>mhs:Mahasiswa</code><br>Range: <code>xsd:string</code></td>
                            <td>Nama lengkap mahasiswa.</td>
                        </tr>
                        <tr>
                            <td><code>mhs:programStudi</code></td>
                            <td><span class="pill-badge angkatan">owl:DatatypeProperty</span></td>
                            <td>Domain: <code>mhs:Mahasiswa</code><br>Range: <code>xsd:string</code></td>
                            <td>Program studi mahasiswa.</td>
                        </tr>
                        <tr>
                            <td><code>mhs:angkatan</code></td>
                            <td><span class="pill-badge angkatan">owl:DatatypeProperty</span></td>
                            <td>Domain: <code>mhs:Mahasiswa</code><br>Range: <code>xsd:gYear</code></td>
                            <td>Tahun kalender angkatan masuk.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 1.5rem; background: #f8fafc; border: 1px solid var(--gray-border); padding: 1.25rem; border-radius: 12px;">
                <div style="font-weight: 700; margin-bottom: 6px;">Berkas Ontologi yang Tersedia di Repositori:</div>
                <ul style="font-size: 0.88rem; margin-left: 1.25rem; color: var(--dark-muted);">
                    <li><code>ontology/mahasiswa.ttl</code> (Sintaks Turtle untuk Semantic Web)</li>
                    <li><code>ontology/mahasiswa.owl</code> (Sintaks OWL/XML untuk Protégé)</li>
                    <li><code>docs/SEMANTIC_WEB.md</code> (Spesifikasi arsitektur integrasi lengkap)</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Script Pengujian Interaktif -->
    <script>
        async function testApi() {
            const npm = document.getElementById('testNpmInput').value.trim();
            if (!npm) {
                alert('Silakan masukkan NPM terlebih dahulu.');
                return;
            }

            const wrapper = document.getElementById('testResultWrapper');
            const statusEl = document.getElementById('testStatusCode');
            const urlEl = document.getElementById('testUrl');
            const outputEl = document.getElementById('testOutput');

            const url = `{{ url('/api/mahasiswa') }}/${npm}`;
            urlEl.textContent = url;
            wrapper.style.display = 'block';
            outputEl.textContent = 'Memuat respons...';

            try {
                const res = await fetch(url, {
                    headers: { 'Accept': 'application/json' }
                });
                statusEl.textContent = `${res.status} ${res.statusText}`;
                statusEl.style.color = res.ok ? 'var(--success)' : 'var(--danger)';

                const data = await res.json();
                outputEl.textContent = JSON.stringify(data, null, 2);
            } catch (err) {
                statusEl.textContent = 'FETCH ERROR';
                statusEl.style.color = 'var(--danger)';
                outputEl.textContent = String(err);
            }
        }

        async function testRdf() {
            const npm = document.getElementById('testNpmInput').value.trim();
            if (!npm) {
                alert('Silakan masukkan NPM terlebih dahulu.');
                return;
            }

            const wrapper = document.getElementById('testResultWrapper');
            const statusEl = document.getElementById('testStatusCode');
            const urlEl = document.getElementById('testUrl');
            const outputEl = document.getElementById('testOutput');

            const url = `{{ url('/api/mahasiswa') }}/${npm}/rdf`;
            urlEl.textContent = url;
            wrapper.style.display = 'block';
            outputEl.textContent = 'Memuat respons RDF Turtle...';

            try {
                const res = await fetch(url);
                statusEl.textContent = `${res.status} ${res.statusText}`;
                statusEl.style.color = res.ok ? 'var(--success)' : 'var(--danger)';

                const text = await res.text();
                outputEl.textContent = text;
            } catch (err) {
                statusEl.textContent = 'FETCH ERROR';
                statusEl.style.color = 'var(--danger)';
                outputEl.textContent = String(err);
            }
        }
    </script>
@endsection
