<?php

namespace App\Http\Controllers;

use App\Models\CedulaCatastral;
use App\Models\Propietario;
use App\Models\Lindero;
use App\Models\DocumentoLegal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CedulaCatastralController extends Controller
{
    /**
     * Muestra la lista de cédulas catastrales
     */
    public function index()
    {
        $cedulasCatastrales = CedulaCatastral::with(['propietario', 'linderos', 'documentoLegal'])->get();
        return view('admin.catastro.index', compact('cedulasCatastrales'));
    }
    /**
     * Obtiene la lista de propietarios para el select
     */
    public function getPropietarios()
    {
        $propietarios = Propietario::select('id', 'nombre_apellido', 'cedula')
            ->orderBy('nombre_apellido')
            ->get();

        return response()->json([
            'success' => true,
            'propietarios' => $propietarios
        ]);
    }

    /**
     * Crea un nuevo propietario
     */
    public function storePropietario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_apellido' => 'required|string|max:100',
            'cedula' => 'required|string|max:20|unique:propietarios,cedula',
            'rif' => 'nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $propietario = Propietario::create([
                'nombre_apellido' => $request->nombre_apellido,
                'cedula' => $request->cedula,
                'rif' => $request->rif
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Propietario creado exitosamente',
                'propietario' => $propietario
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el propietario: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Renueva una cédula catastral para el siguiente trimestre
     */
    public function renovar($id)
    {
        try {
            DB::beginTransaction();

            $cedulaOriginal = CedulaCatastral::with(['propietario', 'linderos', 'documentoLegal'])->findOrFail($id);

            // Determinar el siguiente trimestre
            $trimestreActual = $cedulaOriginal->vigencia_trimestre;
            $siguienteTrimestre = $this->getSiguienteTrimestre($trimestreActual);

            // Crear nuevos linderos (copia)
            $nuevosLinderos = Lindero::create([
                'norte' => $cedulaOriginal->linderos->norte,
                'sur' => $cedulaOriginal->linderos->sur,
                'este' => $cedulaOriginal->linderos->este,
                'oeste' => $cedulaOriginal->linderos->oeste,
                'mt2_norte' => $cedulaOriginal->linderos->mt2_norte,
                'mt2_sur' => $cedulaOriginal->linderos->mt2_sur,
                'mt2_este' => $cedulaOriginal->linderos->mt2_este,
                'mt2_oeste' => $cedulaOriginal->linderos->mt2_oeste,
                'mt2_total' => $cedulaOriginal->linderos->mt2_total,
            ]);

            // Crear nuevo documento legal si existe (copia)
            $nuevoDocumentoLegalId = null;
            if ($cedulaOriginal->documentoLegal) {
                $nuevoDocumentoLegal = DocumentoLegal::create([
                    'tipo' => $cedulaOriginal->documentoLegal->tipo,
                    'numero' => $cedulaOriginal->documentoLegal->numero,
                    'matricula' => $cedulaOriginal->documentoLegal->matricula,
                    'folio' => $cedulaOriginal->documentoLegal->folio,
                    'fecha' => $cedulaOriginal->documentoLegal->fecha,
                    'descripcion' => $cedulaOriginal->documentoLegal->descripcion,
                ]);
                $nuevoDocumentoLegalId = $nuevoDocumentoLegal->id;
            }

            // Generar nuevo número de cédula
            $nuevoNumeroCedula = $this->generarNuevoNumeroCedula($cedulaOriginal->numero_cedula);

            // Crear nueva cédula catastral
            $nuevaCedula = CedulaCatastral::create([
                'numero_cedula' => $nuevoNumeroCedula,
                'numero_expediente' => $cedulaOriginal->numero_expediente . '-R', // Agregamos -R para indicar renovación
                'propietario_id' => $cedulaOriginal->propietario_id,
                'direccion_inmueble' => $cedulaOriginal->direccion_inmueble,
                'tipo_inmueble' => $cedulaOriginal->tipo_inmueble,
                'ambito' => $cedulaOriginal->ambito,
                'linderos_id' => $nuevosLinderos->id,
                'documento_legal_id' => $nuevoDocumentoLegalId,
                'avaluo_total' => $cedulaOriginal->avaluo_total,
                'fecha_expedicion' => now()->toDateString(),
                'vigencia_trimestre' => $siguienteTrimestre,
                'solicitado_para' => $cedulaOriginal->solicitado_para,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cédula catastral renovada exitosamente',
                'cedula' => $nuevaCedula->load(['propietario', 'linderos', 'documentoLegal'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al renovar la cédula catastral: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getSiguienteTrimestre($trimestreActual)
    {
        $trimestres = ['PRIMER', 'SEGUNDO', 'TERCER', 'CUARTO'];
        $indiceActual = array_search($trimestreActual, $trimestres);

        // Si es el cuarto trimestre, vuelve al primero
        return $trimestres[($indiceActual + 1) % 4];
    }

    private function generarNuevoNumeroCedula($numeroCedulaAnterior)
    {
        // Extraer el número base y agregar un sufijo o incrementar
        $contador = 1;
        do {
            $nuevoNumero = $numeroCedulaAnterior . '-' . str_pad($contador, 2, '0', STR_PAD_LEFT);
            $existe = CedulaCatastral::where('numero_cedula', $nuevoNumero)->exists();
            $contador++;
        } while ($existe);

        return $nuevoNumero;
    }
    /**
     * Devuelve datos para DataTables
     */
    public function getData()
    {
        $cedulasCatastrales = CedulaCatastral::with(['propietario', 'linderos', 'documentoLegal'])->get();
        return response()->json([
            'data' => $cedulasCatastrales
        ]);
    }

    /**
     * Almacena una nueva cédula catastral o actualiza una existente
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'propietario_id' => 'required|exists:propietarios,id',
            'numero_cedula' => 'required|string|max:50|unique:cedulas_catastrales,numero_cedula,' . $request->id,
            'numero_expediente' => 'required|string|max:50|unique:cedulas_catastrales,numero_expediente,' . $request->id,
            'direccion_inmueble' => 'required|string',
            'tipo_inmueble' => 'required|in:Terreno,Casa,Local,Galpon',
            'ambito' => 'required|in:Urbano,Rural',
            'norte' => 'nullable|string|max:255',
            'sur' => 'nullable|string|max:255',
            'este' => 'nullable|string|max:255',
            'oeste' => 'nullable|string|max:255',
            'mt2_norte' => 'nullable|numeric',
            'mt2_sur' => 'nullable|numeric',
            'mt2_este' => 'nullable|numeric',
            'mt2_oeste' => 'nullable|numeric',
            'mt2_total' => 'nullable|numeric',
            'tipo_documento' => 'nullable|in:Registrado,Notariado,Juzgado',
            'numero_documento' => 'nullable|string|max:50',
            'matricula' => 'nullable|string|max:50',
            'folio' => 'nullable|string|max:50',
            'fecha_documento' => 'nullable|date',
            'descripcion_documento' => 'nullable|string',
            'avaluo_total' => 'nullable|numeric',
            'fecha_expedicion' => 'required|date',
            'vigencia_trimestre' => 'required|in:PRIMER,SEGUNDO,TERCER,CUARTO',
            'solicitado_para' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Obtener el propietario seleccionado
            $propietario = Propietario::findOrFail($request->propietario_id);

            // Crear o actualizar linderos
            $linderos = new Lindero();
            if ($request->id) {
                $cedulaExistente = CedulaCatastral::findOrFail($request->id);
                $linderos = $cedulaExistente->linderos;
            }

            $linderos->norte = $request->norte;
            $linderos->sur = $request->sur;
            $linderos->este = $request->este;
            $linderos->oeste = $request->oeste;
            $linderos->mt2_norte = $request->mt2_norte;
            $linderos->mt2_sur = $request->mt2_sur;
            $linderos->mt2_este = $request->mt2_este;
            $linderos->mt2_oeste = $request->mt2_oeste;
            $linderos->mt2_total = $request->mt2_total;
            $linderos->save();

            // Crear o actualizar documento legal si existe
            $documentoLegalId = null;
            if ($request->tipo_documento) {
                $documentoLegal = new DocumentoLegal();
                if ($request->id) {
                    $cedulaExistente = CedulaCatastral::findOrFail($request->id);
                    if ($cedulaExistente->documento_legal_id) {
                        $documentoLegal = $cedulaExistente->documentoLegal;
                    }
                }

                $documentoLegal->tipo = $request->tipo_documento;
                $documentoLegal->numero = $request->numero_documento;
                $documentoLegal->matricula = $request->matricula;
                $documentoLegal->folio = $request->folio;
                $documentoLegal->fecha = $request->fecha_documento;
                $documentoLegal->descripcion = $request->descripcion_documento;
                $documentoLegal->save();
                $documentoLegalId = $documentoLegal->id;
            }

            // Crear o actualizar cédula catastral
            if ($request->id) {
                $cedulaCatastral = CedulaCatastral::findOrFail($request->id);
                $cedulaCatastral->update([
                    'numero_cedula' => $request->numero_cedula,
                    'numero_expediente' => $request->numero_expediente,
                    'propietario_id' => $propietario->id,
                    'direccion_inmueble' => $request->direccion_inmueble,
                    'tipo_inmueble' => $request->tipo_inmueble,
                    'ambito' => $request->ambito,
                    'linderos_id' => $linderos->id,
                    'documento_legal_id' => $documentoLegalId,
                    'avaluo_total' => $request->avaluo_total,
                    'fecha_expedicion' => $request->fecha_expedicion,
                    'vigencia_trimestre' => $request->vigencia_trimestre,
                    'solicitado_para' => $request->solicitado_para
                ]);
            } else {
                $cedulaCatastral = CedulaCatastral::create([
                    'numero_cedula' => $request->numero_cedula,
                    'numero_expediente' => $request->numero_expediente,
                    'propietario_id' => $propietario->id,
                    'direccion_inmueble' => $request->direccion_inmueble,
                    'tipo_inmueble' => $request->tipo_inmueble,
                    'ambito' => $request->ambito,
                    'linderos_id' => $linderos->id,
                    'documento_legal_id' => $documentoLegalId,
                    'avaluo_total' => $request->avaluo_total,
                    'fecha_expedicion' => $request->fecha_expedicion,
                    'vigencia_trimestre' => $request->vigencia_trimestre,
                    'solicitado_para' => $request->solicitado_para
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $request->id ? 'Cédula catastral actualizada con éxito' : 'Cédula catastral creada con éxito',
                'cedula' => $cedulaCatastral
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
     * Muestra los detalles de una cédula catastral específica
     */
    public function show($id)
    {
        $cedulaCatastral = CedulaCatastral::with(['propietario', 'linderos', 'documentoLegal'])->findOrFail($id);
        return response()->json([
            'success' => true,
            'cedula' => $cedulaCatastral
        ]);
    }

    /**
     * Elimina una cédula catastral
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $cedulaCatastral = CedulaCatastral::findOrFail($id);

            // Verificar si tiene solvencias asociadas
            if ($cedulaCatastral->solvenciasMunicipales()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la cédula catastral porque tiene solvencias municipales asociadas'
                ], 422);
            }

            // Almacenar IDs para eliminar después
            $linderosId = $cedulaCatastral->linderos_id;
            $documentoLegalId = $cedulaCatastral->documento_legal_id;

            // Eliminar cédula catastral
            $cedulaCatastral->delete();

            // Eliminar linderos asociados
            if ($linderosId) {
                Lindero::destroy($linderosId);
            }

            // Eliminar documento legal asociado
            if ($documentoLegalId) {
                DocumentoLegal::destroy($documentoLegalId);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Cédula catastral eliminada con éxito'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la cédula catastral: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Busca una cédula catastral por número de cédula o expediente
     */
    public function buscar(Request $request)
    {
        $query = $request->get('query');

        $cedulas = CedulaCatastral::where('numero_cedula', 'LIKE', "%{$query}%")
            ->orWhere('numero_expediente', 'LIKE', "%{$query}%")
            ->with(['propietario', 'linderos'])
            ->get();

        return response()->json([
            'success' => true,
            'cedulas' => $cedulas
        ]);
    }
}
