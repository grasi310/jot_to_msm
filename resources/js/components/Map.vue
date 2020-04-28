<template>

    <div style="height: 500px; width: 100%">
        <l-map
            v-if="showMap"
            :zoom="zoom"
            :center="center"
            :options="mapOptions"
            style="height: 80%"
            @update:center="centerUpdate"
            @update:zoom="zoomUpdate"
        >
            <v-geosearch :options="geosearchOptions" ></v-geosearch>
            <l-tile-layer
                :url="url"
                :attribution="attribution"
            />
            <l-marker :lat-lng="withPopup">
                <l-popup>
                    <div @click="showLongText">
                        HTB Imst
                        <p v-show="showParagraph">Testgelände MSM</p>
                    </div>
                </l-popup>
            </l-marker>
        </l-map>
    </div>

</template>

<script>
    import {latLng} from "leaflet";
    import {LMap, LTileLayer, LMarker, LPopup, LTooltip} from "vue2-leaflet";
    import { OpenStreetMapProvider } from 'leaflet-geosearch';
    import VGeosearch from 'vue2-leaflet-geosearch';

    // Vue.component('v-map', Vue2Leaflet.Map);
    // Vue.component('v-tilelayer', Vue2Leaflet.TileLayer);

    export default {
        name: "Map",
        components: {
            LMap,
            LTileLayer,
            LMarker,
            LPopup,
            LTooltip,
            VGeosearch,
        },
        data() {
            return {
                zoom: 13,
                center: latLng(47.213756, 10.7533608),
                url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                attribution:
                    '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                withPopup: latLng(47.213756, 10.7533608),
                currentZoom: 11.5,
                currentCenter: latLng(47.213756, 10.7533608),
                showParagraph: false,
                mapOptions: {
                    zoomSnap: 0.5
                },
                showMap: true,
                geosearchOptions: { // Important part Here
                    provider: new OpenStreetMapProvider(),
                },
            };
        },
        methods: {
            zoomUpdate(zoom) {
                this.currentZoom = zoom;
            },
            centerUpdate(center) {
                this.currentCenter = center;
            },
            showLongText() {
                this.showParagraph = !this.showParagraph;
            },
            innerClick() {
                alert("Click!");
            },
        }
    }
</script>

<style scoped>

</style>
