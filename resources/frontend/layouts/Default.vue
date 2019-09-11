<template>
    <div id="defaultLayout">
        <navbar></navbar>
        <transition name="fade" mode="out-in">
            <router-view></router-view>
        </transition>
       <footer-component></footer-component>
    </div>
</template>

<style>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
    {
        opacity: 0;
    }

    #map {
        position: relative;
        bottom: 20px;
        width: 100%;
        height: 500px;
    }

</style>

<script>
    import Navbar from '../components/Navbar'
    import FooterComponent from '../components/Footer'

    export default {
        components: {
            Navbar,
            FooterComponent
        },
        data() {
            return {
                title: "Setting",
            };
        },
        mounted() {
           this.setMap();
        },
        methods:{
            setMap(){
                mapboxgl.accessToken = 'pk.eyJ1IjoibWFudXNpYWtlbW9zIiwiYSI6ImNqdzR2cHA5eDEyM3I0NnBjYXhmN3l0dWMifQ.gacuqFp1YJ_IkEERRO9Q7A';
                var map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    zoom: 15,
                    center: ['115.41892449494185','-2.176045279407404']
                });
//2.1756352,115.4165891,17z
                new mapboxgl.Marker()
                    .setLngLat(['115.41892449494185','-2.176045279407404'])
                    .addTo(map);
            }
        }
    };
</script>