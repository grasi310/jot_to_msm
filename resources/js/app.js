// import { L } from 'vue2-leaflet';
import 'leaflet/dist/leaflet.css';

import Vue from 'vue';
import router from './router';
import App from './components/App';

require('./bootstrap');


const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router
});

// fix icon for marker
import { Icon } from 'leaflet'
delete Icon.Default.prototype._getIconUrl;

Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png')
});
