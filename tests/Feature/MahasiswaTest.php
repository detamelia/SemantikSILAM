<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MahasiswaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Uji dashboard Sistem A dapat diakses.
     */
    public function test_dashboard_can_be_rendered(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Portal Mahasiswa');
        $response->assertSee('Dashboard');
    }

    /**
     * Uji halaman indeks daftar mahasiswa dapat diakses.
     */
    public function test_mahasiswa_index_can_be_rendered(): void
    {
        Mahasiswa::create([
            'npm' => '22081010001',
            'nama' => 'Ahmad Fauzi',
            'prodi' => 'Informatika',
            'angkatan' => '2022',
            'tanggal_lahir' => '2004-03-15',
            'nama_ibu' => 'Siti Aminah',
        ]);

        $response = $this->get('/mahasiswa');
        $response->assertStatus(200);
        $response->assertSee('22081010001');
        $response->assertSee('Ahmad Fauzi');
        $response->assertSee('Informatika');
        // Tanggal lahir harus disamarkan ke tanggal 1
        $response->assertSee('01/03/2004');
    }

    /**
     * Uji penyimpanan data baru dan verifikasi enkripsi nama ibu.
     */
    public function test_can_create_mahasiswa_and_mother_name_is_encrypted(): void
    {
        $payload = [
            'npm' => '23081020099',
            'nama' => 'Rina Melati',
            'prodi' => 'Sistem Informasi',
            'angkatan' => '2023',
            'tanggal_lahir' => '2005-08-25',
            'nama_ibu' => 'Ratna Juwita',
        ];

        $response = $this->post('/mahasiswa', $payload);
        $response->assertRedirect('/mahasiswa');

        // Pastikan record tersimpan di database
        $this->assertDatabaseHas('mahasiswas', [
            'npm' => '23081020099',
            'nama' => 'Rina Melati',
            'prodi' => 'Sistem Informasi',
        ]);

        // Verifikasi langsung ke raw database bahwa kolom nama_ibu TIDAK tersimpan sebagai teks biasa
        $rawRecord = DB::table('mahasiswas')->where('npm', '23081020099')->first();
        $this->assertNotEquals('Ratna Juwita', $rawRecord->nama_ibu, 'Nama ibu tidak boleh tersimpan dalam plain text!');

        // Verifikasi ketika diakses melalui model Eloquent, didekripsi secara otomatis
        $mhs = Mahasiswa::where('npm', '23081020099')->first();
        $this->assertEquals('Ratna Juwita', $mhs->nama_ibu);
        $this->assertEquals('01/08/2005', $mhs->tanggal_lahir_masked);
    }

    /**
     * Uji REST API untuk Sistem B dengan prinsip minimalisasi data.
     */
    public function test_api_returns_only_required_attributes_for_sistem_b(): void
    {
        $mhs = Mahasiswa::create([
            'npm' => '22081010077',
            'nama' => 'Fajar Nugraha',
            'prodi' => 'Informatika',
            'angkatan' => '2022',
            'tanggal_lahir' => '2004-11-19',
            'nama_ibu' => 'Sri Rahayu',
        ]);

        $response = $this->getJson('/api/mahasiswa/22081010077');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'npm' => '22081010077',
                    'nama' => 'Fajar Nugraha',
                    'prodi' => 'Informatika',
                    'angkatan' => '2022',
                ],
            ]);

        // Pastikan nama ibu dan tanggal lahir TIDAK ada dalam respons API (Data Minimization)
        $json = $response->json();
        $this->assertArrayNotHasKey('nama_ibu', $json['data']);
        $this->assertArrayNotHasKey('tanggal_lahir', $json['data']);
        $this->assertArrayNotHasKey('id', $json['data']);
    }

    /**
     * Uji REST API mengembalikan 404 jika mahasiswa tidak ditemukan.
     */
    public function test_api_returns_404_when_mahasiswa_not_found(): void
    {
        $response = $this->getJson('/api/mahasiswa/00000000000');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
                'error_code' => 'MAHASISWA_NOT_FOUND',
            ]);
    }

    /**
     * Uji endpoint RDF Turtle untuk Semantic Web.
     */
    public function test_api_returns_rdf_turtle_format(): void
    {
        Mahasiswa::create([
            'npm' => '22081010088',
            'nama' => 'Dewi Anggraini',
            'prodi' => 'Sains Data',
            'angkatan' => '2022',
            'tanggal_lahir' => '2004-06-10',
            'nama_ibu' => 'Endah Pertiwi',
        ]);

        $response = $this->get('/api/mahasiswa/22081010088/rdf');
        $response->assertStatus(200);
        $this->assertStringContainsString('text/turtle', $response->headers->get('Content-Type'));
        $response->assertSee('mhs:Mahasiswa');
        $response->assertSee('22081010088');
        $response->assertSee('Dewi Anggraini');
    }
}
