<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukti_files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jawaban_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_files');
    }
};
