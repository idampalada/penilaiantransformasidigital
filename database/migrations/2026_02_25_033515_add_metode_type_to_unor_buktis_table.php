<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('unor_buktis', function (Blueprint $table) {
            $table->tinyInteger('metode_type')
                  ->default(1)
                  ->after('metode_index');
        });
    }

    public function down(): void
    {
        Schema::table('unor_buktis', function (Blueprint $table) {
            $table->dropColumn('metode_type');
        });
    }
};