<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('zi_indikators', function (Blueprint $table) {

            $table->decimal('penilaian_mandiri', 4, 2)
                  ->nullable()
                  ->after('file_bukti_1');

            $table->decimal('penilaian_tahap_1', 4, 2)
                  ->nullable()
                  ->after('penilaian_mandiri');

            $table->text('note_penilaian_1')
                  ->nullable()
                  ->after('penilaian_tahap_1');

            $table->decimal('penilaian_tahap_2', 4, 2)
                  ->nullable()
                  ->after('file_bukti_2');

            $table->text('note_penilaian_2')
                  ->nullable()
                  ->after('penilaian_tahap_2');
        });
    }

    public function down(): void
    {
        Schema::table('zi_indikators', function (Blueprint $table) {
            $table->dropColumn([
                'penilaian_mandiri',
                'penilaian_tahap_1',
                'note_penilaian_1',
                'penilaian_tahap_2',
                'note_penilaian_2',
            ]);
        });
    }
};
