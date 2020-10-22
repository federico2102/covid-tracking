<!doctype html>
<x-app-layout>
    <html lang="en">
    <x-slot name="header">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="description" content="">
            <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
            <meta name="generator" content="Jekyll v4.1.1">

            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
                  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
                  crossorigin="anonymous">
            <link rel="stylesheet" href="{{asset('css/style.css')}}">

            <title>Check-in/Check-out</title>

            <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/pricing/">

            <!-- Bootstrap core CSS -->
            <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

            <style>
                .bd-placeholder-img {
                    font-size: 1.125rem;
                    text-anchor: middle;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    user-select: none;
                }

                @media (min-width: 768px) {
                    .bd-placeholder-img-lg {
                        font-size: 3.5rem;
                    }
                }
            </style>
            <!-- Custom styles for this template -->
            <link href="{{asset('css/pricing.css')}}" rel="stylesheet">
        </head>

        <body>
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4">Check-in/Check-out</h1>
            <p class="lead">Usted esta por hacer check-in/check-out en la siguiente locación</p>
        </div>
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

        <div class="card-body">
            <button type="button" class="btn btn-lg btn-block btn-primary"><a href="{{ url('/concurrio/Store/'.$locacion->id.'/'.$this->user->id) }}"></a>Confirmar</button>
        </div>

        </body>
    </x-slot>
    </html>
</x-app-layout>
