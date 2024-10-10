<!DOCTYPE html>
<html>
<head>
    <title>Simple Map</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('googlemaps')['googlemaps_apikey'] }}&region=AR&language=es&callback=initMap&libraries=&v=weekly"
        defer
    ></script>
    <style type="text/css">
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
    </style>
    <script src="{{ asset('js/map-screenSize.js') }}"></script>
</head>
<body>
<input value="{{ $geolocalizacion }}" id="latLng" hidden>
<div id="map"></div>
</body>
</html>
