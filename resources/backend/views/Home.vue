<template>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ title }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <a href="#">{{ title }}</a>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <pregnancy-tabs class="bg-primary"></pregnancy-tabs>
            </div>
        </section>
        <!--modal-detail-->
        <modal id="modal-detail"
               :title="data && data.data ? data.data.pp_code : 'Detail'"
               ref="modal"
               type="lg"
               class="modal">
            <div class="row" v-if="data && data.data">
                <div class="col-12 text-center mb-3">
                    <a :href="data.mod.foto_kk" target="_blank">
                        <img :src="data.mod.foto_kk" alt="foto kk" class="img-fluid">
                    </a>
                </div>
                <div class="col-12 text-center mb-3">
                    <a :href="data.mod.buku_nikah" target="_blank">
                        <img :src="data.mod.buku_nikah" alt="buku nikah" class="img-fluid">
                    </a>
                </div>
                <div class="col-12">
                    <div class="card shadow mt-3">
                        <div class="card-body">
                            <div><span class="badge badge-danger">{{data.data.pp_status}}</span></div>
                            <div>
                                <h6 class="display-6 text-primary mt-3">Nomor KK {{data.data.pp_nokk}}</h6>
                            </div>
                            <p>
                                Alamat Paket <i>{{data.data.pp_alamat_paket}}</i>
                            </p>
                        </div>
                    </div>
                </div>
                <!--ibu-->
                <div class="col-12">
                    <a :href="data.mod.ktp_ibu" target="_blank">
                        <div class="card card-primary shadow">
                            <img :src="data.mod.ktp_ibu" alt="foto kk" class="img-card-top">
                            <div class="card-body">
                                <div>
                                    <h6 class="display-6 text-primary mt-3">Nomor KTP Ibu
                                        {{data.data.pp_noktp_ibu}}</h6>
                                </div>
                                <p class="text-dark">
                                    Nama Ibu : {{data.data.pp_nama_ibu}}
                                </p>
                                <p class="text-dark">
                                    Gol Darah : {{data.data.pp_goldarah_ibu}}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                <!--ayah-->
                <div class="col-12">
                    <a :href="data.mod.ktp_ayah" target="_blank">
                        <div class="card card-primary shadow">
                            <img :src="data.mod.ktp_ayah" alt="foto kk" class="img-card-top">
                            <div class="card-body">
                                <div>
                                    <h6 class="display-6 text-primary mt-3">Nomor KTP Ayah
                                        {{data.data.pp_noktp_ayah}}</h6>
                                </div>
                                <p class="text-dark">
                                    Nama Ayah : {{data.data.pp_nama_ayah}}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </modal>

        <!--modal-riwayat-->
        <modal type="md" id="modal-riwayat" title="Riwayat">
            <div class="list-group" v-if="data && data.data && data.detail.length > 0">
                <div v-for="v in data.detail"
                        class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{v.data.ppd_status}}</h5>
                        <b>{{v.data.ppd_date}}</b>
                    </div>
                    <p class="mb-1">
                        {{v.data.ppd_note}}
                    </p>
                    <!--<small>{{v.data.ppd_point}}POIN</small>-->
                </div>
            </div>
            <h4 v-else>Tidak ada riwayat</h4>
        </modal>
    </div>
</template>

<script>
    import {mixin} from "../mixin";
    import PregnancyTabs from "../components/sik/PregnanyTabs";
    import Modal from "../components/Modal";

    export default {
        mixins: [mixin],
        components: {
            PregnancyTabs, Modal
        },
        created(){
            this.$http.get('/api/setting').then(res=>{
                this.$store.commit("_setting", res.data);
            });
        },
        data() {
            return {
                data: '',
                title: "Dashboard",
                canvas_base64: "",
            };
        },
        watch: {
            detail() {
                this.showDetail()
            },
            riwayat() {
                this.showRiwayat()
            }
        },
        computed: {
            auth_user() {
                return this.$store.state.auth.user;
            },
            detail() {
                return this.$store.state.detail;
            },
            riwayat() {
                return this.$store.state.riwayat;
            }
        },
        methods: {
            print(selector) {
                let canvas = document.getElementById("bar-chart");
                this.canvas_base64 = canvas.toDataURL("image/png");
                this.$nextTick(() => {
                    this.$htmlToPaper(selector);
                })
            },
            showDetail() {
                this.showModal(this.detail.target);
                this.data = this.detail.data;
            },
            showRiwayat() {
                this.showModal(this.riwayat.target);
                this.data = this.riwayat.data;
            },
        }
    };
</script>

