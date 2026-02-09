<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminUnorRole = DB::table('roles')->where('name', 'admin_unor')->first();
        $penilaiRole   = DB::table('roles')->where('name', 'penilai_eksternal')->first();

        $unor = DB::table('units')->whereNull('parent_id')->first();

        // Admin UNOR
        DB::table('users')->insert([
            'name' => 'Admin UNOR',
            'email' => 'admin@unor.go.id',
            'password' => Hash::make('password'),
            'role_id' => $adminUnorRole->id,
            'unit_id' => $unor->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Penilai Eksternal
        DB::table('users')->insert([
            'name' => 'Penilai Eksternal',
            'email' => 'penilai@eksternal.go.id',
            'password' => Hash::make('password'),
            'role_id' => $penilaiRole->id,
            'unit_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
