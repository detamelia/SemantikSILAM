# Sistem A: Sistem Informasi Data Mahasiswa (UTS Semantic Web)

**Sistem Informasi Mahasiswa Terintegrasi - Tahap 1: Sistem Informasi Data Mahasiswa (Sistem A)**

Sistem ini dibangun menggunakan **Laravel (PHP)** dan **PostgreSQL** sebagai master data mahasiswa. Sistem A menyediakan antarmuka web untuk manajemen data mahasiswa (CRUD), enkripsi data pribadi (*data privacy*), penyamaran tanggal lahir ke tanggal 1, REST API untuk integrasi dengan Sistem B, serta pemodelan ontologi **Semantic Web (RDF/OWL)**.

---

## 🌟 Fitur Utama

1. **Dashboard Sistem Informasi**: Ringkasan statistik mahasiswa, total program studi, jumlah angkatan, dan data mahasiswa terbaru.
2. **Manajemen Data Mahasiswa (CRUD)**:
   - Menampilkan daftar mahasiswa dengan pagination dan filter program studi.
   - Pencarian mahasiswa berdasarkan **NPM** atau **Nama**.
   - Tambah mahasiswa baru dengan validasi input yang aman.
   - Detail mahasiswa lengkap dengan preview JSON API dan Subject URI Semantic Web.
   - Ubah data mahasiswa dengan prefilled form.
   - Hapus data mahasiswa dengan modal konfirmasi interaktif.
3. **Identitas Unik**: Menggunakan **NPM** sebagai *Unique Identifier* di basis data dan *Subject URI* pada Semantic Web.
4. **Perlindungan Data Pribadi (*Data Privacy & Minimization*)**:
   - **Enkripsi Nama Ibu**: Nama ibu disimpan dalam bentuk terenkripsi menggunakan Laravel Attribute Encryption (AES-256-CBC) dan tidak pernah dikembalikan ke REST API publik.
   - **Penyamaran Tanggal Lahir**: Tanggal lahir asli tersimpan aman di database PostgreSQL, namun saat ditampilkan di layar publik/laporan, tanggal disamarkan selalu menjadi tanggal 1 (contoh: `01/03/2004`).
5. **REST API untuk Sistem B**:
   - `GET /api/mahasiswa/{npm}`: Mengembalikan data verifikasi identitas mahasiswa (NPM, Nama, Prodi, Angkatan).
   - `GET /api/status`: Status kesehatan API Sistem A.
   - `GET /api/mahasiswa/{npm}/rdf`: Representasi RDF Turtle individual mahasiswa.
6. **Kesiapan Semantic Web**:
   - Namespace konsisten: `http://example.org/ontology/mahasiswa#` (prefix `mhs:`).
   - Resource URI: `http://example.org/resource/mahasiswa/{npm}` (prefix `res:`).
   - File ontologi RDF Turtle: `ontology/mahasiswa.ttl`.
   - File ontologi OWL/XML: `ontology/mahasiswa.owl`.
   - Dokumentasi lengkap di `docs/SEMANTIC_WEB.md` dan halaman `/dokumentasi`.

---

## 📂 Struktur Berkas Penting

```text
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php         # Menampilkan statistik & beranda
│   │   │   ├── MahasiswaController.php         # CRUD data mahasiswa (Web)
│   │   │   └── Api/
│   │   │       └── MahasiswaApiController.php  # REST API verifikasi untuk Sistem B & RDF Turtle
│   │   └── Requests/
│   │       └── MahasiswaRequest.php            # Validasi form input mahasiswa
│   └── Models/
│       └── Mahasiswa.php                       # Eloquent model (enkripsi nama_ibu, masked tgl lahir, URI semantik)
├── database/
│   ├── migrations/
│   │   └── 2026_10_18_000001_create_mahasiswas_table.php # Tabel mahasiswas di PostgreSQL
│   └── seeders/
│       ├── MahasiswaSeeder.php                 # Seeder data sintetis (dummy) untuk pengujian
│       └── DatabaseSeeder.php
├── docs/
│   └── SEMANTIC_WEB.md                         # Dokumentasi pemodelan ontologi & Semantic Web
├── ontology/
│   ├── mahasiswa.ttl                           # Skema ontologi dalam format RDF Turtle
│   └── mahasiswa.owl                           # Skema ontologi dalam format OWL/XML
├── public/
│   └── css/
│       └── style.css                           # Styling modern dashboard & kartu informasi
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php                   # Master layout Blade dengan modal hapus
│       ├── dashboard.blade.php                 # Tampilan dashboard statistik
│       ├── mahasiswa/
│       │   ├── index.blade.php                 # Tabel daftar mahasiswa & pencarian
│       │   ├── create.blade.php                # Form tambah mahasiswa baru
│       │   ├── edit.blade.php                  # Form ubah data mahasiswa
│       │   └── show.blade.php                  # Halaman detail & preview integrasi API
│       └── docs/
│           └── api.blade.php                   # Dokumentasi REST API + Live Tester
├── routes/
│   ├── web.php                                 # Rute antarmuka Web
│   └── api.php                                 # Rute REST API
└── tests/
    └── Feature/
        └── MahasiswaTest.php                   # Unit & Feature Test otomatis (8 tests passed)
```

---

## 🚀 Panduan Menjalankan Proyek

### 1. Konfigurasi PostgreSQL

Pastikan service PostgreSQL berjalan di komputer Anda, lalu buat database dengan nama `db_data_mahasiswa`.

#### Melalui SQL Shell (psql) atau pgAdmin:
```sql
CREATE DATABASE db_data_mahasiswa;
```

### 2. Konfigurasi File `.env`

Buka file `.env` dan pastikan konfigurasi koneksi database sudah disesuaikan:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=db_data_mahasiswa
DB_USERNAME=postgres
DB_PASSWORD=isi_password_postgresql_anda
```

> **Catatan Keamanan:** Jangan pernah menyimpan password atau `APP_KEY` ke dalam repositori Git publik. File `.env` sudah masuk dalam `.gitignore`.

### 3. Menjalankan Migration dan Seeder

Jalankan perintah berikut di terminal:

```bash
# Jalankan migrasi tabel ke PostgreSQL
php artisan migrate

# Isi database dengan data sintetis untuk pengujian
php artisan db:seed
```

### 4. Menjalankan Server Lokal

Jalankan server pengembangan Laravel:

```bash
php artisan serve
```

Aplikasi dapat diakses melalui browser di:
- **Dashboard Web:** [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Data Mahasiswa:** [http://127.0.0.1:8000/mahasiswa](http://127.0.0.1:8000/mahasiswa)
- **Live API Tester & Dokumentasi:** [http://127.0.0.1:8000/dokumentasi](http://127.0.0.1:8000/dokumentasi)

---

## 📡 Daftar Endpoint REST API

| Method | Endpoint | Deskripsi | Respons |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/status` | Mengecek status aktif Sistem A | JSON (Online) |
| `GET` | `/api/mahasiswa/{npm}` | Mengambil data mahasiswa untuk Sistem B | JSON (Atribut aman) |
| `GET` | `/api/mahasiswa/{npm}/rdf` | Representasi RDF Turtle individual mahasiswa | `text/turtle` |

### Contoh Pemanggilan API:
```bash
curl http://127.0.0.1:8000/api/mahasiswa/22081010001
```

### Contoh Respons (HTTP 200 OK):
```json
{
  "success": true,
  "message": "Data mahasiswa berhasil diverifikasi.",
  "data": {
    "npm": "22081010001",
    "nama": "Ahmad Fauzi",
    "prodi": "Informatika",
    "angkatan": "2022",
    "uri_semantik": "http://example.org/resource/mahasiswa/22081010001"
  }
}
```

---

## 🧪 Menjalankan Pengujian Otomatis

Seluruh logika bisnis, enkripsi, dan REST API telah diuji dengan test suite:

```bash
php artisan test
```
Hasil: `8 passed (28 assertions)`.
