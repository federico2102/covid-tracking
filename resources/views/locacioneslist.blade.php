<div class="col">
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Capacidad</th>
            <th scope="col">CapacidadMax</th>
        </tr>
        </thead>
        <tbody>
        @foreach($locaciones as $locacion)
        <tr>
            <td>{{$locacion->Nombre}}</td>
            <td>{{$locacion->Capacidad}}</td>
            <td>{{$locacion->CapacidadMax}}</td>
            <td>
                <a href="#" class="btn btn-sm btn-info">Show</a>
                <a href="{{ url('/edit/'.$locacion->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <a href="#" class="btn btn-sm btn-danger">Delete</a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
