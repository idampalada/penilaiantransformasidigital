<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        // UNOR (parent)
        $unorId = DB::table('units')->insertGetId([
            'nama' => 'UNIT ORGANISASI',
            'jenis' => 'UNOR',
            'parent_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Unit di bawah UNOR
        DB::table('units')->insert([
            [
                'nama' => 'Sekretariat Jenderal',
                'jenis' => 'UNOR',
                'parent_id' => $unorId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Inspektorat Jenderal',
                'jenis' => 'UNOR',
                'parent_id' => $unorId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Pusdatin',
                'jenis' => 'UNOR',
                'parent_id' => $unorId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
