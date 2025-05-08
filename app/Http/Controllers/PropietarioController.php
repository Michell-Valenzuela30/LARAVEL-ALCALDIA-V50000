<?php

namespace App\Http\Controllers;

use App\Models\Propietario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropietarioController extends Controller
{
    /**
     * Muestra la lista de propietarios
     */
    public function index()
    {
        $propietarios = Propietario::all();
        return view('admin.catastro.propietarios.index', compact('propietarios'));
    }

    /**
     * Almacena un nuevo propietario o actualiza uno existente
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_apellido' => 'required|string|max:100',
            'cedula' => 'required|string|max:20|unique:propietarios,cedula,' . $request->id,
            'rif' => 'nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            if ($request->id) {
                $propietario = Propietario::findOrFail($request->id);
                $propietario->update([
                    'nombre_apellido' => $request->nombre_apellido,
                    'cedula' => $request->cedula,
                    'rif' => $request->rif
                ]);
            } else {
                $propietario = Propietario::create([
                    'nombre_apellido' => $request->nombre_apellido,
                    'cedula' => $request->cedula,
                    'rif' => $request->rif
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => $request->id ? 'Propietario actualizado con éxito' : 'Propietario creado con éxito',
                'propietario' => $propietario
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Muestra los detalles de un propietario específico
     */
    public function show($id)
    {
        $propietario = Propietario::with(['cedulasCatastrales', 'solvenciasMunicipales'])->findOrFail($id);
        return response()->json([
            'success' => true,
            'propietario' => $propietario
        ]);
    }

    /**
     * Elimina un propietario
     */
    public function destroy($id)
    {
        try {
            $propietario = Propietario::findOrFail($id);

            // Verificar si tiene cédulas catastrales o solvencias asociadas
            if ($propietario->cedulasCatastrales()->count() > 0 || $propietario->solvenciasMunicipales()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el propietario porque tiene cédulas catastrales o solvencias asociadas'
                ], 422);
            }

            $propietario->delete();

            return response()->json([
                'success' => true,
                'message' => 'Propietario eliminado con éxito'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el propietario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Busca propietarios por nombre o cédula
     */
    public function buscar(Request $request)
    {
        $query = $request->get('query');

        $propietarios = Propietario::where('nombre_apellido', 'LIKE', "%{$query}%")
            ->orWhere('cedula', 'LIKE', "%{$query}%")
            ->get();

        return response()->json([
            'success' => true,
            'propietarios' => $propietarios
        ]);
    }
}
