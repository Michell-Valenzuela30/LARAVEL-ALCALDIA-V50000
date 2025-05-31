<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cedulas_catastrales', function (Blueprint $table) {
            $table->string('numero_base', 50)->nullable()->after('numero_cedula');
            $table->index('numero_base');
        });

        // Actualizar registros existentes
        DB::statement("UPDATE cedulas_catastrales SET numero_base = SUBSTRING_INDEX(numero_cedula, '-', 1)");
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cedulas_catastrales', function (Blueprint $table) {
            $table->dropColumn('numero_base');
        });
    }
};
