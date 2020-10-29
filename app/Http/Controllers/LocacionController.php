<?php

namespace App\Http\Controllers;

use App\Models\Locacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

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
        $locaciones = Locacion::all(['id','Nombre','Capacidad','CapacidadMax','Geolocalizacion','QR','Descripcion']);
        return view('locacion', ['locaciones'=>$locaciones, 'layout'=>'index']);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $locaciones = Locacion::all(['id','Nombre','Capacidad','CapacidadMax','Geolocalizacion','QR','Descripcion']);
        return view('locacion',['locaciones'=>$locaciones, 'layout'=>'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $locacion = new Locacion();
        $locacion->Nombre = $request->input('Nombre');
        $locacion->Capacidad = 0;
        $locacion->CapacidadMax = $request->input('CapacidadMax');
        $locacion->Geolocalizacion = $request->input('Geolocalizacion');
        $locacion->QR = 'https://qrickit.com/api/qr.php?d=https://yo-estuve-ahi.herokuapp.com/concurrio/'; //
        $locacion->Descripcion = $request->input('Descripcion');
        $image_file = $request->file('Imagen');
        if($image_file <> null) {
            $extension = $image_file->getClientOriginalExtension();
            $imagen_nombre = time().'.'.$extension;
            $image_file->move('uploads/locaciones', $imagen_nombre);
            $locacion->Imagen = $imagen_nombre;
        }
        $locacion->save();
        $locacion->QR = $locacion->QR.$locacion->id.'&t=j&qrsize=300';
        $locacion->save();
        return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $locacion = Locacion::find($id);
        $locaciones = Locacion::all(['id','Nombre','Capacidad','CapacidadMax','Geolocalizacion','QR','Descripcion']);
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
        $locaciones = Locacion::all(['id','Nombre','Capacidad','CapacidadMax','Geolocalizacion','QR','Descripcion']);
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
        $locacion->Nombre = $request->input('Nombre');
        $locacion->CapacidadMax = $request->input('CapacidadMax');
        $locacion->Geolocalizacion = $request->input('Geolocalizacion');
        $locacion->Descripcion = $request->input('Descripcion');
        $image_file = $request->file('Imagen');
        if($image_file <> null) {
            $extension = $image_file->getClientOriginalExtension();
            $imagen_nombre = time().'.'.$extension;
            $image_file->move('uploads/locaciones', $imagen_nombre);
            $locacion->Imagen = $imagen_nombre;
        }
        $locacion->save();
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
