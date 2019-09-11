<template>
    <footer class="footer bg-dark m-0 p-0">
        <div class="container">
            <h4 class="text-white text-uppercase pt-5 display-5">Kontak Kami</h4>
            <div class="m-t-40 text-white">
                <div class="row">
                    <div class="col-md-6" v-html="kontak.data ? kontak.data.value : ''">
                    </div>
                </div>
            </div>
            <div class="table-responsive pt-5 pb-3">
                <div id='map'></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h6 class="text-white text-center mb-3 pb-5 display-6" v-html="copyright.data ? copyright.data.value : ''"></h6>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
    export default {
        created(){
          this.getSetting()
        },
        data(){
            return {
                "copyright" : "",
                "kontak" : ""
            }
        },
        methods:{
            getSetting() {
                this.$http.get('/api/web-setting/kontak').then(res=>{
                    this.kontak = res.data;
                });
                this.$http.get('/api/web-setting/copyright').then(res=>{
                    this.copyright = res.data;
                });
            },
        }
    }
</script>