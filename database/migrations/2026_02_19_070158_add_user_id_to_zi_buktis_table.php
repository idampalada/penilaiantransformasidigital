<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('zi_buktis', function (Blueprint $table) {

            // Tambah kolom user_id
            $table->unsignedBigInteger('user_id')
                  ->nullable()
                  ->after('unit_id');

            // Foreign key ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('zi_buktis', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
