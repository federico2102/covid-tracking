<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Lista de locaciones</h5>
        <a href="{{ url('/create/') }}" class="btn btn-sm btn-warning">Nueva locacion</a>

        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Capacidad</th>
                <th scope="col">CapacidadMax</th>
                <th scope="col">Geolocalizacion</th>
                <th scope="col">QR</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Imagenes</th>


            </tr>
            </thead>
            <tbody>
            @foreach($locaciones as $locacion)
                <tr>
                    <td data-label="Nombre:">{{ $locacion->Nombre }}</td>
                    <td data-label="Capacidad:">{{ $locacion->Capacidad }}</td>
                    <td data-label="CapacidadMax:">{{ $locacion->CapacidadMax }}</td>
                    <td data-label="Geolocacion:"><a href="{{ url('/map/'.$locacion->Geolocalizacion) }}" target="_blank">Click para abrir mapa</a></td>
                    @if($locacion->user_id == Auth::user()->id || Auth::user()->is_admin)
                        <td data-label="QR:"><a href="{{ $locacion->QR }}" target="_blank">Click para ver QR</a></td>
                    @else
                        <td data-label="QR:">No disponible</td>
                    @endif
                    <td data-label="Descripcion:">{{ $locacion->Descripcion }}</td>
                    @if($locacion->Imagen == null)
                        <td data-label="QR:">Sin imagenes</td>

                    @else
                        <td data-label="Imagen:"><a href="{{ url('/galeria/'.$locacion->id) }}" target="_blank">Click para ver imagenes</a></td>

                    @endif
                    @if($locacion->user_id == Auth::user()->id || Auth::user()->is_admin)
                        <td>
                            <a href="{{ url('/edit/'.$locacion->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        </td>
                    @endif


                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
