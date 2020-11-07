<?php

namespace App\Http\Controllers;

use App\Models\Locacion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LocacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $locaciones = Locacion::all();
        return view('locacion', ['locaciones'=>$locaciones, 'layout'=>'index']);
    }

    /**
     * Show the form for creating a new resource.
     *
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
     */
    public function store(Request $request)
    {
        Auth::user()->crearLocacion($request);
        return redirect('/location');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $locacion = Locacion::find($id);
        $locaciones = Locacion::all();
        return view('locacion',['locaciones'=>$locaciones, 'locacion'=>$locacion, 'layout'=>'show']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $locacion = Locacion::find($id);
        $locaciones = Locacion::all();
        return view('locacion',['locaciones'=>$locaciones, 'locacion'=>$locacion, 'layout'=>'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $locacion = Locacion::find($id);
        Auth::user()->updateLocacion($locacion, $request);
        return redirect('/home');
    }

    public function getImages($id)
    {
        $locacion = Locacion::find($id);
        $imagen = $locacion->Imagen;
        return view('galeria', ['imagen'=>$imagen]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $locacion = Locacion::find($id);
        $locacion->delete();
        return redirect('/home');
    }
}
