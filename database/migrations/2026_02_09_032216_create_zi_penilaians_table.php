<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('zi_penilaians', function (Blueprint $table) {
            $table->id();

            $table->foreignId('indikator_id')
                ->constrained('zi_indikators')
                ->cascadeOnDelete();

            $table->foreignId('unit_id')
                ->constrained('units')
                ->cascadeOnDelete();

            $table->year('tahun');

            $table->string('file_bukti')->nullable(); // PDF only

            $table->decimal('nilai_internal', 5, 2)->nullable();
            $table->decimal('nilai_eksternal', 5, 2)->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->unique(['indikator_id', 'unit_id', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('zi_penilaians');
    }
};
