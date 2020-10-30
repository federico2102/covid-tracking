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
        $details = [
            'title' => 'Estas en riesgo de contagio!',
            'body' => 'Una persona que compartio alguna locacion con vos informo estar contaagiada. Todo mal. Linchalo!!'
        ];

        $fecha_actual = date('Y-m-d h:i:sa');
        $fecha_minima = date('Y-m-d h:i:sa', strtotime($fecha_actual."- 7 days"));
        $locaciones = DB::table('concurrios')->select('locacionId', 'entrada', 'salida')
            ->distinct('locacionId')->where('entrada', '>=', $fecha_minima)
            ->where('userId', '=', $id)
            ->get();

        $victimas = DB::Table('concurrios')->select('userId', 'locacionId', 'entrada', 'salida')
            ->where('entrada', '>=', $fecha_minima)
            ->where('userId','<>', $id)
            ->get();

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
        }

        array_unique($victimas_id);

        $victimas_email = DB::table('users')->select('email')->whereIn('id', $victimas_id)
            ->where('estado', '=', 'No contagiado')->get();

        foreach ($victimas_email as $email){
            Mail::to($email->email)->send(new contagioMail($details));
        }

        DB::table('users')->where('id', '=',$id)->update(['estado'=>'Contagiado']);

        return redirect("/home");
    }
}
