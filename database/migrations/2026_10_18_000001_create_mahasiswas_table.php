<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('npm', 30)->unique()->comment('NPM sebagai identitas unik mahasiswa');
            $table->string('nama', 150)->comment('Nama lengkap mahasiswa');
            $table->string('prodi', 100)->comment('Program Studi mahasiswa');
            $table->string('angkatan', 4)->comment('Tahun angkatan masuk');
            $table->date('tanggal_lahir')->comment('Tanggal lahir asli mahasiswa (disimpan aman)');
            $table->text('nama_ibu')->comment('Nama ibu kandung yang tersimpan dalam bentuk terenkripsi');
            $table->timestamps();

            // Index tambahan untuk pencarian cepat
            $table->index('nama');
            $table->index('prodi');
            $table->index('angkatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
