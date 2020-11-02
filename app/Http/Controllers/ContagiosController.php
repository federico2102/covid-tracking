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
        $id = Auth::user()->id;
        $fecha_actual = date('Y-m-d h:i:sa'); //Fecha de hoy
        $fecha_diagnostico = date("Y-m-d" ,strtotime($request->input('fecha')));
        $fecha_minima = date('Y-m-d h:i:sa', strtotime($fecha_diagnostico." - 7 days")); //Fecha configurable
        $locaciones = DB::table('concurrios')->select('locacion_id', 'entrada', 'salida')
            ->distinct('locacion_id')->where('entrada', '>=', $fecha_minima)
            ->where('user_id', '=', $id)
            ->get(); //locaciones por las que paso el usuario contagiado en las fechas dadas

        $victimas = DB::Table('concurrios')->select('user_id', 'locacion_id', 'entrada', 'salida')
            ->where('entrada', '>=', $fecha_minima)
            ->where('user_id','<>', $id)
            ->get(); //usuarios que estuvieron en locaciones en las fechas dadas

        $victimas_id = array();
        foreach ($victimas as $victima) {
            foreach ($locaciones as $locacion) {
                if ($locacion->locacion_id == $victima->locacion_id) {
                    if ($victima->entrada >= $locacion->entrada and $victima->entrada <= $locacion->salida) {
                        array_push($victimas_id, $victima->userId);
                    } elseif ($victima->salida >= $locacion->entrada and $victima->salida <= $locacion->salida) {
                        array_push($victimas_id, $victima->user_id);
                    }
                }
            }
        } //ids de usuarios que compartieron locacion con el usuario contagiado

        array_unique($victimas_id);

        $victimas = DB::table('users')->select('email','id')->whereIn('id', $victimas_id)
            ->where('estado', '=', 'No contagiado')->get(); //mail de los usuarios en riesgo

        DB::table('users')->select('email')->whereIn('id', $victimas_id)
            ->where('estado', '=', 'No contagiado')
            ->update(['estado'=>'En riesgo']); //cambio el estado de los usuarios en riesgo

        foreach ($victimas as $victima){
            $contagios = new Contagio();
            $contagios->userId = $victima->id;
            $contagios->estado = 'En riesgo';
            $contagios->fecha = $fecha_actual;
            $contagios->save();
            Mail::to($victima->email)->send(new contagioMail());
        } //creo entrada en la tabla de contagios y envio de mail a usuarios en riesgo

        DB::table('users')->where('id', '=',$id)
            ->update(['estado'=>'Contagiado']); //actualizo estado del usuario contagiado

        if (Auth::user()->estado == 'No contagiado') {
            $contagios = new Contagio();
            $contagios->userId = $id;
            $contagios->estado = 'Contagiado';
            $contagios->fecha = $fecha_diagnostico;
            $contagios->save();
        } else {
            $contagioId = DB::table('contagios')->where('userId', '=', $id)->orderBy('id','desc')
                ->first()->id;
            $contagio = Contagio::find($contagioId);
            $contagio->fechaAlta = $fecha_diagnostico;
            $contagio->save();
        }

        return redirect("/home");
    }

    public function testNegativo(Request $request)
    {
        $id = Auth::user()->id;
        DB::table('users')->where('id', '=', $id)
            ->update(['estado'=>'No contagiado']);

        $fecha_diagnostico = date("Y-m-d" ,strtotime($request->input('fecha'))); //Fecha de hoy
        $contagioId = DB::table('contagios')->where('userId', '=', $id)->orderBy('id','desc')
            ->first()->id;
        $contagio = Contagio::find($contagioId);
        $contagio->fechaAlta = $fecha_diagnostico;
        $contagio->save();
        return redirect("home");
    }
}

