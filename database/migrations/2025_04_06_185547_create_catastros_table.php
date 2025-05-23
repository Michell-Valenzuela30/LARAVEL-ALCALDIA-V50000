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
        // Tabla para almacenar información de propietarios
        Schema::create('propietarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_apellido', 100);
            $table->string('cedula', 20)->unique();
            $table->string('rif', 20)->nullable();
            $table->timestamps();
        });

        // Tabla para almacenar linderos de inmuebles
        Schema::create('linderos', function (Blueprint $table) {
            $table->id();
            $table->string('norte', 255)->nullable();
            $table->string('sur', 255)->nullable();
            $table->string('este', 255)->nullable();
            $table->string('oeste', 255)->nullable();
            $table->decimal('mt2_norte', 10, 2)->nullable();
            $table->decimal('mt2_sur', 10, 2)->nullable();
            $table->decimal('mt2_este', 10, 2)->nullable();
            $table->decimal('mt2_oeste', 10, 2)->nullable();
            $table->decimal('mt2_total', 10, 2)->nullable();
            $table->timestamps();
        });

        // Tabla para almacenar información de documentos legales
        Schema::create('documentos_legales', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['Registrado', 'Notariado', 'Juzgado']);
            $table->string('numero', 50)->nullable();
            $table->string('matricula', 50)->nullable();
            $table->string('folio', 50)->nullable();
            $table->date('fecha')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        // Tabla principal de cédulas catastrales
        Schema::create('cedulas_catastrales', function (Blueprint $table) {
            $table->id();
            $table->string('numero_cedula', 50)->unique();
            $table->string('numero_expediente', 50)->unique();
            $table->foreignId('propietario_id')->constrained('propietarios');
            $table->text('direccion_inmueble');
            $table->enum('tipo_inmueble', ['Terreno', 'Casa', 'Local', 'Galpon']);
            $table->enum('ambito', ['Urbano', 'Rural']);
            $table->foreignId('linderos_id')->constrained('linderos');
            $table->foreignId('documento_legal_id')->nullable()->constrained('documentos_legales');
            $table->decimal('avaluo_total', 15, 2)->nullable();
            $table->date('fecha_expedicion');
            $table->enum('vigencia_trimestre', ['PRIMER', 'SEGUNDO', 'TERCER', 'CUARTO']);
            $table->string('solicitado_para')->nullable();
            $table->timestamps();
        });

        // Tabla para solvencias municipales tipo A
        Schema::create('solvencias_municipales', function (Blueprint $table) {
            $table->id();
            $table->string('numero_solvencia', 50)->unique();
            $table->foreignId('propietario_id')->constrained('propietarios');
            $table->foreignId('cedula_catastral_id')->constrained('cedulas_catastrales');
            $table->text('direccion_inmueble');
            $table->string('solicitado_para')->nullable();
            $table->date('vigencia_desde');
            $table->date('vigencia_hasta');
            $table->date('fecha_expedicion');
            $table->enum('vigencia_trimestre', ['PRIMER', 'SEGUNDO', 'TERCER', 'CUARTO']);
            $table->timestamps();
        });

        // Tabla para autoridades municipales
        Schema::create('autoridades', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['director_recaudacion', 'alcalde', 'jefe_catastro']);
            $table->string('nombre', 100);
            $table->date('fecha_inicio_cargo');
            $table->boolean('activo')->default(true);

            $table->timestamps();

            // Solo puede haber una autoridad activa por tipo
            $table->index(['tipo', 'activo']);
        });
        Schema::create('alcaldia_info', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('rif', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solvencias_municipales');
        Schema::dropIfExists('cedulas_catastrales');
        Schema::dropIfExists('documentos_legales');
        Schema::dropIfExists('linderos');
        Schema::dropIfExists('propietarios');
        Schema::dropIfExists('autoridades');
        Schema::dropIfExists('alcaldia_info');
    }
};
