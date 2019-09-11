<template>
    <div>
        <div class="container-fluid">
            <div class="container">
                <img :src="berita.gambar" alt="berita" loading="lazy" class="img-fluid img-thumbnail mt-5" width="100%">
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="display-6 text-capitalize mt-5 mb-3">
                        {{berita.judul}}
                    </h1>
                </div>
            </div>
            <div class="d-inline-block">
                <small class="post-meta-date mr-3"><i class="fas fa-clock-o"></i>{{berita.created_at}}</small>
                <small class="post-meta-category text-info mr-3"><i class="fas fa-user text-info"></i> {{berita.creator ? berita.creator.nama : 'Anonym' }} </small>
                <small class="post-meta-comments text-info mr-3"><i class="fas fa-eye text-info"></i>Dilihat {{berita.dikunjungi}} kali</small>
            </div>
            <hr>
            <div class="row">
                <div class="col-12" v-html="berita.content"></div>
            </div>
            <div class="mb-5"></div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                berita:"",
                slug: this.$route.params.slug
            }
        },
        created(){
            this.getData();
        },
        methods:{
            getData(){
                this.$http.get(`/api/web-berita/detail/${this.slug}`).then(res=>{
                    this.berita = res.data;
                })
            }
        }
    }
</script>