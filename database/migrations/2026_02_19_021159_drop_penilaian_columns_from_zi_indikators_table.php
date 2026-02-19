<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('zi_indikators', function (Blueprint $table) {

            $table->dropColumn([
                'file_bukti_1',
                'file_bukti_2',
                'penilaian_mandiri',
                'penilaian_tahap_1',
                'note_penilaian_1',
                'penilaian_tahap_2',
                'note_penilaian_2',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('zi_indikators', function (Blueprint $table) {

            $table->string('file_bukti_1')->nullable();
            $table->string('file_bukti_2')->nullable();

            $table->decimal('penilaian_mandiri', 8, 2)->nullable();
            $table->decimal('penilaian_tahap_1', 8, 2)->nullable();
            $table->text('note_penilaian_1')->nullable();

            $table->decimal('penilaian_tahap_2', 8, 2)->nullable();
            $table->text('note_penilaian_2')->nullable();
        });
    }
};
