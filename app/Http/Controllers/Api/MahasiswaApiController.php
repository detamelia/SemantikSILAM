<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaApiController extends Controller
{
    /**
     * Endpoint status API untuk memverifikasi kesiapan Sistem A.
     * GET /api/status
     */
    public function status(): JsonResponse
    {
        return response()->json([
            'status' => 'online',
            'sistem' => 'Sistem A - Sistem Informasi Data Mahasiswa',
            'versi' => '1.0.0',
            'tujuan' => 'Penyedia data master mahasiswa untuk integrasi Sistem B & Semantic Web',
            'timestamp' => now()->toIso8601String(),
        ], 200);
    }

    /**
     * Mengambil data mahasiswa berdasarkan NPM untuk keperluan Sistem B.
     * GET /api/mahasiswa/{npm}
     *
     * Menerapkan prinsip Data Minimization:
     * Hanya mengembalikan atribut yang diizinkan (NPM, Nama, Program Studi, Angkatan, URI Semantik).
     * TIDAK mengembalikan nama_ibu, tanggal lahir lengkap, password, token, atau internal id.
     */
    public function getByNpm(Request $request, string $npm): JsonResponse
    {
        // 1. Opsi Pemeriksaan API Key / Token untuk keamanan sebelum integrasi final
        $configuredKey = config('services.sistem_a.api_key', env('SISTEM_A_API_KEY'));
        if (!empty($configuredKey)) {
            $clientKey = $request->header('X-API-KEY') ?? $request->query('api_key');
            if ($clientKey !== $configuredKey) {
                return response()->json([
                    'success' => false,
                    'error_code' => 'UNAUTHORIZED',
                    'message' => 'Akses ditolak. Header X-API-KEY tidak valid atau belum disertakan.',
                ], 401);
            }
        }

        // 2. Validasi format NPM
        $validator = Validator::make(['npm' => $npm], [
            'npm' => 'required|string|min:4|max:30|regex:/^[A-Za-z0-9\.\-]+$/',
        ], [
            'npm.required' => 'Parameter NPM wajib disertakan.',
            'npm.regex' => 'Format NPM tidak valid.',
            'npm.min' => 'NPM terlalu pendek.',
            'npm.max' => 'NPM melebihi batas panjang.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error_code' => 'INVALID_PARAMETER',
                'message' => 'Parameter NPM tidak valid.',
                'errors' => $validator->errors()->all(),
            ], 422);
        }

        // 3. Pencarian mahasiswa berdasarkan NPM
        $cleanNpm = trim($npm);
        $mahasiswa = Mahasiswa::where('npm', $cleanNpm)->first();

        // 4. Penanganan ketika mahasiswa tidak ditemukan
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'error_code' => 'MAHASISWA_NOT_FOUND',
                'message' => "Mahasiswa dengan NPM '{$cleanNpm}' tidak ditemukan pada basis data Sistem A.",
            ], 404);
        }

        // 5. Kembalikan data dengan prinsip minimalisasi data (hanya atribut yang diizinkan)
        return response()->json([
            'success' => true,
            'message' => 'Data mahasiswa berhasil diverifikasi.',
            'data' => $mahasiswa->toSistemBApiPayload(),
        ], 200, [
            'Content-Type' => 'application/json; charset=UTF-8',
        ]);
    }

    /**
     * Endpoint Semantik Web: Mengembalikan data mahasiswa dalam format RDF Turtle.
     * GET /api/mahasiswa/{npm}/rdf
     */
    public function getRdfTurtle(string $npm): \Illuminate\Http\Response|JsonResponse
    {
        $cleanNpm = trim($npm);
        $mahasiswa = Mahasiswa::where('npm', $cleanNpm)->first();

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => "Data mahasiswa dengan NPM '{$cleanNpm}' tidak ditemukan untuk representasi RDF.",
            ], 404);
        }

        // Susun RDF Turtle dengan namespace yang konsisten
        $ttl = "@prefix rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> .\n" .
               "@prefix rdfs: <http://www.w3.org/2000/01/rdf-schema#> .\n" .
               "@prefix owl: <http://www.w3.org/2002/07/owl#> .\n" .
               "@prefix xsd: <http://www.w3.org/2001/XMLSchema#> .\n" .
               "@prefix mhs: <" . Mahasiswa::ONTOLOGY_NAMESPACE . "> .\n" .
               "@prefix res: <" . Mahasiswa::RESOURCE_BASE_URI . "> .\n\n" .
               "# Individual Mahasiswa\n" .
               "<" . $mahasiswa->semantic_uri . ">\n" .
               "    a mhs:Mahasiswa ;\n" .
               "    mhs:npm \"" . addslashes($mahasiswa->npm) . "\"^^xsd:string ;\n" .
               "    mhs:namaMahasiswa \"" . addslashes($mahasiswa->nama) . "\"^^xsd:string ;\n" .
               "    mhs:programStudi \"" . addslashes($mahasiswa->prodi) . "\"^^xsd:string ;\n" .
               "    mhs:angkatan \"" . addslashes($mahasiswa->angkatan) . "\"^^xsd:gYear ;\n" .
               "    rdfs:label \"" . addslashes($mahasiswa->nama) . "\" .\n";

        return response($ttl, 200, [
            'Content-Type' => 'text/turtle; charset=UTF-8',
        ]);
    }
}
