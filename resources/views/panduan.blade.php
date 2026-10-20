@extends('layouts.app')

@section('title', 'Panduan Layanan - Portal Mahasiswa')

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Pusat Bantuan & Panduan Sistem</h1>
            <p class="page-description">Panduan administrasi pangkalan data mahasiswa, tata kelola identitas, dan kebijakan privasi.</p>
        </div>
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; align-items: start;">
        <!-- Kolom Panduan Utama -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">1. Manajemen Data Mahasiswa</div>
                </div>
                <div class="card-body" style="line-height: 1.7; font-size: 0.92rem; color: var(--dark-muted);">
                    <p style="margin-bottom: 12px;">
                        Setiap mahasiswa yang terdaftar memiliki identitas pembeda tunggal berupa <strong>Nomor Pokok Mahasiswa (NPM)</strong>. 
                        NPM digunakan sebagai kunci utama dalam seluruh proses administrasi akademik dan sinkronisasi layanan terpadu.
                    </p>
                    <ul style="margin-left: 1.25rem; margin-bottom: 12px;">
                        <li><strong>Penambahan Data:</strong> Pastikan nama mahasiswa sesuai dengan KTP/ijazah resmi dan NPM belum pernah digunakan.</li>
                        <li><strong>Pembaruan Data:</strong> Perubahan data program studi atau angkatan dapat dilakukan melalui menu Ubah Data.</li>
                        <li><strong>Penghapusan:</strong> Data yang dihapus tidak dapat dipulihkan kembali, sehingga pastikan verifikasi dilakukan terlebih dahulu.</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title">2. Kebijakan Keamanan dan Perlindungan Data</div>
                </div>
                <div class="card-body" style="line-height: 1.7; font-size: 0.92rem; color: var(--dark-muted);">
                    <p style="margin-bottom: 12px;">
                        Pangkalan data menerapkan standar perlindungan informasi pribadi untuk menjamin keamanan identitas mahasiswa:
                    </p>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div style="background: #f8fafc; border: 1px solid var(--gray-border); padding: 12px 14px; border-radius: var(--radius-md);">
                            <strong style="color: var(--dark);">Enkripsi Data Sensitif:</strong>
                            <p style="font-size: 0.85rem; color: var(--gray-text-sub); margin-top: 4px;">
                                Informasi keluarga seperti nama ibu kandung disimpan dalam bentuk terenkripsi pada basis data dan tidak dapat diakses tanpa hak otorisasi yang sah.
                            </p>
                        </div>
                        <div style="background: #f8fafc; border: 1px solid var(--gray-border); padding: 12px 14px; border-radius: var(--radius-md);">
                            <strong style="color: var(--dark);">Penyamaran Tanggal Lahir Publik:</strong>
                            <p style="font-size: 0.85rem; color: var(--gray-text-sub); margin-top: 4px;">
                                Pada seluruh laporan publik dan antarmuka umum, tanggal lahir disamarkan menggunakan tanggal 1 setiap bulannya demi mencegah penyalahgunaan data kependudukan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ -->
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Pertanyaan yang Sering Diajukan (FAQ)</div>
                </div>
                <div class="card-body" style="font-size: 0.92rem;">
                    <div style="margin-bottom: 14px;">
                        <strong style="color: var(--dark);">Q: Bagaimana jika terjadi kesalahan penginputan NPM?</strong>
                        <p style="color: var(--gray-text-sub); margin-top: 4px; font-size: 0.88rem;">
                            A: Administrator dapat membuka detail mahasiswa yang bersangkutan dan menekan tombol Ubah untuk memperbaiki nomor NPM.
                        </p>
                    </div>
                    <div style="margin-bottom: 14px;">
                        <strong style="color: var(--dark);">Q: Apakah data mahasiswa dapat langsung diakses oleh sistem layanan surat?</strong>
                        <p style="color: var(--gray-text-sub); margin-top: 4px; font-size: 0.88rem;">
                            A: Ya, sistem layanan terpadu dapat memverifikasi identitas mahasiswa secara otomatis melalui pangkalan data terintegrasi.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Kontak Bantuan -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div class="card">
                <div class="card-header">
                    <div class="card-title" style="font-size: 1rem;">Layanan Dukungan</div>
                </div>
                <div class="card-body" style="font-size: 0.88rem; line-height: 1.6;">
                    <p style="color: var(--gray-text-sub); margin-bottom: 12px;">
                        Jika mengalami kendala administrasi data atau sinkronisasi, silakan hubungi unit pengelola pangkalan data:
                    </p>
                    <div style="background: #f8fafc; border: 1px solid var(--gray-border); padding: 12px; border-radius: 8px; margin-bottom: 10px;">
                        <div style="font-size: 0.75rem; text-transform: uppercase; color: var(--gray-text-sub); font-weight: 700;">Unit Kerja:</div>
                        <div style="font-weight: 600; color: var(--dark);">Biro Administrasi Akademik & Kemahasiswaan</div>
                    </div>
                    <div style="background: #f8fafc; border: 1px solid var(--gray-border); padding: 12px; border-radius: 8px;">
                        <div style="font-size: 0.75rem; text-transform: uppercase; color: var(--gray-text-sub); font-weight: 700;">Jam Operasional:</div>
                        <div style="font-weight: 600; color: var(--dark);">Senin – Jumat: 08.00 – 16.00 WIB</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
