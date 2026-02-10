<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('units', function (Blueprint $table) {
            if (Schema::hasColumn('units', 'parent_id')) {
                $table->dropColumn('parent_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('units', function (Blueprint $table) {
            $table->bigInteger('parent_id')->nullable();
        });
    }
};
