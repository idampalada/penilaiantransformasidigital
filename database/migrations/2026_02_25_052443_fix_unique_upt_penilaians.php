<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('upt_penilaians', function (Blueprint $table) {

            // 🔴 Drop unique lama (yang benar namanya _key)
            $table->dropUnique('upt_penilaians_indikator_id_unit_id_key');

            // 🟢 Tambah unique baru 3 kolom
            $table->unique(
                ['indikator_id', 'unit_id', 'metode_index'],
                'upt_penilaians_unique_row'
            );
        });
    }

    public function down(): void
    {
        Schema::table('upt_penilaians', function (Blueprint $table) {

            $table->dropUnique('upt_penilaians_unique_row');

            $table->unique(
                ['indikator_id', 'unit_id'],
                'upt_penilaians_indikator_id_unit_id_key'
            );
        });
    }
};