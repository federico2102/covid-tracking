<?php

namespace App\Http\Controllers;

use App\Mail\contagioMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Concurrio;
use Illuminate\Support\Facades\DB;

class MailController extends Controller
{
    public function sendEmail($id)
    {
        $fecha_actual = date('Y-m-d h:i:sa'); //Fecha de hoy
        $fecha_minima = date('Y-m-d h:i:sa', strtotime($fecha_actual."- 7 days")); //Fecha configurable
        $locaciones = DB::table('concurrios')->select('locacionId', 'entrada', 'salida')
            ->distinct('locacionId')->where('entrada', '>=', $fecha_minima)
            ->where('userId', '=', $id)
            ->get(); //locaciones por las que paso el usuario contagiado en las fechas dadas

        $victimas = DB::Table('concurrios')->select('userId', 'locacionId', 'entrada', 'salida')
            ->where('entrada', '>=', $fecha_minima)
            ->where('userId','<>', $id)
            ->get(); //usuarios que estuvieron en locaciones en las fechas dadas

        $victimas_id = array();
        foreach ($victimas as $victima) {
            foreach ($locaciones as $locacion) {
                if ($locacion->locacionId == $victima->locacionId) {
                    if ($victima->entrada >= $locacion->entrada and $victima->entrada <= $locacion->salida) {
                        array_push($victimas_id, $victima->userId);
                    } elseif ($victima->salida >= $locacion->entrada and $victima->salida <= $locacion->salida) {
                        array_push($victimas_id, $victima->userId);
                    }
                }
            }
        } //ids de usuarios que compartieron locacion con el usuario contagiado

        array_unique($victimas_id);

        $victimas = DB::table('users')->select('email')->whereIn('id', $victimas_id)
            ->where('estado', '=', 'No contagiado')->get(); //mail de los usuarios en riesgo

        DB::table('users')->select('email')->whereIn('id', $victimas_id)
            ->where('estado', '=', 'No contagiado')
            ->update(['estado'=>'En riesgo']); //cambio el estado de los usuarios en riesgo

        foreach ($victimas as $victima){
            Mail::to($victima->email)->send(new contagioMail());
        } //envio de mail a usuarios en riesgo

        DB::table('users')->where('id', '=',$id)
            ->update(['estado'=>'Contagiado']); //actualizo estado del usuario contagiado

        return redirect("/home");
    }
}
