<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="{{ asset('js/googlemaps.js') }}"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('googlemaps')['googlemaps_apikey'] }}&region=AR&language=es&callback=initMap&libraries=&v=weekly"
    defer
></script>

    <form enctype="multipart/form-data" @if($layout == 'create')
        action="{{ url('/store') }}" method="post">
        @else($layout == 'edit')
            action="{{ url('/update/'.$locacion->id) }}" method="post">
        @endif
@csrf
        <div class="form-group">
            <label>Nombre</label>
            <input name="Nombre" type="text" class="form-control" placeholder="Ingresar nombre" id="nombre" required>
    {{--        <a type="submit" class="btn btn-primary form-control" id="geoloc">verificar</a>--}}
        </div>
        <div class="form-group">
            <label>Ubicación</label>
            <div id="map"></div>
        </div>

        <div class="form-group">
            <label>CapacidadMax</label>
            <input name="CapacidadMax" type="text" class="form-control" placeholder="Ingresar capacidad maxima" required>
        </div>
        <div class="form-group">
            <input name="Geolocalizacion" type="text" class="form-control"  id="geoloc" hidden required>
        </div>
        <div class="form-group">
            <label>Descripcion</label>
            <input name="Descripcion" type="text" class="form-control" placeholder="Ingresar descripcion">
        </div>
        <div class="form-group">
            <label>Imagen</label>
            <input name="Imagen" type="file" id="Imagen" class="form-control-file">
        </div>
    {{--    <input type="text" value="{{ config('localizacion')['location_apikey'] }}" id="key" hidden>--}}
            <input type="submit" class="btn btn-info"
            @if($layout == 'create')
                   value="Save">
            @else($layout == 'edit')
                        value="Update">
            @endif
        <input type="reset" class="btn btn-warning" value="Reset">
    </form>
