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
        if (is_array($array))
        {
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
        return view('concurrio',['locacion'=>$locacion, 'isFull'=>$isFull, 'contagiado'=>$contagiado, 'salidaAbierta'=>$salidaAbierta]);
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store($locacionId, $userId)
    {
        $locacion = Locacion::find($locacionId);
        $user = Auth::user();
        $entrada = DB::table('concurrios')->where('locacionId', '=', $locacionId)
            ->where('userId','=', $userId)
            ->orderBy('id','desc')->first();

        if(($entrada == null or $entrada->salida <> null) and Auth::user()->locacion == 0) {
            if($locacion->Capacidad <> $locacion->CapacidadMax and $user->estado == 'No contagiado') {
                $entrada = new Concurrio();
                $entrada->entrada = date("Y-m-d h:i:sa");
                $entrada->userId = $userId;
                $entrada->locacionId = $locacionId;
                $entrada->save();
                $locacion->Capacidad += 1;
                DB::table('users')->where('id','=', Auth::user()->id)
                    ->update(['locacion'=>$locacionId]);
            } elseif ($user->estado <> 'No contagiado') {
                $isFull = false;
                $contagiado = true;
                $salidaAbierta = false;
                $param = serialize([$locacionId, $isFull, $contagiado, $salidaAbierta]);
                $parametros = base64_encode($param);
                return redirect('/concurrio/'.$parametros);
            } else {
                $isFull = true;
                $contagiado = false;
                $salidaAbierta = false;
                $param = serialize([$locacionId, $isFull, $contagiado, $salidaAbierta]);
                $parametros = base64_encode($param);
                return redirect('/concurrio/'.$parametros);
            }
        } elseif (Auth::user()->locacion <> $locacionId) {
            $isFull = false;
            $contagiado = false;
            $salidaAbierta = true;
            $param = serialize([$locacionId, $isFull, $contagiado, $salidaAbierta]);
            $parametros = base64_encode($param);
            return redirect('/concurrio/'.$parametros);
        } else {
            $concurrio = Concurrio::find($entrada->id);
            $concurrio->salida = date("Y-m-d h:i:sa");
            $concurrio->save();
            $locacion->Capacidad -= 1;
            DB::table('users')->where('id','=', Auth::user()->id)
                ->update(['locacion'=>0]);
        }
        $locacion->save();
        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
