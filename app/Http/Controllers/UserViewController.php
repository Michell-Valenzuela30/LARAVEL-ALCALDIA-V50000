<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserViewController extends Controller
{
    public function index()
    {
        return view('usuarios.index');
    }
}
