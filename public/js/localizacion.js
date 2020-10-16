document.querySelector('#geoloc').addEventListener('click', getGeolocation);

function getGeolocation(){
    const lugar = document.getElementById('nombre').value;
    console.log(lugar);

    let url = "https://rapidapi.p.rapidapi.com/FindPlaceByText?text=";

    url += `${lugar}`;
    url += '&language=en';

    const data = null;

    const xhr = new XMLHttpRequest();
    xhr.withCredentials = true;

    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === this.DONE) {
        }
    });

    xhr.open("GET", url, true);
    xhr.setRequestHeader("x-rapidapi-host", "trueway-places.p.rapidapi.com");
    xhr.setRequestHeader("x-rapidapi-key", "f61f5de3f8msh6d6ebe604eb8faap1eac7bjsna21aa969ce0e");

    xhr.onload = function (){
        if(this.status === 200){
            const response = JSON.parse(this.responseText);
            console.log(response.results[0].location);
            const ubicacion = response.results[0].location;
             document.getElementById('lat').value = ubicacion.lat;
            document.getElementById('lng').value = ubicacion.lng;

        }
    }

    xhr.send(data);
}
