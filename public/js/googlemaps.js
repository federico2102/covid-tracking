let map, infoWindow;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -34.603708, lng: -58.381601 },
        zoom: 10,
    });

    marker = new google.maps.Marker();
    map.addListener("click", (e) => {
        placeMarkerAndPanTo(e.latLng, map, marker);
    });

    infoWindow = new google.maps.InfoWindow();

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                infoWindow.setPosition(pos);
                infoWindow.setContent("Estas aquí.");
                infoWindow.open(map);
                map.setCenter(pos);
            },
            () => {
                handleLocationError(true, infoWindow, map.getCenter());
            }
        );
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(
        browserHasGeolocation
            ? "Error: El servicio de geolocalizacion ha fallado."
            : "Error: Tu browser no soporta geolocalización."
    );
    infoWindow.open(map);
}

function fillForm(latLng) {
    document.getElementById('geoloc').value = latLng;
}

function placeMarkerAndPanTo(latLng, map, marker) {
    marker.setMap(map);
    marker.setPosition(latLng);
    map.panTo(latLng);
    console.log(latLng);
    fillForm(latLng);
}
