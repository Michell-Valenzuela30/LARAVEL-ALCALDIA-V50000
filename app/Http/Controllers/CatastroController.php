<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catastro;
use Illuminate\Support\Facades\Validator;

class CatastroController extends Controller
{
    public function index()
    {
        $catastros = Catastro::all();
        return view('Admin.Catastro.index', compact('catastros'));
    }
    public function store(Request $request)
    {
        $data = $request->all();

        // Verifica los datos recibidos
        // dd($data);

        $validator = Validator::make($data, [
            'num_expe' => 'required',
            'nom_ape' => 'required',
            'ced' => 'required',
            'direccion' => 'required',
            'tipo' => 'required',
            'descripcion' => 'nullable',
            'estado' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if ($request->filled('id_cat')) {
            // Editar
            $catastro = Catastro::findOrFail($request->id_cat);
            $catastro->update($data);
        } else {
            // Crear
            Catastro::create($data);
        }

        return redirect()->route('admin.catastro.index');
    }

    public function edit($id)
    {
        return response()->json(Catastro::findOrFail($id));
    }

    public function destroy($id)
    {
        $catastro = Catastro::findOrFail($id);
        $catastro->delete();

        return response()->json(['success' => true]);
    }
    public function show($id)
    {
        $catastro = Catastro::findOrFail($id);
        return response()->json($catastro);
    }

}
