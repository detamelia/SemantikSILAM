<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data sintetis mahasiswa untuk pengujian (bukan data mahasiswa asli)
        $dataMahasiswa = [
            [
                'npm' => '22081010001',
                'nama' => 'Ahmad Fauzi',
                'prodi' => 'Informatika',
                'angkatan' => '2022',
                'tanggal_lahir' => '2004-03-15',
                'nama_ibu' => 'Siti Aminah',
            ],
            [
                'npm' => '22081010025',
                'nama' => 'Budi Pratama',
                'prodi' => 'Informatika',
                'angkatan' => '2022',
                'tanggal_lahir' => '2003-11-20',
                'nama_ibu' => 'Nurul Hidayah',
            ],
            [
                'npm' => '23081020012',
                'nama' => 'Citra Kirana',
                'prodi' => 'Sistem Informasi',
                'angkatan' => '2023',
                'tanggal_lahir' => '2005-07-09',
                'nama_ibu' => 'Dewi Sartika',
            ],
            [
                'npm' => '23081020044',
                'nama' => 'Dimas Anggara',
                'prodi' => 'Sistem Informasi',
                'angkatan' => '2023',
                'tanggal_lahir' => '2004-12-04',
                'nama_ibu' => 'Ratna Wulandari',
            ],
            [
                'npm' => '21081030018',
                'nama' => 'Eka Rahmawati',
                'prodi' => 'Teknik Elektro',
                'angkatan' => '2021',
                'tanggal_lahir' => '2003-05-28',
                'nama_ibu' => 'Sri Wahyuni',
            ],
            [
                'npm' => '24081040005',
                'nama' => 'Fahri Ramadhan',
                'prodi' => 'Sains Data',
                'angkatan' => '2024',
                'tanggal_lahir' => '2006-01-14',
                'nama_ibu' => 'Endang Susilowati',
            ],
            [
                'npm' => '24081040022',
                'nama' => 'Gita Permata',
                'prodi' => 'Sains Data',
                'angkatan' => '2024',
                'tanggal_lahir' => '2005-09-30',
                'nama_ibu' => 'Marlina Safitri',
            ],
            [
                'npm' => '23081050010',
                'nama' => 'Hendra Wijaya',
                'prodi' => 'Teknologi Informasi',
                'angkatan' => '2023',
                'tanggal_lahir' => '2004-08-22',
                'nama_ibu' => 'Kartini Indah',
            ],
        ];

        foreach ($dataMahasiswa as $data) {
            // Gunakan updateOrCreate agar seeder bersifat idempotent (dapat dijalankan berulang)
            Mahasiswa::updateOrCreate(
                ['npm' => $data['npm']],
                $data
            );
        }
    }
}
