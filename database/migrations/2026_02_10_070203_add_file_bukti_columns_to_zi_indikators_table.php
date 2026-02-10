<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('zi_indikators', function (Blueprint $table) {
            $table->string('file_bukti_1')->nullable()->after('penilaian_tahap_1');
            $table->string('file_bukti_2')->nullable()->after('file_bukti_1');
        });
    }

    public function down(): void
    {
        Schema::table('zi_indikators', function (Blueprint $table) {
            $table->dropColumn(['file_bukti_1', 'file_bukti_2']);
        });
    }
};
