<!doctype html>
<x-app-layout>
    <html lang="en">
    <x-slot name="header">
        <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
                  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
                  crossorigin="anonymous">
            <link rel="stylesheet" href="{{asset('css/style.css')}}">
            <title>Check-in/Check-out</title>

        </head>

        <body>

        <div class="row header-container justify-content-center">
            <div class="header">
                <h1>Check-in/Check-out</h1>
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title">Locación a ingresar</h5>
            <table class="table">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Capacidad</th>
                    <th scope="col">CapacidadMax</th>
                    <th scope="col">Geolocalizacion</th>
                    <th scope="col">QR</th>

                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Nombre:">{{ $locacion->Nombre }}</td>
                        <td data-label="Capacidad:">{{ $locacion->Capacidad }}</td>
                        <td data-label="CapacidadMax:">{{ $locacion->CapacidadMax }}</td>
                        <td data-label="Geolocacion:"><a href="{{ url('/map/'.$locacion->Geolocalizacion) }}" target="_blank">Click para abrir mapa</a></td>
                        <td data-label="QR:"><a href="{{ $locacion->QR }}" target="_blank">Click para ver QR</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

            @if(Auth::user() == null)
                <a> 0 </a>
                @else
                <form action="{{ url('/concurrio/store/'.$locacion->id.'/'.Auth::user()->id) }}" method="post">
            @endif
            @csrf
            <input type="submit" class="btn btn-info" value="Confirmar">
        </form>
            @if($contagiado)
                <a style="color:red"> No podra ingresar a ninguna locación hasta que su estado sea "No contagiado" </a>
            @elseif($isFull)
                <a style="color:red"> La locación a la que intenta ingresar se encuentra completa. Vuelva a intentar mas tarde </a>
            @endif
        </body>
    </x-slot>
    </html>
</x-app-layout>
