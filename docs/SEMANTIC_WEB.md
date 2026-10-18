# Dokumentasi Pemodelan Semantic Web - Sistem A (Data Mahasiswa)

Dokumen ini menjelaskan pemodelan ontologi, penetapan URI, dan persiapan representasi data mahasiswa berbasis **Resource Description Framework (RDF)** dan **Web Ontology Language (OWL)** untuk diintegrasikan dengan Sistem B pada tahap berikutnya.

---

## 1. Penetapan Namespace dan URI Konsisten

Untuk memastikan setiap entitas mahasiswa dapat diidentifikasi secara unik dan dapat ditautkan (*linked data*), Sistem A menetapkan format URI standar:

| Tipe | Format URI | Contoh |
| :--- | :--- | :--- |
| **Ontology Namespace** | `http://example.org/ontology/mahasiswa#` (Prefix: `mhs:`) | `mhs:Mahasiswa`, `mhs:npm` |
| **Resource Entity (Individu)** | `http://example.org/resource/mahasiswa/{NPM}` (Prefix: `res:`) | `res:22081010001` |
| **Vocabulary Standard** | RDF, RDFS, OWL, XSD | `rdf:type`, `owl:Class`, `xsd:string` |

### Keunggulan Penggunaan NPM sebagai Subject URI
NPM (*Nomor Pokok Mahasiswa*) bersifat unik, tetap, dan terverifikasi secara institusional, sehingga memenuhi prinsip **Persistent Identifier (PID)** dalam Semantic Web.

---

## 2. Definisi Kelas (Ontology Classes)

Ontologi Sistem A mendefinisikan kelas utama:

### `mhs:Mahasiswa`
- **URI:** `http://example.org/ontology/mahasiswa#Mahasiswa`
- **Deskripsi:** Kelas yang merepresentasikan individu yang terdaftar sebagai mahasiswa aktif.
- **RDFS Superclass:** `owl:Thing`

### `mhs:ProgramStudi`
- **URI:** `http://example.org/ontology/mahasiswa#ProgramStudi`
- **Deskripsi:** Kelas yang merepresentasikan unit akademik atau program studi.

---

## 3. Definisi Properti (Data Properties)

| Properti | Domain | Range | Keterangan |
| :--- | :--- | :--- | :--- |
| `mhs:npm` | `mhs:Mahasiswa` | `xsd:string` | Nomor Pokok Mahasiswa (Functional Property / Unique Key). |
| `mhs:namaMahasiswa` | `mhs:Mahasiswa` | `xsd:string` | Nama lengkap resmi mahasiswa. |
| `mhs:programStudi` | `mhs:Mahasiswa` | `xsd:string` | Program studi yang ditempuh mahasiswa. |
| `mhs:angkatan` | `mhs:Mahasiswa` | `xsd:gYear` | Tahun pertama mahasiswa terdaftar. |

---

## 4. Perlindungan Data dan Prinsip *Data Minimization*

Sesuai aturan keamanan informasi dan ketentuan mata kuliah:
1. **Nama Ibu Kandung:**
   - Disimpan dalam bentuk **terenkripsi** di PostgreSQL menggunakan enkripsi AES-256 bawaan Laravel.
   - **TIDAK** dipublikasikan ke dalam RDF/OWL atau REST API untuk publik maupun Sistem B.
2. **Tanggal Lahir:**
   - Tanggal lahir asli disimpan secara aman di PostgreSQL.
   - Pada antarmuka dan laporan publik, tanggal lahir **disamarkan selalu menjadi tanggal 1** (misalnya `01/03/2004`).
3. **Atribut Terbuka untuk Sistem B:**
   - Hanya atribut yang dibutuhkan untuk validasi identitas dan pembuatan permohonan surat: `npm`, `nama`, `prodi`, dan `angkatan`.

---

## 5. Contoh Representasi RDF Turtle Individual Mahasiswa

```turtle
@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
@prefix owl: <http://www.w3.org/2002/07/owl#> .
@prefix xsd: <http://www.w3.org/2001/XMLSchema#> .
@prefix mhs: <http://example.org/ontology/mahasiswa#> .
@prefix res: <http://example.org/resource/mahasiswa/> .

<http://example.org/resource/mahasiswa/22081010001>
    a mhs:Mahasiswa ;
    mhs:npm "22081010001"^^xsd:string ;
    mhs:namaMahasiswa "Ahmad Fauzi"^^xsd:string ;
    mhs:programStudi "Informatika"^^xsd:string ;
    mhs:angkatan "2022"^^xsd:gYear ;
    rdfs:label "Ahmad Fauzi" .
```

---

## 6. Integrasi dengan Sistem B pada Tahap Berikutnya

Pada tahap selanjutnya:
- **Sistem B (Sistem Pengajuan Surat Mahasiswa)** akan memanggil REST API Sistem A: `GET /api/mahasiswa/{npm}`.
- Sistem B kemudian dapat mengaitkan objek surat `surat:SuratKeterangan` dengan individu mahasiswa `res:{npm}` menggunakan relasi ontologi:
  ```turtle
  surat:Surat001 surat:diajukanOleh res:22081010001 .
  ```
- Dengan demikian, integrasi antarsistem memenuhi kriteria Semantic Web secara utuh.
