<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Estadísticas del sistema</h5>

        <table class="table">
{{--            <thead class="thead-light">--}}
{{--            <tr>--}}
{{--                <th scope="col">Nombre</th>--}}
{{--                <th scope="col">Capacidad</th>--}}


{{--            </tr>--}}
{{--            </thead>--}}
            <tbody>
                <tr>
                    <td>Cantidad de locaciones registradas</td>
                    <td>{{ $Locaciones}}</td>
                </tr>
                <tr>
                    <td>Cantidad de usuarios registrados</td>
                    <td>{{ $Usuarios}}</td>
                </tr>
                <tr>
                    <td>Cantidad de usuarios infectados</td>
                    <td>{{ $Infectados}}</td>
                </tr>
                <tr>
                    <td>Cantidad de usuarios en riesgo</td>
                    <td>{{ $Riesgo}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
