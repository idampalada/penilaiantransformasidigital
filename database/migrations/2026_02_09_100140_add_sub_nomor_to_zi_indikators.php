<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1️⃣ Tambah kolom dulu (nullable supaya tidak error)
        Schema::table('zi_indikators', function (Blueprint $table) {
            $table->integer('sub_nomor')
                  ->nullable()
                  ->after('nomor');
        });

        // 2️⃣ Isi data lama dengan default (misal: 1)
        DB::table('zi_indikators')
            ->whereNull('sub_nomor')
            ->update(['sub_nomor' => 1]);

        // 3️⃣ Ubah jadi NOT NULL
        Schema::table('zi_indikators', function (Blueprint $table) {
            $table->integer('sub_nomor')
                  ->nullable(false)
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zi_indikators', function (Blueprint $table) {
            $table->dropColumn('sub_nomor');
        });
    }
};
