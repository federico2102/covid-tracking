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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store($locacionId, $userId)
    {
        $locacion = Locacion::find($locacionId);
        $user = Auth::user();
        $entrada = $locacion->buscarEntrada($userId); // Me fijo si hay una entrada abierta en esta locacion y la traigo

        if ($entrada == null and $user->locacion == 0) {
            if ($locacion->Capacidad <> $locacion->CapacidadMax and $user->estado == 'No contagiado') {
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


