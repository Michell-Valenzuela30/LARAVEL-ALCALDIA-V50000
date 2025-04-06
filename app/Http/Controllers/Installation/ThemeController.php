<?php

namespace App\Http\Controllers\Installation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Establece la preferencia de tema en la sesión
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setTheme(Request $request)
    {
        $theme = $request->input('theme', 'light');
        session(['theme' => $theme]);

        return response()->json(['success' => true]);
    }
}
