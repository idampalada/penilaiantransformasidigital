<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jawabans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('penilaian_id')->constrained();
            $table->foreignId('pertanyaan_id')->constrained();

            $table->decimal('nilai_internal', 5, 2)->nullable();
            $table->text('catatan_internal')->nullable();

            $table->decimal('nilai_eksternal', 5, 2)->nullable();
            $table->text('catatan_eksternal')->nullable();

            $table->timestamps();

            $table->unique(['penilaian_id', 'pertanyaan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawabans');
    }
};
