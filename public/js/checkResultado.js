function checkResultado() {
    console.log('estoy aca');
    if(document.getElementById('fecha').value == "") {
        alert("seleccione una fecha");
        return false;
    } else {
        if(document.getElementById('resultado').value == ""){
            alert("seleccione un diagnostico");
            return false
        } else {
            if (document.getElementById('resultado').value == "Positivo") {
                document.getElementById('formAction').insertAdjacentHTML("afterbegin",
                    '<form name="informar" id="informar" action="/informarcontagio" method="get">');
                return document.getElementById('informar').submit();
            } else {
                document.getElementById('formAction').insertAdjacentHTML("afterbegin",
                    '<form name="informar" id="informar" action="/informartest" method="get">');
                return document.getElementById('informar').submit();
            }
        }
        }
}
