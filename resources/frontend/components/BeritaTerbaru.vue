<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-6 text-center text-white text-uppercase mt-5 mb-3">Berita Terbaru</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4" v-for="value in lists.data">
                <card-news :value="value"></card-news>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .card.bg-info, .card.bg-primary {
        height: 200px;
    }

    .card-btn {
        position: absolute;
        bottom: 15px;
    }

    .bg-gradient-primary {
        background: rgb(231, 69, 69);
        background: linear-gradient(180deg, rgba(231, 69, 69, 1) 0%, rgba(231, 69, 69, 1) 0%, rgba(255, 255, 255, 1) 100%);
    }

    .card-news {
        height: 500px;
    }
</style>

<script>
    import CardNews from "../components/CardNews";
    export default {
        components:{
          CardNews
        },
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
                this.$http('/api/web-berita/terbaru').then(res=>{
                    this.lists = res.data;
                })
            }
        }
    }
</script>