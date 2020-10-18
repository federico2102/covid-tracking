<?php

namespace App\Http\Controllers;

use App\Models\Locacion;
use Illuminate\Http\Request;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($geolocalizacion)
    {
        return view('map',['geolocalizacion'=>$geolocalizacion, 'layout'=>'map']);
    }

}
