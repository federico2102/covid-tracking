let map;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -34.603708, lng: -58.381601 },
        zoom: 13,
    });

    latLng = document.getElementById('latLng');
    if(latLng != null) {
        latLng = latLng.value;
        const position = JSON.parse(latLng
            .replace(/\(/g, '[')
            .replace(/\)/g, ']')
        ); //Transformo la Geolocalizacion en un objeto
        const pos = {
            lat: position[0],
            lng: position[1],
        }; //Transformo el objeto en lo que espera el Marker

        marker = new google.maps.Marker();
        marker.setMap(map);
        marker.setPosition(pos);
        map.panTo(pos);
    } else {
        locaciones = document.getElementById('locaciones').value;
        locaciones = JSON.parse(locaciones); //Con esto hago que las locaciones sean un array
        locaciones.forEach((locacion) => {
            const position = JSON.parse(locacion.Geolocalizacion
                .replace(/\(/g, '[')
                .replace(/\)/g, ']')
            ); //Aca convierto la geolocalizacion en un objeto
            const pos = {
                lat: position[0],
                lng: position[1],
            }; //Transformo el objeto Geolocalizacion en el tipo que espera el Marker
            new google.maps.InfoWindow({
                position: pos,
                content: locacion.Nombre + "; Capacidad:" + locacion.Capacidad + "; CapacidadMax:" + locacion.CapacidadMax,
                map: map
            }); //Genero un nuevo marker para la localizacion iterada
        })
    }
}
