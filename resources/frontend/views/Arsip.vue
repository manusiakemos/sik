<template>
   <div id="arsip-view">
       <div class="container-fluid bg-primary">
           <div class="row">
               <div class="col-12">
                   <h1 class="display-6 text-center text-uppercase mt-5 mb-3 text-white">Produk Hukum</h1>
               </div>
           </div>
       </div>
       <arsip></arsip>
   </div>
</template>

<script>
    import Arsip from "../components/Arsip";
   export default {
       components:{
            Arsip
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