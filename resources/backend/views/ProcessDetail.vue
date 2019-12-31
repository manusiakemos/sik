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
                <button class="btn btn-primary mb-3" @click="print">Cetak <span class="fa fa-print"></span></button>

                <div class="card" id="printMe">
                    <div class="card-body">
                        <h4>{{detail.data.data.pp_code}}</h4>
                        <table class="table">
                            <tr>
                                <td class="w-25">Status</td>
                                <td>{{detail.data.data.pp_status == 'born' ? 'lahir' : detail.data.data.pp_status}}</td>
                            </tr>
                            <tr>
                                <td>Nama Ibu</td>
                                <td>{{ detail.data.data.pp_nama_ibu }}</td>
                            </tr>
                            <tr>
                                <td>Nama Bidan</td>
                                <td>{{ detail.data.bidan.bidan_nama }}</td>
                            </tr>
                            <tr>
                                <td>No KK</td>
                                <td>{{detail.data.data.pp_nokk}}</td>
                            </tr>
                            <tr>
                                <td>No KK</td>
                                <td>{{detail.data.data.pp_alamat_paket}}</td>
                            </tr>
                        </table>

                        <div class="fotokk  mb-3">
                            <p>Kartu Keluarga</p>
                            <img :src="detail.data.mod.foto_kk" alt="bukunikah">
                        </div>
                        <hr>
                        <div class="bukunikah mb-3">
                            <p>Buku Nikah</p>
                            <img :src="detail.data.mod.buku_nikah" alt="buku_nikah">
                        </div>
                        <hr>
                        <div class="ktp_ayah mb-3">
                            <p>KTP Ayah</p>
                            <img :src="detail.data.mod.ktp_ayah" alt="ktp_ayah">
                        </div>
                        <hr>
                        <div class="ktp_ibu mb-3">
                            <p>KTP Ibu</p>
                            <img :src="detail.data.mod.ktp_ibu" alt="ktp_ibu">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        computed:{
            detail(){
                return this.$store.state.detail;
            }
        },
        data: function () {
            return {title: "Detail",}
        },
        methods: {
            print() {
                this.$htmlToPaper('printMe');
            },
        },
    }
</script>
