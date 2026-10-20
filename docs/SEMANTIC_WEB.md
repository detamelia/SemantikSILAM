# Spesifikasi Pemodelan Semantic Web (Sistem Data Mahasiswa)

Catatan teknis perancangan ontologi dan representasi data mahasiswa berbasis RDF/OWL untuk kebutuhan integrasi antarsistem.

---

## 1. Skema URI dan Namespace

Setiap entitas mahasiswa diidentifikasi menggunakan format URI berikut:

- **Namespace Ontologi (`mhs:`):** `http://example.org/ontology/mahasiswa#`
- **Resource URI (`res:`):** `http://example.org/resource/mahasiswa/{npm}`
- **Standar Kosakata:** RDF, RDFS, OWL, XML Schema (XSD)

Penggunaan NPM sebagai subject URI didasarkan pada sifatnya yang unik dan permanen (*persistent identifier*) untuk setiap mahasiswa.

---

## 2. Definisi Kelas (Ontology Classes)

### `mhs:Mahasiswa`
- **URI:** `http://example.org/ontology/mahasiswa#Mahasiswa`
- **Deskripsi:** Kelas entitas mahasiswa aktif.
- **Superclass:** `owl:Thing`

### `mhs:ProgramStudi`
- **URI:** `http://example.org/ontology/mahasiswa#ProgramStudi`
- **Deskripsi:** Kelas unit program studi akademik.

---

## 3. Definisi Properti (Data Properties)

| Properti | Domain | Range | Keterangan |
| :--- | :--- | :--- | :--- |
| `mhs:npm` | `mhs:Mahasiswa` | `xsd:string` | Nomor Pokok Mahasiswa (kunci unik / functional property). |
| `mhs:namaMahasiswa` | `mhs:Mahasiswa` | `xsd:string` | Nama lengkap mahasiswa. |
| `mhs:programStudi` | `mhs:Mahasiswa` | `xsd:string` | Nama program studi. |
| `mhs:angkatan` | `mhs:Mahasiswa` | `xsd:gYear` | Tahun angkatan masuk. |

---

## 4. Kebijakan Privasi Data

1. **Nama Ibu Kandung:**
   - Disimpan dalam bentuk terenkripsi (AES-256) pada database.
   - Tidak diekspos pada pemodelan RDF maupun respons REST API.
2. **Tanggal Lahir:**
   - Nilai tanggal lahir asli disimpan di database internal.
   - Pada antarmuka dan keluaran publik, tanggal disamarkan ke tanggal 1 (format `01/MM/YYYY`).
3. **Atribut untuk Sistem Layanan (Sistem B):**
   - Hanya menyertakan: `npm`, `nama`, `prodi`, dan `angkatan`.

---

## 5. Contoh Representasi RDF Turtle

```turtle
@prefix rdf:  <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .
@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .
@prefix xsd:  <http://www.w3.org/2001/XMLSchema#> .
@prefix mhs:  <http://example.org/ontology/mahasiswa#> .
@prefix res:  <http://example.org/resource/mahasiswa/> .

<http://example.org/resource/mahasiswa/22081010001>
    a mhs:Mahasiswa ;
    mhs:npm "22081010001"^^xsd:string ;
    mhs:namaMahasiswa "Ahmad Fauzi"^^xsd:string ;
    mhs:programStudi "Informatika"^^xsd:string ;
    mhs:angkatan "2022"^^xsd:gYear ;
    rdfs:label "Ahmad Fauzi" .
```

---

## 6. Integrasi dengan Sistem Pengajuan Surat (Sistem B)

Pada saat Sistem B memproses pengajuan surat:
1. Sistem B melakukan permintaan data ke endpoint `GET /api/mahasiswa/{npm}`.
2. Respons data diverifikasi untuk memastikan status mahasiswa.
3. Objek surat pada Sistem B dapat dihubungkan ke URI mahasiswa:
   ```turtle
   <http://example.org/resource/surat/SRT-2026-001>
       a surat:SuratKeterangan ;
       surat:diajukanOleh <http://example.org/resource/mahasiswa/22081010001> .
   ```
