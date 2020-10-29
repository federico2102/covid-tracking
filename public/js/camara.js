function abrirCamara() {
       navigator.mediaDevices.getUserMedia({video: true, audio: false});
}
