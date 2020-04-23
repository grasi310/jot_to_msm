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
            <l-tile-layer
                :url="url"
                :attribution="attribution"
            />
            <l-marker :lat-lng="withPopup">
                <l-popup>
                    <div @click="innerClick">
                        HTB Imst
                        <p v-show="showParagraph">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque
                            sed pretium nisl, ut sagittis sapien. Sed vel sollicitudin nisi.
                            Donec finibus semper metus id malesuada.
                        </p>
                    </div>
                </l-popup>
            </l-marker>
        </l-map>
    </div>

</template>

<script>
    import {latLng} from "leaflet";
    import {LMap, LTileLayer, LMarker, LPopup, LTooltip} from "vue2-leaflet";

    export default {
        name: "Map",
        components: {
            LMap,
            LTileLayer,
            LMarker,
            LPopup,
            LTooltip
        },
        data() {
            return {
                zoom: 13,
                center: latLng(47.213756,10.7533608),
                url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                attribution:
                    '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
                withPopup: latLng(47.213756,10.7533608),
                currentZoom: 11.5,
                currentCenter: latLng(47.213756,10.7533608),
                showParagraph: false,
                mapOptions: {
                    zoomSnap: 0.5
                },
                showMap: true
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
            }
        }
    }
</script>

<style scoped>

</style>
