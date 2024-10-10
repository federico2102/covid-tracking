<?php

namespace App\Http\Controllers;

use App\Models\Locacion;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConcurrioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $parametros
     * @return View|Factory|Application
     */
    public function index($parametros)
    {
        $param = base64_decode($parametros);
        $array = unserialize($param);
        $locacion = is_array($array) ? Locacion::find($array[0]) : Locacion::find($array);

        return view('concurrio', [
            'locacion' => $locacion,
            'isFull' => is_array($array) ? $array[1] : false,
            'contagiado' => is_array($array) ? $array[2] : false,
            'salidaAbierta' => is_array($array) ? $array[3] : false,
        ]);
    }

    public function store($locacionId, $userId): RedirectResponse
    {
        $locacion = Locacion::find($locacionId);
        $user = User::find($userId);

        if ($user->puedeIngresarALocacion($locacion)) {
            $locacion->ingresarUsuario($user);
            return redirect('home');
        } elseif ($user->noPuedeIngresarPorEstado()) {
            return $this->mostrarError($locacionId, false, true, false);
        } elseif ($locacion->estaLlena()) {
            return $this->mostrarError($locacionId, true, false, false);
        } elseif ($user->estaEnOtraLocacion($locacionId)) {
            return $this->mostrarError($locacionId, false, false, true);
        } else {
            $locacion->registrarSalida($user);
            return redirect('home');
        }
    }

    private function mostrarError($locacion_id, $isFull, $contagiado, $salidaAbierta): RedirectResponse
    {
        $param = serialize([$locacion_id, $isFull, $contagiado, $salidaAbierta]);
        return redirect('/concurrio/' . base64_encode($param));
    }
}
