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
            $table->string('estado', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('ced_catastral', function (Blueprint $table) {
            $table->id();
            $table->integer('fk_cat');
            $table->integer('fk_linderos');
            $table->integer('ambito')->nullable();
            $table->string('area', 50)->nullable();
            $table->string('ced', 50)->nullable();
            $table->string('direccion', 50)->nullable();
            $table->string('tipo', 50)->nullable();
            $table->string('descripcion', 50)->nullable();
            $table->string('estado', 50)->nullable();
            $table->timestamps();
        });

        Schema::create('linderos', function (Blueprint $table) {
            $table->id();
            $table->string('norte', 255)->nullable();
            $table->string('sur', 255)->nullable();
            $table->string('este', 255)->nullable();
            $table->string('oeste', 255)->nullable();
            $table->timestamps();
        });
        Schema::create('vigencia', function (Blueprint $table) {
            $table->id();
            $table->string('fk_catastral', 255)->nullable();
            $table->timestamps();
            $table->string('vencimiento', 255)->nullable();
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
