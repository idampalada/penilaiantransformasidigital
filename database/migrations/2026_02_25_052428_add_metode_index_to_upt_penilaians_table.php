<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('upt_penilaians', function (Blueprint $table) {
            $table->integer('metode_index')->default(0)->after('unit_id');
        });
    }

    public function down(): void
    {
        Schema::table('upt_penilaians', function (Blueprint $table) {
            $table->dropColumn('metode_index');
        });
    }
};