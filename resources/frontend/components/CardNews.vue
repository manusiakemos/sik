<template>
    <div class="card card-news mb-3">
        <img :src="value.gambar" class="card-img-top">
        <div class="card-body card-news-body">
            <h5 class="card-title">{{value.judul}}</h5>
            <div class="card-text" v-html="value.short_content"></div>
            <p class="card-text"><small class="text-muted">{{value.created_at}}</small></p>
            <p>
                <router-link :to="value.slug" class="btn btn-dark card-btn">Baca Selanjutnya</router-link>
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        props:['value']
    }
</script>