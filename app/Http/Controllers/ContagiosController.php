<?php

namespace App\Http\Controllers;

use App\Mail\contagioMail;
use App\Models\Contagio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Concurrio;
use Illuminate\Support\Facades\DB;

class ContagiosController extends Controller
{
    public function informarContagio(Request $request)
    {
        $fecha_diagnostico = date("Y-m-d" ,strtotime($request->input('fecha')));
        $fecha_minima = date('Y-m-d h:i:sa', strtotime($fecha_diagnostico." - 7 days")); //Fecha configurable
             //locaciones por las que paso el usuario contagiado en las fechas dadas

        Auth::user()->contagiar($fecha_minima, $fecha_diagnostico);

        return redirect("/home");
    }

    public function testNegativo(Request $request)
    {
        Auth::user()->curado(date("Y-m-d" ,strtotime($request->input('fecha'))));

        return redirect("home");
    }
}

