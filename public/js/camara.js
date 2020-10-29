function abrirCamara() {
    if (
        "mediaDevices" in navigator &&
        "getUserMedia" in navigator.mediaDevices
    ) {
        // ok, browser supports it
       navigator.mediaDevices.getUserMedia({video: true});
    }
}
