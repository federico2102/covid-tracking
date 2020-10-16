<form action="{{ url('/store') }}" method="post">
    @csrf
    <div class="form-group">
        <label>Nombre</label>
        <input name="Nombre" type="text" class="form-control" placeholder="Ingresar nombre" id="nombre"><a type="submit" class="btn btn-primary form-control" id="geoloc">verificar</a>
    </div>
    <div class="form-group">
        <label>CapacidadMax</label>
        <input name="CapacidadMax" type="text" class="form-control" placeholder="Ingresar capacidad maxima">
    </div>
    <div class="form-group">
        <label>Lat</label>
        <input name="coords_lat" type="text" class="form-control"  id="lat">
    </div>
    <div class="form-group">
        <label>Lng</label>
        <input name="coords_lng" type="text" class="form-control" id="lng">
    </div>

    <input type="submit" class="btn btn-info" value="Save">
    <input type="reset" class="btn btn-warning" value="Reset">
</form>
