<!DOCTYPE html>
<x-app-layout>
    <html lang=lang="{{ str_replace('_', '-', app()->getLocale()) }}>
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
            <title>Estadísticas</title>

{{--            <script src="{{ asset('js/map-screenSize.js') }}"></script>--}}
{{--            <script--}}
{{--                src="https://maps.googleapis.com/maps/api/js?key={{ config('googlemaps')['googlemaps_apikey'] }}&region=AR&language=es&callback=initMap&libraries=&v=weekly"--}}
{{--                defer--}}
{{--            ></script>--}}

        </head>

        <body>

        <div class="row header-container justify-content-center">
            <div class="header">
                <h1>Estadísticas</h1>
            </div>
        </div>

            <div class="container-fluid mt-4">
                <div class="container-fluid mt-4">
                    <div class="row justify-content-center">
                        <section class="col-md-8">
                            @include("adminpanellist")
                            <div id="map"></div>
                        </section>
                    </div>
                </div>
            </div>

{{--        <footer></footer>--}}
        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper)-->
{{--        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>--}}
{{--        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.3/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>--}}


        <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
                integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.3/js/bootstrap.min.js"
                integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
                crossorigin="anonymous"></script>
                -->
        </body>

    </x-slot>
    </html>
</x-app-layout>


