<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('unor_penilaians', function (Blueprint $table) {

            // 🔴 Drop unique lama
            $table->dropUnique('unor_penilaians_indikator_id_unit_id_unique');

            // 🟢 Tambah unique baru (3 kolom)
            $table->unique(
                ['indikator_id', 'unit_id', 'metode_index'],
                'unor_penilaians_unique_row'
            );
        });
    }

    public function down(): void
    {
        Schema::table('unor_penilaians', function (Blueprint $table) {

            $table->dropUnique('unor_penilaians_unique_row');

            $table->unique(
                ['indikator_id', 'unit_id'],
                'unor_penilaians_indikator_id_unit_id_unique'
            );
        });
    }
};