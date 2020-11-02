<?php

namespace App\Http\Controllers;

use App\Models\Concurrio;
use App\Models\Locacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class concurrioController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function store($locacionId, $userId)
    {
        $locacion = Locacion::find($locacionId);
        $user = Auth::user();
        $entrada = $locacion->buscarEntrada($userId);

        if ($entrada == null and $user->locacion == 0) {
            if ($locacion->Capacidad <> $locacion->CapacidadMax and $user->estado == 'No contagiado') {
                $locacion->ingresarUsuario($userId);
            } elseif ($user->estado <> 'No contagiado') {
                $isFull = false;
                $contagiado = true;
                $salidaAbierta = false;
                $param = serialize([$locacionId, $isFull, $contagiado, $salidaAbierta]);
                $parametros = base64_encode($param);
                return redirect('/concurrio/' . $parametros);
            } else {
                $isFull = true;
                $contagiado = false;
                $salidaAbierta = false;
                $param = serialize([$locacionId, $isFull, $contagiado, $salidaAbierta]);
                $parametros = base64_encode($param);
                return redirect('/concurrio/' . $parametros);
            }
        }  elseIf($locacionId == $user->locacion) {
            $locacion->registrarSalida($userId);
            } else {
                $isFull = false;
                $contagiado = false;
                $salidaAbierta = true;
                $param = serialize([$locacionId, $isFull, $contagiado, $salidaAbierta]);
                $parametros = base64_encode($param);
                return redirect('/concurrio/' . $parametros);
        }
        return redirect('/home');
    }
}
