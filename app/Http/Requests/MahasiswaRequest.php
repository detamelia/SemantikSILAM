<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MahasiswaRequest extends FormRequest
{
    /**
     * Tentukan apakah user berwenang membuat request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk data mahasiswa.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Mendapatkan ID mahasiswa jika dalam mode edit / update
        $mahasiswaId = $this->route('mahasiswa') ? $this->route('mahasiswa')->id : null;

        return [
            'npm' => [
                'required',
                'string',
                'min:5',
                'max:30',
                'regex:/^[A-Za-z0-9\.\-]+$/',
                Rule::unique('mahasiswas', 'npm')->ignore($mahasiswaId),
            ],
            'nama' => [
                'required',
                'string',
                'min:3',
                'max:150',
            ],
            'prodi' => [
                'required',
                'string',
                'max:100',
            ],
            'angkatan' => [
                'required',
                'digits:4',
                'integer',
                'between:2015,2030',
            ],
            'tanggal_lahir' => [
                'required',
                'date',
                'before:today',
            ],
            'nama_ibu' => [
                'required',
                'string',
                'min:2',
                'max:150',
            ],
        ];
    }

    /**
     * Pesan error validasi dalam bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'npm.required' => 'NPM wajib diisi sebagai identitas unik mahasiswa.',
            'npm.unique' => 'NPM ini sudah terdaftar di sistem. Gunakan NPM yang berbeda.',
            'npm.min' => 'NPM minimal harus memiliki 5 karakter.',
            'npm.max' => 'NPM maksimal 30 karakter.',
            'npm.regex' => 'NPM hanya boleh mengandung huruf, angka, titik, atau tanda hubung.',

            'nama.required' => 'Nama lengkap mahasiswa wajib diisi.',
            'nama.min' => 'Nama mahasiswa minimal terdiri dari 3 karakter.',
            'nama.max' => 'Nama mahasiswa maksimal 150 karakter.',

            'prodi.required' => 'Program studi wajib dipilih atau diisi.',
            'prodi.max' => 'Nama program studi maksimal 100 karakter.',

            'angkatan.required' => 'Tahun angkatan masuk wajib diisi.',
            'angkatan.digits' => 'Format tahun angkatan harus berupa 4 digit angka (contoh: 2023).',
            'angkatan.between' => 'Tahun angkatan harus berada dalam rentang tahun 2015 hingga 2030.',

            'tanggal_lahir.required' => 'Tanggal lahir asli mahasiswa wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',

            'nama_ibu.required' => 'Nama ibu kandung wajib diisi untuk verifikasi identitas (akan dienkripsi otomatis).',
            'nama_ibu.min' => 'Nama ibu kandung minimal terdiri dari 2 karakter.',
            'nama_ibu.max' => 'Nama ibu kandung maksimal 150 karakter.',
        ];
    }
}
