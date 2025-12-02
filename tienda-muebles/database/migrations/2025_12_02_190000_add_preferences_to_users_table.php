<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Preferencias del usuario
            $table->string('tema', 20)->default('light')->after('password'); // light o dark
            $table->string('moneda', 5)->default('€')->after('tema'); // €, $, £
            $table->integer('paginacion')->default(12)->after('moneda'); // 6, 12, 24, 48
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tema', 'moneda', 'paginacion']);
        });
    }
};
