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
        Schema::table('zi_indikators', function (Blueprint $table) {

            // Menyimpan opsi nilai dalam format: 3,5,7,9
            $table->string('opsi_nilai')
                  ->nullable()
                  ->after('bukti_persyaratan');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zi_indikators', function (Blueprint $table) {

            $table->dropColumn('opsi_nilai');

        });
    }
};
