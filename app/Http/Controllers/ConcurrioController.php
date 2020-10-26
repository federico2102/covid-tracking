<?php

namespace App\Http\Controllers;

use App\Models\Concurrio;
use App\Models\Locacion;
use Illuminate\Http\Request;
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
    public function index($id)
    {
        $locacion = Locacion::find($id);
        return view('concurrio',['locacion'=>$locacion]);
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
        $entrada = DB::table('concurrios')->where('locacionId', '=', $locacionId)->where('userId','=', $userId)->orderBy('id','desc')->first();
        if($entrada == null or $entrada->salida <> null) {
            $entrada = new Concurrio();
            $entrada->entrada = date("Y-m-d h:i:sa");
            $entrada->userId = $userId;
            $entrada->locacionId = $locacionId;
            $entrada->save();
            $locacion->Capacidad += 1;
        } else {
            $concurrio = Concurrio::find($entrada->id);
            $concurrio->salida = date("Y-m-d h:i:sa");
            $concurrio->save();
            $locacion->Capacidad -= 1;
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
