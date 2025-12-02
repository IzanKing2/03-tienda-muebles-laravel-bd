<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        //Añadimos la columna 'name' (nullable para evitar problemas)
        Schema::table('roles', function (Blueprint $table) {
            $table->string('name', 50)->nullable()->after('id');
        });

        //Copiamos los valores existentes de 'nombre' a 'name'
        DB::statement("UPDATE roles SET name = nombre WHERE name IS NULL");

        //Si quieres que 'name' sea único como 'nombre', crea índice único
        Schema::table('roles', function (Blueprint $table) {
            $table->unique('name');
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            // Si existe índice único, lo quitamos y la columna
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            // dropUnique con array usa el índice automático; si da error puedes comentar la línea y borrarlo manualmente
            $table->dropUnique(['name']);
            $table->dropColumn('name');
        });
    }
};
