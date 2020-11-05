require('./bootstrap');
require('inputmask');

import Vue from "vue";
import VueQrcodeReader from "vue-qrcode-reader";

Vue.use(VueQrcodeReader);

let app = new Vue({
    el: '#app',

    data: {
        isShowingCamera: false,
    },

    methods: {
        mostrarCamara: function () {
            this.isShowingCamera = !this.isShowingCamera;
        },
        onDecode: function (decodedString) {
            window.location = decodedString;
        },
    }
});
