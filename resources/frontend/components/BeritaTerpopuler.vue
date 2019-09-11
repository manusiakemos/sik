<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-6 text-center text-white text-uppercase mt-5 mb-3">Berita Terbaru</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-news mb-3">
                    <img src="/assets/img/news/img01.jpg" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        <p>
                            <a href="#" class="btn btn-dark card-btn">Go somewhere</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-news mb-3">
                    <img src="/assets/img/news/img01.jpg" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        <p>
                            <a href="#" class="btn btn-dark card-btn">Go somewhere</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-news mb-3">
                    <img src="/assets/img/news/img01.jpg" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        <p>
                            <a href="#" class="btn btn-dark card-btn">Go somewhere</a>
                        </p>
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