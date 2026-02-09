<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin_unor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'penilai_eksternal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
