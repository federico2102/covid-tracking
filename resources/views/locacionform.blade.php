<form action="{{ url('/store') }}" method="post">
    @csrf
    <div class="form-group">
        <label>Nombre</label>
        <input name="Nombre" type="text" class="form-control" placeholder="Ingresar nombre">
    </div>
    <div class="form-group">
        <label>CapacidadMax</label>
        <input name="CapacidadMax" type="text" class="form-control" placeholder="Ingresar capacidad maxima">
    </div>
    <div class="form-group">
        <label>Geoposicion</label>
        <input name="Geoposicion" type="text" class="form-control" placeholder="Ingresar geoposicion">
    </div>
    <input type="submit" class="btn btn-info" value="Save">
    <input type="reset" class="btn btn-warning" value="Reset">
</form>
