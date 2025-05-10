<?php

namespace App\Http\Controllers;

use App\Models\Autoridad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AutoridadController extends Controller
{
    /**
     * Muestra la lista de autoridades
     */
    public function index()
    {
        $autoridades = Autoridad::all();
        $autoridadActiva = Autoridad::getActiva();
        return view('Admin.Autoridades.index', compact('autoridades', 'autoridadActiva'));
    }

    /**
     * Almacena una nueva autoridad o actualiza una existente
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'director_recaudacion' => 'required|string|max:100',
            'alcalde' => 'required|string|max:100',
            'jefe_catastro' => 'required|string|max:100',
            'nombre_alcaldia' => 'required|string|max:100',
            'rif_alcaldia' => 'required|string|max:20',
            'fecha_inicio_cargo' => 'nullable|date',
            'activo' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Si se establece como activa, desactivar las demás
            if ($request->activo) {
                Autoridad::where('activo', true)->update(['activo' => false]);
            }

            if ($request->id) {
                $autoridad = Autoridad::findOrFail($request->id);
                $autoridad->update([
                    'director_recaudacion' => $request->director_recaudacion,
                    'alcalde' => $request->alcalde,
                    'jefe_catastro' => $request->jefe_catastro,
                    'nombre_alcaldia' => $request->nombre_alcaldia,
                    'rif_alcaldia' => $request->rif_alcaldia,
                    'fecha_inicio_cargo' => $request->fecha_inicio_cargo,
                    'activo' => $request->activo ?? false
                ]);
            } else {
                $autoridad = Autoridad::create([
                    'director_recaudacion' => $request->director_recaudacion,
                    'alcalde' => $request->alcalde,
                    'jefe_catastro' => $request->jefe_catastro,
                    'nombre_alcaldia' => $request->nombre_alcaldia,
                    'rif_alcaldia' => $request->rif_alcaldia,
                    'fecha_inicio_cargo' => $request->fecha_inicio_cargo,
                    'activo' => $request->activo ?? false
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => $request->id ? 'Autoridad actualizada con éxito' : 'Autoridad creada con éxito',
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
            // Desactivar todas las autoridades
            Autoridad::where('activo', true)->update(['activo' => false]);

            // Activar la seleccionada
            $autoridad = Autoridad::findOrFail($id);
            $autoridad->activo = true;
            $autoridad->save();

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
}
