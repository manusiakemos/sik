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
                <div class="card mb-3" v-if="auth_user.role == 'kominfo'">
                    <div class="card-header">
                        <h4>Daftar Permintaan Tukar Point</h4>
                    </div>
                    <div class="card-body">
                        <request-point></request-point>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Kelahiran</h4>
                    </div>
                    <div class="card-body">
                        <pregnancy-tabs></pregnancy-tabs>
                    </div>
                </div>
            </div>
        </section>
        <!--modal-detail-->
        <modal id="modal-detail"
               :title="data && data.data ? data.data.pp_code : 'Detail'"
               ref="modal"
               type="xl"
               class="modal">
            <div class="row" v-if="data && data.data">
                <div class="col-12">
                    <div class="card shadow-sm card-dark mt-3">
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
                <div class="col-12">
                    <div class="card shadow-sm card-dark">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text-center mb-3">
                                    <figure class="figure">
                                        <img :src="data.mod.foto_kk" class="figure-img img-fluid rounded" alt="A generic square placeholder image with rounded corners in a figure.">
                                        <figcaption class="figure-caption">Foto KK.</figcaption>
                                    </figure>
                                </div>
                                <div class="col-md-6 text-center mb-3">
                                    <figure class="figure">
                                        <img :src="data.mod.buku_nikah" class="figure-img img-fluid rounded" alt="A generic square placeholder image with rounded corners in a figure.">
                                        <figcaption class="figure-caption">Buku Nikah.</figcaption>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm card-dark">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text-center mb-3">
                                    <figure class="figure">
                                        <img :src="data.mod.ktp_ibu" class="figure-img img-fluid rounded" alt="A generic square placeholder image with rounded corners in a figure.">
                                        <figcaption class="figure-caption">KTP Ibu.</figcaption>
                                    </figure>
                                </div>
                                <div class="col-md-6 text-center mb-3">
                                    <figure class="figure">
                                        <img :src="data.mod.ktp_ayah" class="figure-img img-fluid rounded" alt="A generic square placeholder image with rounded corners in a figure.">
                                        <figcaption class="figure-caption">KTP Ayah.</figcaption>
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
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
    import RequestPoint from "../components/sik/RequestPoint";
    import Modal from "../components/Modal";

    export default {
        mixins: [mixin],
        components: {
            PregnancyTabs, Modal, RequestPoint
        },
        created() {
            this.$http.get('/api/setting').then(res => {
                this.$store.commit("_setting", res.data);
            });

            this.listenChannel();
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
            listenChannel() {
                // Echo.channel('new-born-channel')
                //     .listen('.new-born-event', (res) => {
                //         this.$noty.info('Update Dashboard kelahiran');
                //         // this.getData();
                //     });
            },
        }
    };
</script>

