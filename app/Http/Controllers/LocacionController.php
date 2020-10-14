<?php

namespace App\Http\Controllers;

use App\Models\Locacion;
use Illuminate\Http\Request;

class LocacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locaciones = Locacion::all();
        return view('locacion',['locaciones'=>$locaciones, 'layout'=>'index']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locaciones = Locacion::all();
        return view('locacion',['locaciones'=>$locaciones, 'layout'=>'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $locacion = new Locacion();
        $locacion->Nombre = $request->input('Nombre');
        $locacion->Capacidad = $request->input('Capacidad');
        $locacion->CapacidadMax = $request->input('CapacidadMax');
        $locacion->Geoposicion = $request->input('Geoposicion');
        $locacion->save();
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $locacion = Locacion::find('id');
        $locaciones = Locacion::all();
        return view('locaciones',['locaciones'=>$locaciones, 'locacion'=>$locacion, 'layout'=>'show']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $locacion = Locacion::find('id');
        $locaciones = Locacion::all();
        return view('locaciones',['locaciones'=>$locaciones, 'locacion'=>$locacion, 'layout'=>'edit']);
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
        $locacion = Locacion::find('id');
        $locacion->Nombre = $request->input('Nombre');
        $locacion->Capacidad = $request->input('Capacidad');
        $locacion->CapacidadMax = $request->input('CapacidadMax');
        $locacion->Geoposicion = $request->input('Geoposicion');
        $locacion->save();
        return redirect('/');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $locacion = Locacion::find('id');
        $locacion->delete();
        return redirect('/');
    }
}
