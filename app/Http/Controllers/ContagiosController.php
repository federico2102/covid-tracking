<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContagiosController extends Controller
{
    public function informarContagio(Request $request)
    {
        $fecha_diagnostico = date("Y-m-d" ,strtotime($request->input('fecha')));
        $fecha_minima = date('Y-m-d h:i:sa', strtotime($fecha_diagnostico." - 7 days")); //Fecha configurable

        Auth::user()->contagiar($fecha_minima, $fecha_diagnostico);

        return redirect("/home");
    }

    public function testNegativo(Request $request)
    {
        Auth::user()->curado(date("Y-m-d" ,strtotime($request->input('fecha'))));

        return redirect("home");
    }
}

