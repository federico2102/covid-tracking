<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContagiosController extends Controller
{
    public function informarContagio(Request $request)
    {
        $fecha_diagnostico = Carbon::create($request->input('fecha'));
        $fecha_minima = $fecha_diagnostico->subDays(7); //Fecha configurable

        Auth::user()->contagiar($fecha_minima, $fecha_diagnostico);

        return redirect("/home");
    }

    public function testNegativo(Request $request)
    {
        Auth::user()->curado(Carbon::create($request->input('fecha')));

        return redirect("home");
    }
}

