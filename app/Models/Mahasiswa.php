<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     *
     * @var string
     */
    protected $table = 'mahasiswas';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'npm',
        'nama',
        'prodi',
        'angkatan',
        'tanggal_lahir',
        'nama_ibu',
    ];

    /**
     * Atribut yang disembunyikan secara default saat serialisasi JSON.
     * Melindungi data privat (prinsip minimalisasi data).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'nama_ibu',
    ];

    /**
     * Definisi konstanta Namespace Semantik Web.
     */
    public const ONTOLOGY_NAMESPACE = 'http://example.org/ontology/mahasiswa#';
    public const RESOURCE_BASE_URI = 'http://example.org/resource/mahasiswa/';

    /**
     * Casting tipe data dan enkripsi otomatis.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            // Enkripsi nama ibu secara otomatis menggunakan Laravel Encryption (AES-256-CBC)
            'nama_ibu' => 'encrypted',
        ];
    }

    /**
     * Accessor: Menyamarkan tanggal lahir menjadi tanggal 1 sesuai arahan tugas.
     * Tanggal lahir asli tetap tersimpan aman di database.
     */
    public function getTanggalLahirMaskedAttribute(): string
    {
        if (!$this->tanggal_lahir) {
            return '-';
        }

        $date = Carbon::parse($this->tanggal_lahir);

        // Disamarkan selalu menjadi tanggal 01
        return $date->format('01/m/Y');
    }

    /**
     * Accessor: Tanggal lahir tersamar format teks Indonesia (contoh: 1 Mei 2003).
     */
    public function getTanggalLahirMaskedTextAttribute(): string
    {
        if (!$this->tanggal_lahir) {
            return '-';
        }

        $date = Carbon::parse($this->tanggal_lahir);
        $bulanIndo = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return '1 ' . ($bulanIndo[$date->month] ?? $date->format('F')) . ' ' . $date->year;
    }

    /**
     * Accessor: URI unik konsisten untuk Semantic Web RDF/OWL.
     */
    public function getSemanticUriAttribute(): string
    {
        return self::RESOURCE_BASE_URI . $this->npm;
    }

    /**
     * Scope query untuk pencarian berdasarkan NPM, nama, atau prodi.
     */
    public function scopeSearch($query, ?string $term)
    {
        if (!empty($term)) {
            $term = trim($term);
            return $query->where(function ($q) use ($term) {
                $q->where('npm', 'like', "%{$term}%")
                  ->orWhere('nama', 'like', "%{$term}%")
                  ->orWhere('prodi', 'like', "%{$term}%");
            });
        }

        return $query;
    }

    /**
     * Format data aman untuk kebutuhan REST API Sistem B (Minimalisasi Data).
     * Hanya mengembalikan atribut yang diizinkan untuk verifikasi surat mahasiswa.
     * TIDAK mengembalikan nama_ibu, tanggal_lahir lengkap, id internal, ataupun token.
     */
    public function toSistemBApiPayload(): array
    {
        return [
            'npm' => $this->npm,
            'nama' => $this->nama,
            'prodi' => $this->prodi,
            'angkatan' => $this->angkatan,
            'uri_semantik' => $this->semantic_uri,
        ];
    }
}
