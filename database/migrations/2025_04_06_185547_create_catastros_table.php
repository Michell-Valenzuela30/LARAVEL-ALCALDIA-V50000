<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('catastros', function (Blueprint $table) {
            $table->id('id_cat');
            $table->integer('num_expe')->nullable();
            $table->string('nom_ape', 50)->nullable();
            $table->string('ced', 50)->nullable();
            $table->string('direccion', 50)->nullable();
            $table->string('tipo', 50)->nullable();
            $table->string('descripcion', 50)->nullable();
            $table->string('estado', 50)->nullable(); // Nueva columna 'estado'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catastros');
    }
};
