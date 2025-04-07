<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatastroController extends Controller
{
    public function index()
    {
        return view('admin.catastro.index');
    }
}
