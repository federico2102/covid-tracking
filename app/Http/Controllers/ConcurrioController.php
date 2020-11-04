<?php

namespace App\Http\Controllers;

use App\Models\Locacion;
use App\Models\User;

class ConcurrioController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index($parametros)
    {
        $param = base64_decode($parametros);
        $array = unserialize($param);
        if (is_array($array)) {
            $locacion = Locacion::find($array[0]);
            $isFull = $array[1];
            $contagiado = $array[2];
            $salidaAbierta = $array[3];
        } else {
            $locacion = Locacion::find($array);
            $isFull = false;
            $contagiado = false;
            $salidaAbierta = false;
        }
        return view('concurrio', ['locacion' => $locacion, 'isFull' => $isFull, 'contagiado' => $contagiado, 'salidaAbierta' => $salidaAbierta]);
    }

    public function store($locacionId, $userId)
    {
        $locacion = Locacion::find($locacionId);
        $user = User::find($userId);

        if ($user->locacion == 0) {
            if ($locacion->Capacidad < $locacion->CapacidadMax and $user->estado == 'No contagiado') {
                $locacion->ingresarUsuario($userId);
                return redirect('home');
            } elseif ($user->estado <> 'No contagiado') {
                return $this->mostrarError($locacionId, false, true, false); // No puede ingresar porque esta contagiado
            } else {
                return $this->mostrarError($locacionId, true, false, false); // No puede ingresar porque la locacion esta llena
            }
        }  elseIf($locacionId == $user->locacion) {
            $locacion->registrarSalida($userId);
            return redirect('home');
            } else {
            return $this->mostrarError($locacionId, false, false, true); // No puede ingresar a dos locaciones al mismo tiempo
        }
    }

    public function mostrarError($locacion_id, $isFull, $contagiado, $salidaAbierta)
    {
        $param = serialize([$locacion_id, $isFull, $contagiado, $salidaAbierta]);
        $parametros = base64_encode($param);

        return redirect('/concurrio/'.$parametros);
    }
}


