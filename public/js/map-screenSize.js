let map;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -34.603708, lng: -58.381601 },
        zoom: 13,
    });

    latLng = document.getElementById('latLng').value;
    const position = JSON.parse(latLng
        .replace(/\(/g, '[')
        .replace(/\)/g, ']')
    );
    const pos = {
        lat: position[0],
        lng: position[1],
    };

    marker = new google.maps.Marker();
    marker.setMap(map);
    marker.setPosition(pos);
    map.panTo(pos);
}
