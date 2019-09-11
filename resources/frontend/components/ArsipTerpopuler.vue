<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-6 text-center text-uppercase mt-5 mb-3">Produk Hukum Terpopuler</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3 mt-3" v-for="value in lists">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">{{value.label}}</h5>
                        <p class="card-text">{{value.judul}}</p>
                        <a :href="value.url_download" class="btn btn-dark card-btn" target="_blank">Download PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                lists:""
            }
        },
        created(){
            this.getData();
        },
        methods:{
            getData(){
                this.$http('/api/terpopuler').then(res=>{
                    this.lists = res.data;
                })
            }
        }
    }
</script>