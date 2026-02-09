<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ZiIndikator;

class ZiIndikatorSeeder extends Seeder
{
    public function run(): void
    {
        ZiIndikator::truncate();

        ZiIndikator::create([
            'nomor' => 1,
            'kriteria' => 'Tata Kelola SPBE',
            'indikator' => 'Tingkat Kepatuhan SPBE',
            'komponen' => 'Tingkat Kematangan Kebijakan Internal',

            // ⬇️ PAKAI DELIMITER ||
            'metode_pengukuran' =>
                "1. Dokumen Rencana Strategis Unit Organisasi / Unit Kerja / UPT
yang di dalamnya terdapat strategi, rencana, dan target SPBE yang sudah disahkan
||
2. Dokumen Kebijakan SPBE
(Dapat berupa SE Pimpinan Unit Organisasi / Unit Kerja / UPT
atau SK Tim Pengelola SPBE Unit Organisasi / Unit Kerja / UPT)
yang sudah disahkan",

            'penilaian' =>
    // Metode 1
    "10 : Dokumen Draft Rencana Strategis 2025-2029 UNOR/UNKER/UPT di dalamnya terdapat strategi, rencana, dan target SPBE serta sudah diparaf pimpinan UNOR/UNKER/UPT
;;7 : Dokumen Strategi, Rencana, dan Target SPBE terpisah dari Renstra UNOR/UNKER/UPT serta sudah diparaf pimpinan UNOR/UNKER/UPT
;;5 : Dokumen belum disahkan
;;0 : Belum ada dokumen
||
     Metode 2
10 : Dokumen sudah disahkan
;;5 : Dokumen belum disahkan
;;0 : Belum ada dokumen",


            'bukti_persyaratan' =>
                "1. Dokumen Draft Renstra yang sudah diparaf pimpinan UNOR/UNKER/UPT
2. Surat Usulan untuk draft SE Pimpinan Unit Organisasi / Unit Kerja / UPT
atau SK Tim Pengelola SPBE Unit Organisasi / Unit Kerja / UPT",

            'is_active' => true,
        ]);
    }
}
