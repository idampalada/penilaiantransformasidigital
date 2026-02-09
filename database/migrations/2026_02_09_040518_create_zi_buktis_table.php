<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('zi_buktis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('zi_indikator_id')
                  ->constrained('zi_indikators')
                  ->cascadeOnDelete();

            $table->unsignedInteger('unit_id'); // UNOR
            $table->unsignedTinyInteger('metode_index')->nullable(); 
            // null = tidak split
            // 0,1,2 = index metode

            $table->string('file_name');
            $table->string('file_path');

            $table->year('tahun')->default(2025);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zi_buktis');
    }
};
