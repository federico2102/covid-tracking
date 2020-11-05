require('./bootstrap');
require('inputmask');

import Vue from "vue";
import VueQrcodeReader from "vue-qrcode-reader";

Vue.use(VueQrcodeReader);

let app = new Vue({
    el: '#app',

    data () {
        return {
            result: '',
            error: '',
            name: 'No one scanned',
            user: [],
            currentUser: '',
            messageShow: '',
            isShowingCamera: false,
        }
    },

    methods: {
        mostrarCamara: function () {
            this.isShowingCamera = !this.isShowingCamera;
        },
        onDecode: function (decodedString) {
            window.location = decodedString;
        },
        toggleMessage($msg) {
            this.messageShow = $msg;
            setTimeout(() => {
                this.messageShow = false;
            }, 4000);
        },

        async onInit (promise) {
            try {
                await promise
            } catch (error) {
                if (error.name === 'NotAllowedError') {
                    this.error = "ERROR: you need to grant camera access permisson"
                } else if (error.name === 'NotFoundError') {
                    this.error = "ERROR: no camera on this device"
                } else if (error.name === 'NotSupportedError') {
                    this.error = "ERROR: secure context required (HTTPS, localhost)"
                } else if (error.name === 'NotReadableError') {
                    this.error = "ERROR: is the camera already in use?"
                } else if (error.name === 'OverconstrainedError') {
                    this.error = "ERROR: installed cameras are not suitable"
                } else if (error.name === 'StreamApiNotSupportedError') {
                    this.error = "ERROR: Stream API is not supported in this browser"
                }
                this.toggleMessage(this.error);
            }
        }
    }
});
