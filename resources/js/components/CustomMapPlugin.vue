<template>
    <GMapMap
        :center="center"
        :zoom="7.5"
        map-type-id="terrain"
        class="w-full h-full"
    >
            <GMapMarker
                :key="index"
                v-for="(m, index) in markers"
                :position="m.position"
                :clickable="true"
                :draggable="true"
                @click="center=m.position"
            >
                <GMapInfoWindow
                    :closeclick="true"
                    @closeclick="openMarker(null)"
                    :opened="openedMarkerId === m.id"
                    >
                    <div>
                        {{m}}
                    </div>
                </GMapInfoWindow>
            </GMapMarker>
    </GMapMap>
</template>

<script>
export default {
    name: "CustomMapPlugin",
    data() {
        return {
            openedMarkerId: null,
            center: {
                lat: 44.1544857,
                lng: -87.3248483
            },
            markers: []
        }
    },
    methods: {
        openMarker(id) {
            this.openedMarkerId = id
        }
    },
    mounted() {
        axios.get('/api/licensed-locations')
            .then((response) => {
                this.markers = response.data.map(location => {
                    return {
                        id: location.id,
                        position: {
                            lat: location.latitude,
                            lng: location.longitude,
                        },
                        title: location.name,
                    };
                })
            })
    }
}
</script>

<style scoped>

</style>
