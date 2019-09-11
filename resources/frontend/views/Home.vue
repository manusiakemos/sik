<template>
    <div>
        <main role="main">

            <!-- Main jumbotron for a primary marketing message or call to action -->
            <div class="container-fluid bg-primary">
                <div class="jumbotron bg-primary text-center text-white m-0">
                    <div class="container">
                        <h1 class="display-4">{{$store.state.app_name}}</h1>
                        <p>Selamat Datang di Website Jaringan Dokumentasi dan Informasi Hukum DPRD Kabupaten
                            Tabalong</p>
                    </div>
                </div>
            </div>

           <arsip></arsip>

            <div class="container-fluid">
               <arsip-terbaru></arsip-terbaru>
            </div> <!-- /container fluid -->

            <div class="container-fluid bg-secondary">
               <arsip-terpopuler></arsip-terpopuler>
            </div> <!-- /container fluid -->

            <div class="container-fluid bg-primary">
              <berita-terbaru></berita-terbaru>
            </div>


        </main>
    </div>
</template>

<script>
    import Arsip from "../components/Arsip"
    import ArsipTerbaru from "../components/ArsipTerbaru"
    import ArsipTerpopuler from "../components/ArsipTerpopuler"
    import BeritaTerbaru from "../components/BeritaTerbaru"

    export default {
        components: {
            Arsip, ArsipTerbaru, ArsipTerpopuler, BeritaTerbaru
        }
    }
</script>

<style scoped>
    .card.bg-info, .card.bg-primary {
        height: 200px;
    }

    .card-btn {
        position: absolute;
        bottom: 15px;
    }

    .bg-gradient-primary {
        background: rgb(231,69,69);
        background: linear-gradient(180deg, rgba(231,69,69,1) 0%, rgba(231,69,69,1) 0%, rgba(255,255,255,1) 100%);
    }

    .card-news{
        height: 500px;
    }
</style>