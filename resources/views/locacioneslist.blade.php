<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Lista de locaciones</h5>

        <table class="table">
            <thead class="thead-light">
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Capacidad</th>
                <th scope="col">CapacidadMax</th>
                <th scope="col">Geoposicion</th>

            </tr>
            </thead>
            <tbody>
            @foreach($locaciones as $locacion)
                <tr>
                    <td>{{ $locacion->Nombre }}</td>
                    <td>{{ $locacion->Capacidad }}</td>
                    <td>{{ $locacion->CapacidadMax }}</td>
                    <td>{{ $locacion->Geoposicion }}</td>
                    <td>

                        <a href="{{ url('/edit/'.$locacion->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    </td>


                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

