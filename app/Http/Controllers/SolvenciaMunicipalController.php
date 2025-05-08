<?php

namespace App\Http\Controllers;

use App\Models\SolvenciaMunicipal;
use App\Models\CedulaCatastral;
use App\Models\Autoridad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SolvenciaMunicipalController extends Controller
{
    /**
     * Muestra la lista de solvencias municipales
     */
    public function index()
    {
        $solvencias = SolvenciaMunicipal::with(['propietario', 'cedulaCatastral'])->get();
        return view('admin.catastro.solvencias.index', compact('solvencias'));
    }

    /**
     * Almacena una nueva solvencia municipal o actualiza una existente
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_solvencia' => 'required|string|max:50|unique:solvencias_municipales,numero_solvencia,' . $request->id,
            'cedula_catastral_id' => 'required|exists:cedulas_catastrales,id',
            'direccion_inmueble' => 'required|string',
            'solicitado_para' => 'nullable|string',
            'vigencia_desde' => 'required|date',
            'vigencia_hasta' => 'required|date|after:vigencia_desde',
            'fecha_expedicion' => 'required|date',
            'vigencia_trimestre' => 'required|in:PRIMER,SEGUNDO,TERCER,CUARTO'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $cedulaCatastral = CedulaCatastral::with('propietario')->findOrFail($request->cedula_catastral_id);

            // Crear o actualizar solvencia municipal
            if ($request->id) {
                $solvencia = SolvenciaMunicipal::findOrFail($request->id);
                $solvencia->update([
                    'numero_solvencia' => $request->numero_solvencia,
                    'propietario_id' => $cedulaCatastral->propietario_id,
                    'cedula_catastral_id' => $request->cedula_catastral_id,
                    'direccion_inmueble' => $request->direccion_inmueble,
                    'solicitado_para' => $request->solicitado_para,
                    'vigencia_desde' => $request->vigencia_desde,
                    'vigencia_hasta' => $request->vigencia_hasta,
                    'fecha_expedicion' => $request->fecha_expedicion,
                    'vigencia_trimestre' => $request->vigencia_trimestre
                ]);
            } else {
                $solvencia = SolvenciaMunicipal::create([
                    'numero_solvencia' => $request->numero_solvencia,
                    'propietario_id' => $cedulaCatastral->propietario_id,
                    'cedula_catastral_id' => $request->cedula_catastral_id,
                    'direccion_inmueble' => $request->direccion_inmueble,
                    'solicitado_para' => $request->solicitado_para,
                    'vigencia_desde' => $request->vigencia_desde,
                    'vigencia_hasta' => $request->vigencia_hasta,
                    'fecha_expedicion' => $request->fecha_expedicion,
                    'vigencia_trimestre' => $request->vigencia_trimestre
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $request->id ? 'Solvencia municipal actualizada con éxito' : 'Solvencia municipal creada con éxito',
                'solvencia' => $solvencia->load(['propietario', 'cedulaCatastral'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Muestra los detalles de una solvencia municipal específica
     */
    public function show($id)
    {
        $solvencia = SolvenciaMunicipal::with(['propietario', 'cedulaCatastral'])->findOrFail($id);
        return response()->json([
            'success' => true,
            'solvencia' => $solvencia
        ]);
    }

    /**
     * Elimina una solvencia municipal
     */
    public function destroy($id)
    {
        try {
            $solvencia = SolvenciaMunicipal::findOrFail($id);
            $solvencia->delete();

            return response()->json([
                'success' => true,
                'message' => 'Solvencia municipal eliminada con éxito'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la solvencia municipal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Genera un PDF de la solvencia municipal
     */
    public function generarPdf($id)
    {
        $solvencia = SolvenciaMunicipal::with(['propietario', 'cedulaCatastral'])->findOrFail($id);
        $autoridad = Autoridad::getActiva();

        // Aquí implementarías la generación del PDF con una librería como DOMPDF o FPDF
        // Por ahora retornamos una vista
        return view('admin.catastro.solvencias.pdf', compact('solvencia', 'autoridad'));
    }

    /**
     * Busca una cédula catastral para crear una solvencia
     */
    public function buscarCedula(Request $request)
    {
        $query = $request->get('query');

        $cedula = CedulaCatastral::where('numero_cedula', $query)
            ->orWhere('numero_expediente', $query)
            ->with(['propietario', 'linderos'])
            ->first();

        if (!$cedula) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró la cédula catastral'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'cedula' => $cedula
        ]);
    }
}
