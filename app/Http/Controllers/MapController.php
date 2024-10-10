<?php

namespace App\Http\Controllers;

use App\Models\Locacion;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function show($geolocalizacion)
    {
        return view('map',['geolocalizacion'=>$geolocalizacion, 'layout'=>'show']);
    }

}
