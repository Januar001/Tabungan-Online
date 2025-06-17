<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Memulai proses seeding data wilayah Indonesia...');

        // Ambil data provinsi
        $responseProvinsi = Http::get('https://januar001.github.io/api-wilayah-indonesia/api/provinces.json');
        $provinsis = $responseProvinsi->json();
        foreach ($provinsis as $provinsi) {
            DB::table('provinsis')->insert(['id' => $provinsi['id'], 'nama' => $provinsi['name']]);

            // Ambil data kabupaten untuk setiap provinsi
            $responseKabupaten = Http::get("https://januar001.github.io/api-wilayah-indonesia/api/regencies/{$provinsi['id']}.json");
            $kabupatens = $responseKabupaten->json();
            foreach ($kabupatens as $kabupaten) {
                DB::table('kabupatens')->insert([
                    'id' => $kabupaten['id'],
                    'provinsi_id' => $kabupaten['province_id'],
                    'nama' => $kabupaten['name']
                ]);

                // Ambil data kecamatan untuk setiap kabupaten
                $responseKecamatan = Http::get("https://januar001.github.io/api-wilayah-indonesia/api/districts/{$kabupaten['id']}.json");
                $kecamatans = $responseKecamatan->json();
                foreach ($kecamatans as $kecamatan) {
                    DB::table('kecamatans')->insert([
                        'id' => $kecamatan['id'],
                        'kabupaten_id' => $kecamatan['regency_id'],
                        'nama' => $kecamatan['name']
                    ]);
                    
                    // Seeding data desa bisa sangat lama, bisa di-skip jika tidak terlalu butuh di awal
                }
            }
        }

        $this->command->info('Seeding data wilayah (Provinsi, Kabupaten, Kecamatan) selesai.');
    }
}
