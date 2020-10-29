async function abrirCamara() {
    if (
        "mediaDevices" in navigator &&
        "getUserMedia" in navigator.mediaDevices
    ) {
        // ok, browser supports it
        const videoStream = await navigator.mediaDevices.getUserMedia({video: true});
    }
}
