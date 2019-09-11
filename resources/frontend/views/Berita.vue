<template>
    <div id="beritaComponent">
        <div class="container-fluid bg-white">
            <div class="container pb-0 pt-5">
                <div class="d-flex d-inline-block">
                    <input type="search" class="form-control mr-3" v-model="formData.search"
                           placeholder="Cari Berita">
                    <button class="btn btn-primary w-25" @click="searchData" type="button">
                        <span class="fas fa-search"></span>
                        <span class="d-none d-md-inline-block text-uppercase ml-2">Cari</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 class="display-6 text-center text-uppercase mt-5 mb-3">Berita</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3" v-for="value in lastData">
                        <card-news :value="value"></card-news>
                    </div>
                </div>
            </div>
            <div class="container pb-5 pt-2">
                <button class="btn btn-block btn-info" @click="next">Selanjutnya</button>
            </div>
        </div> <!-- /container fluid -->
    </div>
</template>

<script>
    import CardNews from "../components/CardNews";
    export default {
        components:{
          CardNews
        },
        data() {
            return {
                title: 'Berita',
                berita: '',
                lastData: '',
                errors: [],
                options: [],
                formData: {
                    "search": ""
                }
            }
        },
        created() {
            this.fetchData()
        },
        methods: {
            next() {
                var l = this.berita.links.next;
                if (l) {
                    this.$http.post(l, this.formData).then(res => {
                        this.berita = res.data;
                        res.data.data.forEach(v => {
                            this.lastData.push(v);
                        });
                    })
                } else {
                    this.$noty.info('Data kosong');
                }
            },
            fetchData() {
                this.lastData = '';
                this.$noty.info('Sedang mengambil data');
                this.getData('api/web-berita');
            },
            searchData() {
                this.fetchData()
            },
            getData(url) {
                this.$http.post(url, this.formData).then(res => {
                    this.berita = res.data;
                    this.lastData = res.data.data;
                    this.$noty.info(`Total data ${res.data.meta.total}`);
                })
            }
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
        background: rgb(231, 69, 69);
        background: linear-gradient(180deg, rgba(231, 69, 69, 1) 0%, rgba(231, 69, 69, 1) 0%, rgba(255, 255, 255, 1) 100%);
    }
</style>