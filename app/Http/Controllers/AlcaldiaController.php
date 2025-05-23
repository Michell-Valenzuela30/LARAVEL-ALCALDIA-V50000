<?php

namespace App\Http\Controllers;

use App\Models\AlcaldiaInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlcaldiaController extends Controller
{
    public function actualizar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'rif' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $alcaldia = AlcaldiaInfo::first();

            if ($alcaldia) {
                $alcaldia->update($request->only(['nombre', 'rif']));
            } else {
                $alcaldia = AlcaldiaInfo::create($request->only(['nombre', 'rif']));
            }

            return response()->json([
                'success' => true,
                'message' => 'Información actualizada correctamente',
                'alcaldia' => $alcaldia
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }
}
