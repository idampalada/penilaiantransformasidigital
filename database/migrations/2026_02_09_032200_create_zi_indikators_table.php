<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('zi_indikators', function (Blueprint $table) {
            $table->id();

            $table->integer('nomor');
            $table->string('kriteria');
            $table->string('indikator');
            $table->string('komponen');
            $table->text('metode_pengukuran');
            $table->text('penilaian');
            $table->text('bukti_persyaratan');

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zi_indikators');
    }
};
