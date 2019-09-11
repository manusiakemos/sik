<template>
    <div id="produkHukumComponent">
        <div class="container-fluid bg-primary">
            <div class="container pb-5 pt-2">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-3 mb-3">
                                <label>Judul</label>
                                <input type="text" class="form-control" v-model="formData.judul">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Nomor</label>
                                <input type="text" class="form-control" v-model="formData.nomor">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Jenis</label>
                                <select-jenis v-model="formData.jenis"></select-jenis>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Tahun</label>
                                <year-picker v-model="formData.tahun"></year-picker>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary float-right" @click="fetchData">Cari Produk Hukum <span class="fas fa-search"></span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid" v-show="produkHukum">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 class="display-6 text-center text-uppercase mt-5 mb-3">Hasil Pencarian Produk Hukum</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3 mt-3" v-for="value in lastData">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title">{{value.label}}</h5>
                                <p class="card-text">{{ value.judul }}</p>
                                <a :href="value.url_download" target="_blank" class="btn btn-dark card-btn">Download PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <button class="btn btn-block mt-3 mb-3 btn-info" @click="next">Selanjutnya</button>
            </div>
        </div> <!-- /container fluid -->
    </div>
</template>

<script>
    import YearPicker from "../../backend/components/YearPicker";
    import SelectJenis from "../components/SelectJenis";
    export default {
        components:{
            YearPicker,SelectJenis
        },
        data() {
            return {
                title: 'Produk Hukum',
                produkHukum: '',
                lastData:'',
                errors:[],
                options: [],
                formData: {
                    "judul": "",
                    "jenis": "",
                    "nomor": "",
                    "tahun": "",
                }
            }
        },
        methods: {
            created(){
                this.fetchData()
            },
            next(){
                var l = this.produkHukum.links.next;
                if(l){
                    this.$http.post(l, this.formData).then(res => {
                        this.produkHukum = res.data;
                        res.data.data.forEach(v=>{
                            this.lastData.push(v);
                        });
                    })
                }else{
                    this.$noty.info('Data kosong');
                }
            },
            fetchData() {
                this.lastData='';
                this.$noty.info('Sedang mengambil data');
                this.getData('api/web-arsip');
            },
            getData(url){
                this.$http.post(url, this.formData).then(res => {
                    this.produkHukum = res.data;
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
        background: rgb(231,69,69);
        background: linear-gradient(180deg, rgba(231,69,69,1) 0%, rgba(231,69,69,1) 0%, rgba(255,255,255,1) 100%);
    }

    .card-news{
        height: 500px;
    }
</style>