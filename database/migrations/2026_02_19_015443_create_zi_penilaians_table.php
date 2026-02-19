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
        Schema::create('zi_penilaians', function (Blueprint $table) {
            $table->id();

            // Relasi ke indikator
            $table->foreignId('indikator_id')
                  ->constrained('zi_indikators')
                  ->cascadeOnDelete();

            // Relasi ke unit
            $table->foreignId('unit_id')
                  ->constrained('units')
                  ->cascadeOnDelete();

            // ===== 7 KOLOM YANG DIPINDAHKAN =====
            $table->string('file_bukti_1')->nullable();
            $table->string('file_bukti_2')->nullable();

            $table->decimal('penilaian_mandiri', 8, 2)->nullable();

            $table->decimal('penilaian_tahap_1', 8, 2)->nullable();
            $table->text('note_penilaian_1')->nullable();

            $table->decimal('penilaian_tahap_2', 8, 2)->nullable();
            $table->text('note_penilaian_2')->nullable();

            $table->timestamps();

            // Supaya 1 unit hanya punya 1 penilaian per indikator
            $table->unique(['indikator_id', 'unit_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zi_penilaians');
    }
};
