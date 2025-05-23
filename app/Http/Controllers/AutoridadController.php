<?php

namespace App\Http\Controllers;

use App\Models\Autoridad;
use App\Models\AlcaldiaInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AutoridadController extends Controller
{
    /**
     * Muestra la lista de autoridades
     */
    public function index()
    {
        $autoridadesActivas = Autoridad::getActivas();
        $autoridadesInactivas = Autoridad::getInactivas();
        $tipos = Autoridad::TIPOS;
        $infoAlcaldia = AlcaldiaInfo::getInfo(); // AGREGAR esta línea

        return view('Admin.Autoridades.index', compact('autoridadesActivas', 'autoridadesInactivas', 'tipos', 'infoAlcaldia'));
    }

    /**
     * Almacena una nueva autoridad o actualiza una existente
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tipo' => 'required|in:director_recaudacion,alcalde,jefe_catastro',
            'nombre' => 'required|string|max:100',
            'fecha_inicio_cargo' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Desactivar autoridad actual del mismo tipo si existe
            Autoridad::where('tipo', $request->tipo)
                ->where('activo', true)
                ->update(['activo' => false]);

            // Crear nueva autoridad
            $autoridad = Autoridad::create([
                'tipo' => $request->tipo,
                'nombre' => $request->nombre,
                'fecha_inicio_cargo' => $request->fecha_inicio_cargo,
                'activo' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Autoridad agregada con éxito',
                'autoridad' => $autoridad
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Muestra los detalles de una autoridad específica
     */
    public function show($id)
    {
        $autoridad = Autoridad::findOrFail($id);
        return response()->json([
            'success' => true,
            'autoridad' => $autoridad
        ]);
    }

    /**
     * Elimina una autoridad
     */
    public function destroy($id)
    {
        try {
            $autoridad = Autoridad::findOrFail($id);

            // Verificar si es la única autoridad
            if (Autoridad::count() <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la autoridad porque es la única existente'
                ], 422);
            }

            // Si es la activa, activar otra
            if ($autoridad->activo) {
                $otraAutoridad = Autoridad::where('id', '!=', $id)->first();
                if ($otraAutoridad) {
                    $otraAutoridad->activo = true;
                    $otraAutoridad->save();
                }
            }

            $autoridad->delete();

            return response()->json([
                'success' => true,
                'message' => 'Autoridad eliminada con éxito'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la autoridad: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Establece una autoridad como activa
     */
    public function activar($id)
    {
        try {
            $autoridad = Autoridad::findOrFail($id);
            $autoridad->activar();

            return response()->json([
                'success' => true,
                'message' => 'Autoridad establecida como activa con éxito'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al activar la autoridad: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Actualiza los datos de la alcaldía
     */
    public function updateAlcaldia(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'rif' => 'required|string|max:20',
            'direccion' => 'nullable|string|max:200',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $alcaldia = AlcaldiaInfo::actualizarDatos($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Datos de alcaldía actualizados con éxito',
                'alcaldia' => $alcaldia
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar los datos: ' . $e->getMessage()
            ], 500);
        }
    }
}
