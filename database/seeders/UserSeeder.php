<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = DB::table('roles')->pluck('id', 'name');

        $superadminRoleId = $roles['superadmin'] ?? null;
        $adminUnorRoleId  = $roles['admin_unor'] ?? null;
        $penilaiRoleId    = $roles['penilai_eksternal'] ?? null;

        $pusdatin = DB::table('units')
            ->where('nama', 'Pusat Data dan Teknologi Informasi')
            ->first();

        // SUPERADMIN
        if ($superadminRoleId) {
            DB::table('users')->updateOrInsert(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Super Admin',
                    'password' => Hash::make('password'),
                    'role_id' => $superadminRoleId,
                    'unit_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // ADMIN UNOR
        if ($adminUnorRoleId && $pusdatin) {
            DB::table('users')->updateOrInsert(
                ['email' => 'admin@pusdatin.go.id'],
                [
                    'name' => 'Admin UNOR Pusdatin',
                    'password' => Hash::make('password'),
                    'role_id' => $adminUnorRoleId,
                    'unit_id' => $pusdatin->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // PENILAI EKSTERNAL
        if ($penilaiRoleId) {
            DB::table('users')->updateOrInsert(
                ['email' => 'penilai@eksternal.go.id'],
                [
                    'name' => 'Penilai Eksternal',
                    'password' => Hash::make('password'),
                    'role_id' => $penilaiRoleId,
                    'unit_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
