<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catastro;

class CatastroController extends Controller
{
    public function index()
    {
        $catastros = Catastro::all();
        return view('Admin.Catastro.index', compact('catastros'));
    }
}
